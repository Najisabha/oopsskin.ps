import { currentUser } from "@/lib/auth";
import { redirect } from "next/navigation";
import { notFound } from "next/navigation";
import { Admin } from "@/components/admin/admin";
import { all, db, settings } from "@/lib/db";
import type { Product, Voucher } from "@/lib/types";
export default async function Page({ params }: { params: Promise<{ section?: string[] }> }) { const user = await currentUser(); if (!user) redirect("/login?next=/admin"); if (user.role !== "admin") redirect("/profile"); const route = (await params).section || []; const section = route[0] || "overview"; if (route.length>1||!["overview","products","orders","customers","vouchers","settings"].includes(section)) notFound(); return <Admin section={section} initial={{ products: all<Product>("products"), orders: db().prepare("SELECT data FROM orders ORDER BY rowid DESC").all().map(r=>JSON.parse(String(r.data))), customers: db().prepare("SELECT data FROM users").all().map(r=>JSON.parse(String(r.data))), vouchers: all<Voucher>("vouchers"), settings: settings() }} />; }
