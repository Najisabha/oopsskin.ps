import { redirect } from "next/navigation";
import { currentUser } from "@/lib/auth";
export const metadata = { title: "إدارة المتجر", robots: { index: false, follow: false } };
export default async function Layout({ children }: { children: React.ReactNode }) { const user = await currentUser(); if (!user) redirect("/login?next=/admin"); if (user.role!=="admin") redirect("/profile"); return children; }
