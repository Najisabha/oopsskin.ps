import { hsabateStatus, debugHsabate, syncHsabate } from "@/lib/hsabate";
import { arabicError } from "@/lib/api-messages";
import { NextRequest, NextResponse } from "next/server";
import { randomUUID } from "node:crypto";
import { z } from "zod";
import { all, db, get, put, products, settings, transaction } from "@/lib/db";
import { UserModel, OrderModel } from "@/lib/models";
import { cartOwner, currentUser, endSession, hashPassword, limitAuth, startSession, verifyPassword } from "@/lib/auth";
import { placeOrder, updateOrderStatus } from "@/lib/orders";
import { ApiError, quote, readCart, saveCart } from "@/lib/commerce";
import { authSchema, cartSchema, checkoutSchema, profileSchema, registerSchema, settingsSchema, voucherSchema } from "@/lib/validation";
import type { Product, User, Voucher } from "@/lib/types";

export const runtime = "nodejs";
export const maxDuration = 300;
export const dynamic = "force-dynamic";
type Context = { params: Promise<{ path: string[] }> };
const json = (value: unknown, status = 200) => NextResponse.json(value, { status, headers: { "Cache-Control": "no-store" } });

function toUser(doc: Record<string, unknown>): User {
  const { _id, passwordHash: _ph, ...rest } = doc;
  return { id: _id as string, ...rest } as User;
}
function toOrder(doc: Record<string, unknown>) {
  const { _id, requestKey: _rk, owner: _o, ...rest } = doc;
  return { id: _id as string, ...rest };
}

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

    if (path === "products" && method === "GET") return json({ products: await products() });
    if (parts[0] === "products" && parts.length === 2 && method === "GET") { const product = await get<Product>("products", parts[1]); if (!product?.active) throw new ApiError("Product not found.", 404); return json({ product }); }
    if (path === "settings" && method === "GET") return json({ settings: await settings() });
    if (path === "auth/current" && method === "GET") return json({ user });
    if ((path === "auth/register" || path === "auth/login") && method === "POST") {
      const raw = await body();
      const credentials = authSchema.parse(raw);
      if (!(await limitAuth(credentials.email))) throw new ApiError("Too many attempts. Please try again in 15 minutes.", 429);
      const guestOwner = await cartOwner(null);
      let account: User;
      await db();
      if (path.endsWith("register")) {
        const data = registerSchema.parse(raw);
        if (await UserModel.findOne({ email: data.email }).lean()) throw new ApiError("An account with this email already exists.", 409);
        account = { id: randomUUID(), name: data.name, email: data.email, phone: data.phone, address: "", city: "", role: "customer" };
        await UserModel.create({ _id: account.id, name: account.name, email: account.email, phone: account.phone, address: account.address, city: account.city, role: account.role, passwordHash: hashPassword(data.password) });
      } else {
        const row = await UserModel.findOne({ email: credentials.email }).lean();
        // Always run scrypt to avoid a fast path for unknown email addresses.
        const valid = verifyPassword(credentials.password, row ? String(row.passwordHash) : "00000000000000000000000000000000:" + "00".repeat(64));
        if (!row || !valid) throw new ApiError("Email or password is incorrect.", 401);
        account = toUser(row as Record<string, unknown>);
      }
      await transaction(async () => {
        const guest = await readCart(guestOwner);
        const existing = await readCart(`user:${account.id}`);
        for (const line of guest.items) { const match = existing.items.find(i => i.productId === line.productId); if (match) match.quantity = Math.min(99, match.quantity + line.quantity); else existing.items.push(line); }
        const clean = await quote(existing.items, existing.voucherCode || guest.voucherCode);
        await saveCart(`user:${account.id}`, { items: clean.items.map(({ productId, quantity }) => ({ productId, quantity })), voucherCode: clean.voucherCode });
        await saveCart(guestOwner, { items: [], voucherCode: "" });
      });
      await startSession(account.id);
      return json({ user: account }, path.endsWith("register") ? 201 : 200);
    }
    if (path === "auth/logout" && method === "POST") { await endSession(); return json({ ok: true }); }
    if (path === "profile" && method === "PATCH") {
      const account = { ...requireUser(), ...profileSchema.parse(await body()) };
      await db();
      await UserModel.updateOne({ _id: account.id }, { $set: { name: account.name, phone: account.phone, address: account.address, city: account.city } });
      return json({ user: account });
    }
    if (parts[0] === "cart") {
      const owner = await cartOwner(user);
      if (path === "cart" && method === "GET") { const stored = await readCart(owner); return json({ cart: await quote(stored.items, stored.voucherCode) }); }
      if (path === "cart" && method === "DELETE") { await saveCart(owner, { items: [], voucherCode: "" }); return json({ cart: await quote([]) }); }
      if (path === "cart" && method === "PATCH") {
        const data = cartSchema.parse(await body());
        const cart = await transaction(async () => {
          const previous = await readCart(owner);
          const items = previous.items.filter(i => i.productId !== data.productId);
          if (data.quantity) {
            const product = await get<Product>("products", data.productId);
            if (!product?.active || product.stock < data.quantity) throw new ApiError("The requested quantity is not available.");
            items.push(data);
          }
          const result = await quote(items, previous.voucherCode);
          await saveCart(owner, { items: result.items.map(({ productId, quantity }) => ({ productId, quantity })), voucherCode: result.voucherCode });
          return result;
        });
        return json({ cart });
      }
      if (path === "cart/voucher" && method === "POST") {
        const { code } = z.object({ code: z.string().max(40).transform(v => v.trim().toUpperCase()) }).parse(await body());
        const previous = await readCart(owner);
        const cart = await quote(previous.items, code, true);
        await saveCart(owner, { items: previous.items, voucherCode: code });
        return json({ cart });
      }
    }
    if (path === "orders" && method === "POST") {
      const customer = checkoutSchema.parse(await body());
      const owner = await cartOwner(user);
      const order = await placeOrder(owner, user?.id || null, customer);
      return json({ order }, 201);
    }
    if (path === "orders" && method === "GET") {
      const account = requireUser();
      await db();
      const docs = await OrderModel.find({ userId: account.id }).sort({ createdAt: -1 }).lean();
      return json({ orders: docs.map(d => toOrder(d as Record<string, unknown>)) });
    }
    if (parts[0] === "admin") {
      requireAdmin();
      if (path === "admin/hsabate" && method === "GET") return json(await hsabateStatus());
      if (path === "admin/hsabate/debug" && method === "POST") return json(await debugHsabate());
      if (path === "admin/hsabate/sync" && method === "POST") return json(await syncHsabate());
      if (parts[1] === "products" && method !== "GET") throw new ApiError("Products are managed in Hsabate. Edit there, then sync.", 409);
      if (path === "admin/overview" && method === "GET") {
        await db();
        const orderDocs = await OrderModel.find().sort({ createdAt: -1 }).lean();
        const userDocs = await UserModel.find().lean();
        return json({
          products: await all<Product>("products"),
          orders: orderDocs.map(d => toOrder(d as Record<string, unknown>)),
          customers: userDocs.map(d => toUser(d as Record<string, unknown>)),
          vouchers: await all<Voucher>("vouchers"),
          settings: await settings(),
        });
      }
      if (parts[1] === "orders" && parts[2] && method === "PATCH") {
        const { status } = z.object({ status: z.enum(["pending", "confirmed", "processing", "shipped", "delivered", "cancelled"]) }).parse(await body());
        const order = await updateOrderStatus(parts[2], status);
        return json({ order });
      }
      if (parts[1] === "vouchers" && method === "POST") { const data = voucherSchema.parse(await body()); const old = await get<Voucher>("vouchers", data.code); await put("vouchers", data.code, { ...data, used: old?.used || 0 }); return json({ ok: true }); }
      if (parts[1] === "vouchers" && parts[2] && method === "DELETE") { const old = await get<Voucher>("vouchers", parts[2]); if (!old) throw new ApiError("Voucher not found.", 404); await put("vouchers", old.code, { ...old, active: false }); return json({ ok: true }); }
      if (path === "admin/settings" && method === "PATCH") { const data = settingsSchema.parse(await body()); await put("settings", "store", data); return json({ settings: data }); }
    }
    throw new ApiError("Route not found.", 404);
  } catch (error) {
    if (error instanceof z.ZodError) return json({ message: error.issues.map(i => `${i.path.join(".")}: ${i.message}`).join("; "), messageAr: "يرجى التحقق من البيانات المدخلة والمحاولة مرة أخرى." }, 400);
    if (error instanceof ApiError) return json({ message: error.message, messageAr: arabicError(error.message) }, error.status);
    if (error instanceof Error && (error.message.includes("E11000") || error.message.includes("duplicate key"))) return json({ message: "This record already exists.", messageAr: "هذا السجل موجود بالفعل." }, 409);
    console.error("API request failed", error);
    return json({ message: "Something went wrong. Please try again.", messageAr: "حدث خطأ. يرجى المحاولة مرة أخرى." }, 500);
  }
}
export { handler as GET, handler as POST, handler as PATCH, handler as DELETE };
