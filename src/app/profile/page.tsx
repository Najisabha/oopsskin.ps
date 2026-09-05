import { redirect } from "next/navigation";
import { currentUser } from "@/lib/auth";
import { db } from "@/lib/db";
import { Profile } from "@/components/store/profile";
export const metadata = { title: "حسابي" };
export default async function Page() { const user = await currentUser(); if (!user) redirect("/login?next=/profile"); const orders = db().prepare("SELECT data FROM orders WHERE user_id=? ORDER BY rowid DESC").all(user.id).map(r => JSON.parse(String(r.data))); return <Profile account={user} orders={orders} />; }
