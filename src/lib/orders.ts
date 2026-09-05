import { randomUUID } from "node:crypto";
import { z } from "zod";
import { db, get, put, transaction } from "./db";
import { ApiError, quote, readCart, saveCart } from "./commerce";
import { checkoutSchema } from "./validation";
import type { Order, Product, Voucher } from "./types";

export function placeOrder(owner: string, userId: string | null, customer: z.infer<typeof checkoutSchema>): Order {
  return transaction(() => {
        const duplicate = db().prepare("SELECT data,owner FROM orders WHERE request_key=?").get(customer.requestKey);
        if (duplicate) { if (duplicate.owner !== owner) throw new ApiError("Request key already used.", 409); return JSON.parse(String(duplicate.data)) as Order; }
        const stored = readCart(owner);
        if (!stored.items.length) throw new ApiError("Your shopping bag is empty.");
        const cart = quote(stored.items, stored.voucherCode, true);
        const order: Order = { id: `OOPS-${randomUUID().slice(0, 8).toUpperCase()}`, userId: userId, name: customer.name, email: customer.email, phone: customer.phone, address: customer.address, city: customer.city, notes: customer.notes, items: cart.items.map(i => ({ productId: i.productId, name: i.product.name, price: i.product.price, quantity: i.quantity })), subtotal: cart.subtotal, shipping: cart.shipping, discount: cart.discount, total: cart.total, voucherCode: cart.voucherCode, status: "pending", createdAt: new Date().toISOString(), paymentMethod: "cash-on-delivery" };
        for (const item of cart.items) put("products", item.productId, { ...item.product, stock: item.product.stock - item.quantity });
        if (cart.voucherCode) { const voucher = get<Voucher>("vouchers", cart.voucherCode)!; put("vouchers", voucher.code, { ...voucher, used: voucher.used + 1 }); }
        db().prepare("INSERT INTO orders VALUES (?,?,?,?,?)").run(order.id, userId, customer.requestKey, owner, JSON.stringify(order));
        saveCart(owner, { items: [], voucherCode: "" });
        return order;
  });
}

export function updateOrderStatus(id: string, status: Order["status"]): Order {
  return transaction(() => {
    const row = db().prepare("SELECT data FROM orders WHERE id=?").get(id);
    if (!row) throw new ApiError("Order not found.",404);
    const old: Order = JSON.parse(String(row.data));
    const transitions: Record<Order["status"],Order["status"][]> = { pending:["confirmed","cancelled"],confirmed:["processing","cancelled"],processing:["shipped","cancelled"],shipped:["delivered"],delivered:[],cancelled:[] };
    if (old.status===status) return old;
    if (!transitions[old.status].includes(status)) throw new ApiError("This order status transition is not allowed.");
    if (status==="cancelled") for (const item of old.items) { const product=get<Product>("products",item.productId); if(product) put("products",product.id,{...product,stock:product.stock+item.quantity}); }
    const next={...old,status};
    db().prepare("UPDATE orders SET data=? WHERE id=?").run(JSON.stringify(next),old.id);
    return next;
  });
}
