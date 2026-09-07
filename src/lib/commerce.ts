import { db, get, settings } from "./db";
import { CartModel } from "./models";
import type { Cart, CartItem, Product, Voucher } from "./types";
export class ApiError extends Error { constructor(message: string, public status = 400) { super(message); } }
export const money = (value: number) => Math.round(value * 100) / 100;

export async function readCart(owner: string): Promise<{ items: CartItem[]; voucherCode: string }> {
  await db();
  const doc = await CartModel.findById(owner).lean();
  return doc ? { items: doc.items as CartItem[], voucherCode: doc.voucherCode ?? "" } : { items: [], voucherCode: "" };
}
export async function saveCart(owner: string, cart: { items: CartItem[]; voucherCode: string }) {
  await db();
  await CartModel.updateOne({ _id: owner }, { $set: { items: cart.items, voucherCode: cart.voucherCode } }, { upsert: true });
}
export async function quote(items: CartItem[], voucherCode = "", strict = false): Promise<Cart> {
  let warning = "";
  const lines = [];
  for (const item of items) {
    const product = await get<Product>("products", item.productId);
    if (!product?.active || product.stock < item.quantity) {
      if (strict) throw new ApiError(`${product?.name || "Product"} is unavailable in the requested quantity.`);
      warning = "Some cart quantities changed because stock is no longer available.";
      if (!product?.active || product.stock === 0) continue;
      lines.push({ ...item, quantity: Math.min(item.quantity, product.stock), product });
      continue;
    }
    lines.push({ ...item, product });
  }
  const subtotal = money(lines.reduce((sum, item) => sum + item.product.price * item.quantity, 0));
  let discount = 0;
  if (voucherCode) {
    const voucher = await get<Voucher>("vouchers", voucherCode);
    if (!voucher?.active || voucher.used >= voucher.maxUses || (voucher.expiresAt && new Date(voucher.expiresAt).getTime() < Date.now()) || subtotal < (voucher?.minimum ?? 0)) {
      if (strict) throw new ApiError("This voucher is invalid, expired, or its minimum order has not been reached.");
      voucherCode = "";
      warning = "Your voucher no longer applies to this cart.";
    } else discount = money(subtotal * voucher.percent / 100);
  }
  const config = await settings();
  const shipping = subtotal === 0 || subtotal >= config.freeShippingThreshold ? 0 : config.shippingFee;
  return { items: lines, subtotal, shipping, discount, total: money(subtotal - discount + shipping), voucherCode, ...(warning ? { warning } : {}) };
}
