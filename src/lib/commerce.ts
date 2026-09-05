import { db, get, settings } from "./db";
import type { Cart, CartItem, Product, Voucher } from "./types";
export class ApiError extends Error { constructor(message: string, public status = 400) { super(message); } }
export const money = (value: number) => Math.round(value * 100) / 100;
export function readCart(owner: string): { items: CartItem[]; voucherCode: string } { const row = db().prepare("SELECT data FROM carts WHERE owner=?").get(owner); return row ? JSON.parse(String(row.data)) : { items: [], voucherCode: "" }; }
export function saveCart(owner: string, cart: { items: CartItem[]; voucherCode: string }) { db().prepare("INSERT INTO carts VALUES (?,?) ON CONFLICT(owner) DO UPDATE SET data=excluded.data").run(owner, JSON.stringify(cart)); }
export function quote(items: CartItem[], voucherCode = "", strict = false): Cart {
  let warning = "";
  const lines = items.flatMap(item => {
    const product = get<Product>("products", item.productId);
    if (!product?.active || product.stock < item.quantity) {
      if (strict) throw new ApiError(`${product?.name || "Product"} is unavailable in the requested quantity.`);
      warning = "Some cart quantities changed because stock is no longer available.";
      if (!product?.active || product.stock === 0) return [];
      return [{ ...item, quantity: Math.min(item.quantity, product.stock), product }];
    }
    return [{ ...item, product }];
  });
  const subtotal = money(lines.reduce((sum, item) => sum + item.product.price * item.quantity, 0));
  let discount = 0;
  if (voucherCode) {
    const voucher = get<Voucher>("vouchers", voucherCode);
    if (!voucher?.active || voucher.used >= voucher.maxUses || (voucher.expiresAt && new Date(voucher.expiresAt).getTime() < Date.now()) || subtotal < (voucher?.minimum ?? 0)) {
      if (strict) throw new ApiError("This voucher is invalid, expired, or its minimum order has not been reached.");
      voucherCode = "";
      warning = "Your voucher no longer applies to this cart.";
    } else discount = money(subtotal * voucher.percent / 100);
  }
  const config = settings();
  const shipping = subtotal === 0 || subtotal >= config.freeShippingThreshold ? 0 : config.shippingFee;
  return { items: lines, subtotal, shipping, discount, total: money(subtotal - discount + shipping), voucherCode, ...(warning ? { warning } : {}) };
}
