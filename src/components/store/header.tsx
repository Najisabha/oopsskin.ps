"use client";
import Image from "next/image";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { useEffect, useRef, useState } from "react";
import { ChevronDown, Heart, Menu, Search, ShoppingCart, UserRound } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Dialog, DialogContent, DialogTitle, DialogDescription } from "@/components/ui/dialog";
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetDescription, SheetTrigger } from "@/components/ui/sheet";
import { ProductImage } from "./product-image";
import { useStore } from "./provider";
import { cn } from "@/lib/utils";
import { defaultNavigation, type MenuCategory } from "@/lib/store-content";
const navButton = "text-navbar-foreground hover:bg-white/15 hover:text-navbar-foreground";
const navLink = "relative flex h-full shrink-0 items-center gap-1 text-xs font-medium text-navbar-foreground/85 transition-colors hover:text-navbar-foreground after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:bg-navbar-foreground";
function useHideOnScroll(active: boolean) {
  const [hidden, setHidden] = useState(false);
  const lastY = useRef(0);
  useEffect(() => {
    if (!active) return;
    let frame = 0;
    const onScroll = () => {
      if (frame) return;
      frame = requestAnimationFrame(() => {
        frame = 0;
        const y = window.scrollY;
        const delta = y - lastY.current;
        if (Math.abs(delta) < 8) return;
        // Never hide while the announcement bar is still in view.
        setHidden(delta > 0 && y > 120);
        lastY.current = y;
      });
    };
    lastY.current = window.scrollY;
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => { window.removeEventListener("scroll", onScroll); if (frame) cancelAnimationFrame(frame); };
  }, [active]);
  // While a menu or search dialog is open the header always stays put.
  return active && hidden;
}
function CategoryMenu({ href, label, active, categories }: { href: string; label: string; active: boolean; categories: MenuCategory[] }) {
  const { t, currency } = useStore();
  const [open, setOpen] = useState(false);
  const [hovered, setHovered] = useState<string | null>(null);
  const closeTimer = useRef<ReturnType<typeof setTimeout> | undefined>(undefined);
  useEffect(() => () => clearTimeout(closeTimer.current), []);
  const show = () => { clearTimeout(closeTimer.current); setOpen(true); };
  // Small grace period so the pointer can cross the gap between trigger and panel.
  const hide = () => { clearTimeout(closeTimer.current); closeTimer.current = setTimeout(() => setOpen(false), 120); };
  const close = () => { clearTimeout(closeTimer.current); setOpen(false); };
  const shown = categories.find(c => c.name === hovered) ?? categories[0];
  if (!categories.length) return <Link href={href} className={cn(navLink, active ? "text-navbar-foreground" : "after:hidden")}>{label}</Link>;
  return <div className="static flex h-full items-center" onMouseEnter={show} onMouseLeave={hide} onFocus={show} onBlur={e => { if (!e.currentTarget.contains(e.relatedTarget)) hide(); }} onKeyDown={e => { if (e.key === "Escape") close(); }}>
    <Link href={href} aria-expanded={open} aria-haspopup="true" className={cn(navLink, active ? "text-navbar-foreground" : "after:hidden")}>{label}<ChevronDown className={cn("size-3.5 transition-transform", open && "rotate-180")} aria-hidden /></Link>
    <div className={cn("absolute inset-x-0 top-full z-40 border-t border-white/15 bg-background text-foreground shadow-xl transition-all duration-150 motion-reduce:transition-none", open ? "opacity-100" : "pointer-events-none -translate-y-1 opacity-0")}>
      <div className="page-container grid grid-cols-[minmax(11rem,1fr)_3fr] gap-8 py-7">
        <ul className="grid content-start gap-0.5 border-e pe-4">
          {categories.map(c => <li key={c.name}><Link href={c.href} onClick={close} tabIndex={open ? undefined : -1} onMouseEnter={() => setHovered(c.name)} onFocus={() => setHovered(c.name)} className={cn("flex items-center justify-between gap-2 rounded-md px-3 py-2 text-sm transition-colors hover:bg-secondary", shown?.name === c.name ? "bg-secondary font-medium text-primary" : "text-foreground/80")}>
            {t(c.name, c.nameAr)}<span className="text-[10px] text-muted-foreground">{c.count}</span>
          </Link></li>)}
        </ul>
        <div>
          <div className="mb-4 flex items-baseline justify-between gap-3">
            <p className="text-xs font-medium uppercase tracking-widest text-muted-foreground">{shown ? t(shown.name, shown.nameAr) : ""}</p>
            {shown && <Link href={shown.href} onClick={close} tabIndex={open ? undefined : -1} className="text-xs font-medium text-primary hover:underline">{t("View all", "شوفي الكل")} →</Link>}
          </div>
          <div className="grid grid-cols-4 gap-4">
            {shown?.products.map(p => <Link key={p.id} href={`/product/${encodeURIComponent(p.slug)}`} onClick={close} tabIndex={open ? undefined : -1} className="group grid gap-2">
              <div className="relative aspect-square overflow-hidden rounded-lg bg-muted">
                <ProductImage src={p.images[0]} alt="" sizes="140px" className="transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none" />
              </div>
              <p className="line-clamp-2 text-xs font-medium leading-5 group-hover:text-primary">{t(p.name, p.nameAr)}</p>
              <p className="text-xs font-semibold text-primary">{currency(p.price)}</p>
            </Link>)}
          </div>
        </div>
      </div>
    </div>
  </div>;
}
export function Header({ categories = [] }: { categories?: MenuCategory[] }) {
  const { t, language, toggleLanguage, cart, favorites, user, settings, currency } = useStore();
  const navigation = (settings.navigation ?? defaultNavigation).filter(link => link.visible);
  const pathname = usePathname();
  const router = useRouter();
  const [searchOpen, setSearchOpen] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);
  const count = cart.items.reduce((sum, item) => sum + item.quantity, 0);
  const hidden = useHideOnScroll(!menuOpen && !searchOpen);
  return <>
    <div className="bg-announcement py-2.5 text-center text-xs leading-5 text-announcement-foreground"><span>{t("A little love for your skin", "شوية حب لبشرتك")}</span><span className="mx-3 opacity-40">|</span>{t("Free delivery on orders over ", "توصيل مجاني للطلبات فوق ")}{currency(settings.freeShippingThreshold)}</div>
    <header className={cn("sticky top-0 z-40 border-b border-white/15 bg-navbar/95 text-navbar-foreground backdrop-blur-xl transition-transform duration-300 motion-reduce:transition-none", hidden && "-translate-y-full")}>
      <div className="page-container flex h-23 items-center justify-between gap-4">
        <div className="flex flex-1 items-center gap-2 sm:gap-4">
          <Sheet open={menuOpen} onOpenChange={setMenuOpen}><SheetTrigger asChild><Button variant="ghost" size="icon" className={cn(navButton, "lg:hidden")} aria-label={t("Open menu", "فتح القائمة")}><Menu className="size-5" /></Button></SheetTrigger><SheetContent side={language === "ar" ? "right" : "left"}><SheetHeader><SheetTitle>Oops Skin</SheetTitle><SheetDescription>{t("Your little world of beauty", "عالمك الصغير للجمال")}</SheetDescription></SheetHeader><nav className="grid gap-2 px-6">{navigation.map(({href,label:en,labelAr:ar}, index) => <div key={`${href}-${index}`} className="grid gap-1"><Link href={href} onClick={() => setMenuOpen(false)} className={cn("rounded-lg p-3", pathname === href && "bg-secondary text-primary")}>{t(en,ar)}</Link>{href === "/all-products" && <div className="grid gap-1 ps-4">{categories.map(c => <Link key={c.name} href={c.href} onClick={() => setMenuOpen(false)} className="flex items-center justify-between gap-2 rounded-lg p-2 text-sm text-muted-foreground">{t(c.name, c.nameAr)}<span className="text-[10px]">{c.count}</span></Link>)}</div>}</div>)}<Link href={user ? "/profile" : "/login"} onClick={() => setMenuOpen(false)} className="p-3">{t("My account", "حسابي")}</Link></nav></SheetContent></Sheet>
          <button onClick={toggleLanguage} className="text-sm font-medium text-navbar-foreground transition-opacity hover:opacity-75" aria-label={t("Switch to Arabic", "Switch to English")}>{language === "ar" ? "EN" : "عربي"}</button>
          <span className="hidden text-xs text-navbar-foreground/75 xl:block">{t("Tulkarm, Palestine", "طولكرم، فلسطين")}</span>
        </div>
        <Link href="/" aria-label={t("Oops Skin home", "أوبس سكين الرئيسية")} className="shrink-0"><Image src="/images/logo.svg" alt="Oops Skin" width={125} height={74} className="h-17 w-28 object-contain sm:w-32" priority /></Link>
        <div className="flex flex-1 items-center justify-end gap-0 sm:gap-2">
          <Button variant="ghost" size="icon" className={navButton} aria-label={t("Search products", "البحث عن المنتجات")} onClick={() => setSearchOpen(true)}><Search className="size-5" /></Button>
          <Button variant="ghost" size="icon" asChild className={cn(navButton, "hidden sm:inline-flex")}><Link href={user ? "/profile" : "/login"} aria-label={t("My account", "حسابي")}><UserRound className="size-5" /></Link></Button>
          <Button variant="ghost" size="icon" asChild className={cn(navButton, "relative")}><Link href="/favorites" aria-label={t("Favorites", "المفضلة")}><Heart className="size-5" />{favorites.length > 0 && <span className="absolute end-0 top-0 flex min-w-4 items-center justify-center rounded-full bg-navbar-foreground px-1 text-[10px] text-navbar">{favorites.length}</span>}</Link></Button>
          <Button variant="ghost" size="icon" asChild className={cn(navButton, "relative")}><Link href="/cart" aria-label={t("Shopping cart", "سلة التسوق")}><ShoppingCart className="size-5" />{count > 0 && <span className="absolute end-0 top-0 flex min-w-4 items-center justify-center rounded-full bg-navbar-foreground px-1 text-[10px] text-navbar">{count}</span>}</Link></Button>
        </div>
      </div>
      <nav aria-label={t("Main navigation", "القائمة الرئيسية")} className="relative hidden h-12 items-center justify-center gap-5 px-4 border-t border-white/15 lg:flex">{navigation.map(({href,label:en,labelAr:ar}, index) => href === "/all-products"
        ? <CategoryMenu key={`${href}-${index}`} href={href} label={t(en,ar)} active={pathname === href} categories={categories} />
        : <Link key={`${href}-${index}`} href={href} className={cn(navLink, pathname === href ? "text-navbar-foreground" : "after:hidden")}>{t(en,ar)}</Link>)}</nav>
    </header>
    <Dialog open={searchOpen} onOpenChange={setSearchOpen}><DialogContent><DialogTitle>{t("Find your next favorite", "ابحثي عن منتجك المفضل")}</DialogTitle><DialogDescription>{t("Search skincare, makeup, and more.", "ابحثي عن منتجات العناية والمكياج والمزيد.")}</DialogDescription><form className="flex gap-2" onSubmit={e => { e.preventDefault(); const query = String(new FormData(e.currentTarget).get("search") || "").trim(); router.push(`/all-products?search=${encodeURIComponent(query)}`); setSearchOpen(false); }}><Input name="search" aria-label={t("Search products", "البحث عن المنتجات")} placeholder={t("Try serum or lipstick…", "جربي سيروم أو أحمر شفاه…")} required /><Button type="submit"><Search className="size-4" />{t("Search", "بحث")}</Button></form></DialogContent></Dialog>
  </>;
}
