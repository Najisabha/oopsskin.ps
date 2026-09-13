"use client";
import Image from "next/image";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { useState } from "react";
import { Heart, Menu, Search, ShoppingBag, UserRound } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Dialog, DialogContent, DialogTitle, DialogDescription } from "@/components/ui/dialog";
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetDescription, SheetTrigger } from "@/components/ui/sheet";
import { useStore } from "./provider";
import { cn } from "@/lib/utils";
import { defaultNavigation } from "@/lib/store-content";
export function Header() {
  const { t, language, toggleLanguage, cart, favorites, user, settings, currency } = useStore();
  const navigation = (settings.navigation ?? defaultNavigation).filter(link => link.visible);
  const pathname = usePathname();
  const router = useRouter();
  const [searchOpen, setSearchOpen] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);
  const count = cart.items.reduce((sum, item) => sum + item.quantity, 0);
  return <>
    <div className="bg-primary py-2.5 text-center text-xs leading-5 text-primary-foreground"><span>{t("A little love for your skin", "شوية حب لبشرتك")}</span><span className="mx-3 opacity-40">|</span>{t("Free delivery on orders over ", "توصيل مجاني للطلبات فوق ")}{currency(settings.freeShippingThreshold)}</div>
    <header className="sticky top-0 z-40 border-b bg-background/95 backdrop-blur-xl">
      <div className="page-container flex h-23 items-center justify-between gap-4">
        <div className="flex flex-1 items-center gap-2 sm:gap-4">
          <Sheet open={menuOpen} onOpenChange={setMenuOpen}><SheetTrigger asChild><Button variant="ghost" size="icon" className="lg:hidden" aria-label={t("Open menu", "فتح القائمة")}><Menu className="size-5" /></Button></SheetTrigger><SheetContent side={language === "ar" ? "right" : "left"}><SheetHeader><SheetTitle>Oops Skin</SheetTitle><SheetDescription>{t("Your little world of beauty", "عالمك الصغير للجمال")}</SheetDescription></SheetHeader><nav className="grid gap-2 px-6">{navigation.map(({href,label:en,labelAr:ar}, index) => <Link key={`${href}-${index}`} href={href} onClick={() => setMenuOpen(false)} className={cn("rounded-lg p-3", pathname === href && "bg-secondary text-primary")}>{t(en,ar)}</Link>)}<Link href={user ? "/profile" : "/login"} onClick={() => setMenuOpen(false)} className="p-3">{t("My account", "حسابي")}</Link></nav></SheetContent></Sheet>
          <button onClick={toggleLanguage} className="text-sm font-medium" aria-label={t("Switch to Arabic", "Switch to English")}>{language === "ar" ? "EN" : "عربي"}</button>
          <span className="hidden text-xs text-muted-foreground xl:block">{t("Tulkarm, Palestine", "طولكرم، فلسطين")}</span>
        </div>
        <Link href="/" aria-label={t("Oops Skin home", "أوبس سكين الرئيسية")} className="shrink-0"><Image src="/images/logo.svg" alt="Oops Skin" width={125} height={74} className="h-17 w-28 object-contain sm:w-32" priority /></Link>
        <div className="flex flex-1 items-center justify-end gap-0 sm:gap-2">
          <Button variant="ghost" size="icon" aria-label={t("Search products", "البحث عن المنتجات")} onClick={() => setSearchOpen(true)}><Search className="size-5" /></Button>
          <Button variant="ghost" size="icon" asChild className="hidden sm:inline-flex"><Link href={user ? "/profile" : "/login"} aria-label={t("My account", "حسابي")}><UserRound className="size-5" /></Link></Button>
          <Button variant="ghost" size="icon" asChild className="relative"><Link href="/favorites" aria-label={t("Favorites", "المفضلة")}><Heart className="size-5" />{favorites.length > 0 && <span className="absolute end-0 top-0 size-4 rounded-full bg-primary text-[10px] text-primary-foreground">{favorites.length}</span>}</Link></Button>
          <Button variant="ghost" size="icon" asChild className="relative"><Link href="/cart" aria-label={t("Shopping bag", "سلة التسوق")}><ShoppingBag className="size-5" />{count > 0 && <span className="absolute end-0 top-0 flex min-w-4 items-center justify-center rounded-full bg-primary px-1 text-[10px] text-primary-foreground">{count}</span>}</Link></Button>
        </div>
      </div>
      <nav aria-label={t("Main navigation", "القائمة الرئيسية")} className="hidden h-12 items-center justify-center gap-5 overflow-x-auto px-4 border-t border-border/60 lg:flex">{navigation.map(({href,label:en,labelAr:ar}, index) => <Link key={`${href}-${index}`} href={href} className={cn("relative flex h-full shrink-0 items-center text-xs font-medium transition-colors hover:text-primary after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:bg-primary", pathname === href ? "text-primary" : "after:hidden")}>{t(en,ar)}</Link>)}</nav>
    </header>
    <Dialog open={searchOpen} onOpenChange={setSearchOpen}><DialogContent><DialogTitle>{t("Find your next favorite", "ابحثي عن منتجك المفضل")}</DialogTitle><DialogDescription>{t("Search skincare, makeup, and more.", "ابحثي عن منتجات العناية والمكياج والمزيد.")}</DialogDescription><form className="flex gap-2" onSubmit={e => { e.preventDefault(); const query = String(new FormData(e.currentTarget).get("search") || "").trim(); router.push(`/all-products?search=${encodeURIComponent(query)}`); setSearchOpen(false); }}><Input name="search" aria-label={t("Search products", "البحث عن المنتجات")} placeholder={t("Try serum or lipstick…", "جربي سيروم أو أحمر شفاه…")} required /><Button type="submit"><Search className="size-4" />{t("Search", "بحث")}</Button></form></DialogContent></Dialog>
  </>;
}
