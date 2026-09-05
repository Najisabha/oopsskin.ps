import { arabicError } from "@/lib/api-messages";
import { NextRequest, NextResponse } from "next/server";
import { randomUUID } from "node:crypto";
import { z } from "zod";
import { all, db, get, put, products, settings, transaction } from "@/lib/db";
import { cartOwner, currentUser, endSession, hashPassword, limitAuth, startSession, verifyPassword } from "@/lib/auth";
import { placeOrder, updateOrderStatus } from "@/lib/orders";
import { ApiError, quote, readCart, saveCart } from "@/lib/commerce";
import { authSchema, cartSchema, checkoutSchema, productSchema, profileSchema, registerSchema, settingsSchema, voucherSchema } from "@/lib/validation";
import type { Product, User, Voucher } from "@/lib/types";

export const runtime = "nodejs";
export const dynamic = "force-dynamic";
type Context = { params: Promise<{ path: string[] }> };
const json = (value: unknown, status = 200) => NextResponse.json(value, { status, headers: { "Cache-Control": "no-store" } });

async function handler(req: NextRequest, context: Context) {
  try {
    const parts = (await context.params).path;
    const path = parts.join("/");
    const method = req.method;
    if (method !== "GET") {
      const origin = req.headers.get("origin");
      if (origin && origin !== new URL(req.url).origin && origin !== process.env.APP_ORIGIN) throw new ApiError("Request origin is not allowed.", 403);
      if (Number(req.headers.get("content-length") || 0) > 65536) throw new ApiError("Request too large.", 413);
    }
    const body = async () => { const raw = await req.text(); if (raw.length > 65536) throw new ApiError("Request too large.", 413); try { return JSON.parse(raw); } catch { throw new ApiError("Invalid JSON."); } };
    const user = await currentUser();
    const requireUser = () => { if (!user) throw new ApiError("Please sign in to continue.", 401); return user; };
    const requireAdmin = () => { if (requireUser().role !== "admin") throw new ApiError("Administrator access required.", 403); };

    if (path === "products" && method === "GET") return json({ products: products() });
    if (parts[0] === "products" && parts.length === 2 && method === "GET") { const product = get<Product>("products", parts[1]); if (!product?.active) throw new ApiError("Product not found.", 404); return json({ product }); }
    if (path === "settings" && method === "GET") return json({ settings: settings() });
    if (path === "auth/current" && method === "GET") return json({ user });
    if ((path === "auth/register" || path === "auth/login") && method === "POST") {
      const raw = await body();
      const credentials = authSchema.parse(raw);
      if (!limitAuth(credentials.email)) throw new ApiError("Too many attempts. Please try again in 15 minutes.", 429);
      const guestOwner = await cartOwner(null);
      let account: User;
      if (path.endsWith("register")) {
        const data = registerSchema.parse(raw);
        if (db().prepare("SELECT id FROM users WHERE email=?").get(data.email)) throw new ApiError("An account with this email already exists.", 409);
        account = { id: randomUUID(), name: data.name, email: data.email, phone: data.phone, address: "", city: "", role: "customer" };
        db().prepare("INSERT INTO users VALUES (?,?,?,?)").run(account.id, account.email, hashPassword(data.password), JSON.stringify(account));
      } else {
        const row = db().prepare("SELECT data,password_hash FROM users WHERE email=?").get(credentials.email);
        // Always run scrypt to avoid a fast path for unknown email addresses.
        const valid = verifyPassword(credentials.password, row ? String(row.password_hash) : "00000000000000000000000000000000:" + "00".repeat(64));
        if (!row || !valid) throw new ApiError("Email or password is incorrect.", 401);
        account = JSON.parse(String(row.data));
      }
      transaction(() => {
        const guest = readCart(guestOwner);
        const existing = readCart(`user:${account.id}`);
        for (const line of guest.items) { const match = existing.items.find(i => i.productId === line.productId); if (match) match.quantity = Math.min(99, match.quantity + line.quantity); else existing.items.push(line); }
        const clean = quote(existing.items, existing.voucherCode || guest.voucherCode);
        saveCart(`user:${account.id}`, { items: clean.items.map(({ productId, quantity }) => ({ productId, quantity })), voucherCode: clean.voucherCode });
        saveCart(guestOwner, { items: [], voucherCode: "" });
      });
      await startSession(account.id);
      return json({ user: account }, path.endsWith("register") ? 201 : 200);
    }
    if (path === "auth/logout" && method === "POST") { await endSession(); return json({ ok: true }); }
    if (path === "profile" && method === "PATCH") {
      const account = { ...requireUser(), ...profileSchema.parse(await body()) };
      db().prepare("UPDATE users SET data=? WHERE id=?").run(JSON.stringify(account), account.id);
      return json({ user: account });
    }
    if (parts[0] === "cart") {
      const owner = await cartOwner(user);
      if (path === "cart" && method === "GET") return json({ cart: quote(readCart(owner).items, readCart(owner).voucherCode) });
      if (path === "cart" && method === "DELETE") { saveCart(owner, { items: [], voucherCode: "" }); return json({ cart: quote([]) }); }
      if (path === "cart" && method === "PATCH") {
        const data = cartSchema.parse(await body());
        const cart = transaction(() => {
          const previous = readCart(owner);
          const items = previous.items.filter(i => i.productId !== data.productId);
          if (data.quantity) {
            const product = get<Product>("products", data.productId);
            if (!product?.active || product.stock < data.quantity) throw new ApiError("The requested quantity is not available.");
            items.push(data);
          }
          const result = quote(items, previous.voucherCode);
          saveCart(owner, { items: result.items.map(({ productId, quantity }) => ({ productId, quantity })), voucherCode: result.voucherCode });
          return result;
        });
        return json({ cart });
      }
      if (path === "cart/voucher" && method === "POST") {
        const { code } = z.object({ code: z.string().max(40).transform(v => v.trim().toUpperCase()) }).parse(await body());
        const previous = readCart(owner);
        const cart = quote(previous.items, code, true);
        saveCart(owner, { items: previous.items, voucherCode: code });
        return json({ cart });
      }
    }
    if (path === "orders" && method === "POST") {
      const customer = checkoutSchema.parse(await body());
      const owner = await cartOwner(user);
      const order = placeOrder(owner, user?.id || null, customer);
      return json({ order }, 201);
    }
    if (path === "orders" && method === "GET") { const account = requireUser(); return json({ orders: db().prepare("SELECT data FROM orders WHERE user_id=? ORDER BY rowid DESC").all(account.id).map(r => JSON.parse(String(r.data))) }); }
    if (parts[0] === "admin") {
      requireAdmin();
      if (path === "admin/overview" && method === "GET") return json({ products: all<Product>("products"), orders: db().prepare("SELECT data FROM orders ORDER BY rowid DESC").all().map(r => JSON.parse(String(r.data))), customers: db().prepare("SELECT data FROM users").all().map(r => JSON.parse(String(r.data))), vouchers: all<Voucher>("vouchers"), settings: settings() });
      if (parts[1] === "products" && ["POST", "PATCH"].includes(method)) {
        const data = productSchema.parse(await body());
        const old = parts[2] ? get<Product>("products", parts[2]) : undefined;
        if (method === "PATCH" && !old) throw new ApiError("Product not found.", 404);
        const product: Product = { ...data, id: old?.id || randomUUID(), createdAt: old?.createdAt || new Date().toISOString(), syncedAt: old?.syncedAt || null };
        put("products", product.id, product);
        return json({ product }, old ? 200 : 201);
      }
      if (parts[1] === "products" && parts[2] && method === "DELETE") { const old = get<Product>("products", parts[2]); if (!old) throw new ApiError("Product not found.", 404); put("products", old.id, { ...old, active: false }); return json({ ok: true }); }
      if (parts[1] === "orders" && parts[2] && method === "PATCH") {
        const { status } = z.object({ status: z.enum(["pending", "confirmed", "processing", "shipped", "delivered", "cancelled"]) }).parse(await body());
        const order = updateOrderStatus(parts[2],status);
        return json({ order });
      }
      if (parts[1] === "vouchers" && method === "POST") { const data = voucherSchema.parse(await body()); const old = get<Voucher>("vouchers", data.code); put("vouchers", data.code, { ...data, used: old?.used || 0 }); return json({ ok: true }); }
      if (parts[1] === "vouchers" && parts[2] && method === "DELETE") { const old = get<Voucher>("vouchers", parts[2]); if (!old) throw new ApiError("Voucher not found.", 404); put("vouchers", old.code, { ...old, active: false }); return json({ ok: true }); }
      if (path === "admin/settings" && method === "PATCH") { const data = settingsSchema.parse(await body()); put("settings", "store", data); return json({ settings: data }); }
    }
    throw new ApiError("Route not found.", 404);
  } catch (error) {
    if (error instanceof z.ZodError) return json({ message: error.issues.map(i => `${i.path.join(".")}: ${i.message}`).join("; "), messageAr: "يرجى التحقق من البيانات المدخلة والمحاولة مرة أخرى." }, 400);
    if (error instanceof ApiError) return json({ message: error.message, messageAr: arabicError(error.message) }, error.status);
    if (error instanceof Error && error.message.includes("UNIQUE constraint")) return json({ message: "This record already exists.", messageAr: "هذا السجل موجود بالفعل." }, 409);
    console.error("API request failed", error);
    return json({ message: "Something went wrong. Please try again.", messageAr: "حدث خطأ. يرجى المحاولة مرة أخرى." }, 500);
  }
}
export { handler as GET, handler as POST, handler as PATCH, handler as DELETE };
