import type { Metadata } from "next";
import { cookies } from "next/headers";
import { StoreProvider } from "@/components/store/provider";
import { settings } from "@/lib/db";
import "./globals.css";
export const metadata: Metadata = { title: { default: "Oops Skin | جمالك علينا", template: "%s | Oops Skin" }, description: "Oops Skin — منتجات المكياج والعناية بالبشرة في طولكرم، فلسطين. جمالك علينا… وثقتك بتكبرنا.", icons: { icon: "/images/logo.svg" } };
export const runtime = "nodejs";
export const dynamic = "force-dynamic";
export default async function RootLayout({ children }: { children: React.ReactNode }) {
  const language = (await cookies()).get("oopsskin_language")?.value === "en" ? "en" : "ar";
  return <html lang={language} dir={language === "ar" ? "rtl" : "ltr"}><body><a href="#main-content" className="fixed start-4 top-4 z-100 -translate-y-40 rounded-lg bg-primary p-3 text-primary-foreground focus:translate-y-0">{language === "ar" ? "انتقل للمحتوى" : "Skip to content"}</a><StoreProvider initialLanguage={language} settings={await settings()}>{children}</StoreProvider></body></html>;
}
