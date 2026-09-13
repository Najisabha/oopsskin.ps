import { currentUser } from "@/lib/auth";
import { redirect } from "next/navigation";
import { notFound } from "next/navigation";
import { Admin } from "@/components/admin/admin";
import { all, db, settings } from "@/lib/db";
import { OrderModel, UserModel } from "@/lib/models";
import type { Order, Product, User, Voucher } from "@/lib/types";
function toOrder(doc: Record<string, unknown>): Order {
  const { _id, requestKey: _rk, owner: _o, ...rest } = doc;
  return { id: _id as string, ...rest } as Order;
}
function toUser(doc: Record<string, unknown>): User {
  const { _id, passwordHash: _ph, ...rest } = doc;
  return { id: _id as string, ...rest } as User;
}
export default async function Page({ params }: { params: Promise<{ section?: string[] }> }) {
  const user = await currentUser();
  if (!user) redirect("/login?next=/admin");
  if (user.role !== "admin") redirect("/profile");
  const route = (await params).section || [];
  const section = route[0] || "overview";
  if (route.length > 1 || !["overview", "products", "orders", "customers", "vouchers", "settings", "hsabate", "pages", "navigation"].includes(section)) notFound();
  await db();
  const orderDocs = await OrderModel.find().sort({ createdAt: -1 }).lean();
  const userDocs = await UserModel.find().lean();
  const orders = orderDocs.map(d => toOrder(d as Record<string, unknown>));
  const customers = userDocs.map(d => toUser(d as Record<string, unknown>));
  return <Admin section={section} initial={{ products: await all<Product>("products"), orders, customers, vouchers: await all<Voucher>("vouchers"), settings: await settings() }} />;
}
