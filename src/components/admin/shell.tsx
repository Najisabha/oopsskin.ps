"use client";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { useStore } from "@/components/store/provider";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
export const adminTabs = [
  ["overview", "Overview", "نظرة عامة"], ["products", "Products", "المنتجات"], ["pages", "Pages & products", "الصفحات والمنتجات"],
  ["navigation", "Navigation", "القائمة الرئيسية"], ["orders", "Orders", "الطلبات"], ["customers", "Customers", "العملاء"],
  ["vouchers", "Vouchers", "القسائم"], ["settings", "Settings", "الإعدادات"], ["hsabate", "API & Sync", "API والمزامنة"],
];
export function AdminShell({ children }: { children: React.ReactNode }) {
  const { t, language, toggleLanguage, logout } = useStore();
  const pathname = usePathname();
  const router = useRouter();
  return <div className="min-h-screen bg-slate-50 text-slate-900">
    <header className="flex flex-wrap items-center justify-between gap-3 border-b bg-white px-5 py-4"><Link href="/admin" className="font-semibold">Oops Skin <span className="ms-2 text-xs text-slate-500">{t("Administration", "الإدارة")}</span></Link><div className="flex items-center gap-3"><button onClick={toggleLanguage} aria-label={language === "ar" ? "Switch to English" : "Switch to Arabic"}>{language === "ar" ? "EN" : "عربي"}</button><Button variant="outline" size="sm" asChild><Link href="/">{t("View storefront", "عرض المتجر")}</Link></Button><Button variant="ghost" size="sm" onClick={async () => { await logout(); router.push("/login"); router.refresh(); }}>{t("Sign out", "تسجيل الخروج")}</Button></div></header>
    <div className="grid lg:grid-cols-[230px_minmax(0,1fr)]"><aside className="border-b bg-slate-900 p-3 text-white lg:min-h-[calc(100vh-73px)] lg:border-b-0"><nav aria-label={t("Admin navigation", "قائمة الإدارة")} className="flex gap-1 overflow-x-auto lg:sticky lg:top-4 lg:flex-col">{adminTabs.map(([key,en,ar]) => { const href = key === "overview" ? "/admin" : `/admin/${key}`; return <Link key={key} href={href} aria-current={pathname === href ? "page" : undefined} className={cn("shrink-0 rounded-lg px-4 py-3 text-sm", pathname === href ? "bg-white text-slate-900" : "text-slate-300 hover:bg-slate-800")}>{t(en,ar)}</Link>; })}</nav></aside><main id="main-content" className="min-w-0">{children}</main></div>
  </div>;
}
