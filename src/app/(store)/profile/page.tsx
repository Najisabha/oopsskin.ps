import { redirect } from "next/navigation";
import { currentUser } from "@/lib/auth";
import { db } from "@/lib/db";
import { OrderModel } from "@/lib/models";
import { Profile } from "@/components/store/profile";
import type { Order } from "@/lib/types";
export const metadata = { title: "حسابي" };
function toOrder(doc: Record<string, unknown>): Order {
  const { _id, requestKey: _rk, owner: _o, ...rest } = doc;
  return { id: _id as string, ...rest } as Order;
}
export default async function Page() {
  const user = await currentUser();
  if (!user) redirect("/login?next=/profile");
  await db();
  const docs = await OrderModel.find({ userId: user.id }).sort({ createdAt: -1 }).lean();
  const orders = docs.map(d => toOrder(d as Record<string, unknown>));
  return <Profile account={user} orders={orders} />;
}
