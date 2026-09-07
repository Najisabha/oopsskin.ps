import { randomUUID } from "node:crypto";
import { z } from "zod";
import { db, get, put, transaction } from "./db";
import { OrderModel } from "./models";
import { ApiError, quote, readCart, saveCart } from "./commerce";
import { checkoutSchema } from "./validation";
import type { Order, Product, Voucher } from "./types";

function toOrder(doc: Record<string, unknown>): Order {
  const { _id, requestKey: _rk, owner: _o, ...rest } = doc;
  return { id: _id as string, ...rest } as Order;
}

export async function placeOrder(owner: string, userId: string | null, customer: z.infer<typeof checkoutSchema>): Promise<Order> {
  return transaction(async () => {
    await db();
    const duplicate = await OrderModel.findOne({ requestKey: customer.requestKey }).lean();
    if (duplicate) {
      if (duplicate.owner !== owner) throw new ApiError("Request key already used.", 409);
      return toOrder(duplicate as Record<string, unknown>);
    }
    const stored = await readCart(owner);
    if (!stored.items.length) throw new ApiError("Your shopping bag is empty.");
    const cart = await quote(stored.items, stored.voucherCode, true);
    const order: Order = {
      id: `OOPS-${randomUUID().slice(0, 8).toUpperCase()}`,
      userId,
      name: customer.name,
      email: customer.email,
      phone: customer.phone,
      address: customer.address,
      city: customer.city,
      notes: customer.notes,
      items: cart.items.map(i => ({ productId: i.productId, name: i.product.name, price: i.product.price, quantity: i.quantity })),
      subtotal: cart.subtotal,
      shipping: cart.shipping,
      discount: cart.discount,
      total: cart.total,
      voucherCode: cart.voucherCode,
      status: "pending",
      createdAt: new Date().toISOString(),
      paymentMethod: "cash-on-delivery",
    };
    for (const item of cart.items) await put("products", item.productId, { ...item.product, stock: item.product.stock - item.quantity });
    if (cart.voucherCode) { const voucher = (await get<Voucher>("vouchers", cart.voucherCode))!; await put("vouchers", voucher.code, { ...voucher, used: voucher.used + 1 }); }
    const { id, ...rest } = order;
    await OrderModel.create({ _id: id, requestKey: customer.requestKey, owner, ...rest });
    await saveCart(owner, { items: [], voucherCode: "" });
    return order;
  });
}

export async function updateOrderStatus(id: string, status: Order["status"]): Promise<Order> {
  return transaction(async () => {
    await db();
    const doc = await OrderModel.findById(id).lean();
    if (!doc) throw new ApiError("Order not found.", 404);
    const old = toOrder(doc as Record<string, unknown>);
    const transitions: Record<Order["status"], Order["status"][]> = { pending: ["confirmed", "cancelled"], confirmed: ["processing", "cancelled"], processing: ["shipped", "cancelled"], shipped: ["delivered"], delivered: [], cancelled: [] };
    if (old.status === status) return old;
    if (!transitions[old.status].includes(status)) throw new ApiError("This order status transition is not allowed.");
    if (status === "cancelled") for (const item of old.items) { const product = await get<Product>("products", item.productId); if (product) await put("products", product.id, { ...product, stock: product.stock + item.quantity }); }
    const next = { ...old, status };
    await OrderModel.updateOne({ _id: old.id }, { $set: { status } });
    return next;
  });
}
