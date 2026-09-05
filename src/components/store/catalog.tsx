"use client";
import { useState } from "react";
import Link from "next/link";
import { Heart, Search, SlidersHorizontal } from "lucide-react";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { ProductCard, categoryName } from "./product-card";
import { useStore } from "./provider";
import type { Product } from "@/lib/types";
const titles: Record<string,[string,string,string,string]> = { "all-products": ["The beauty edit","كل ما بتحبيه","Your next favorite is waiting to be discovered.","منتجك المفضل الجديد بانتظارك."], "best-sellers": ["Everyday favorites","الأكثر مبيعاً","The little things that deserve a place in your routine.","تفاصيل صغيرة بتستاهل مكان بروتينك."], new: ["Fresh on the shelf","وصل حديثاً","A fresh dose of beauty for your everyday.","جرعة جديدة من الجمال ليومك."], makeup: ["Make it your own","مكياج بيشبهك","A little color, a little confidence, all you.","شوية لون، شوية ثقة، وكتير إنتِ."], skincare: ["Skin comes first","بشرتك أولاً","Make room for a little everyday care.","اعملي مساحة لشوية عناية يومية."], packages: ["Better together","مجموعات حبيبتي","For someone you love. Yourself included.","لشخص بتحبيه. ولنفسك كمان."], favorites: ["Your little love list","المفضلة","All the things that caught your heart, in one place.","كل الأشياء اللي حبيتيها، بمكان واحد."] };
export function Catalog({ products, collection, initialSearch = "", initialCategory = "all" }: { products: Product[]; collection: string; initialSearch?: string; initialCategory?: string }) {
  const { t, favorites, currency } = useStore();
  const [search, setSearch] = useState(initialSearch);
  const [category, setCategory] = useState(initialCategory);
  const [sort, setSort] = useState("featured");
  const [inStock, setInStock] = useState(false);
  const [maxPrice, setMaxPrice] = useState("");
  const [page, setPage] = useState(1);
  const [showFilters, setShowFilters] = useState(false);
  const title = titles[collection] || titles["all-products"];
  let base = products;
  if (["makeup","skincare","packages"].includes(collection)) base = base.filter(p => p.category.toLowerCase() === collection);
  if (collection === "new") base = base.filter(p => p.badge === "new");
  if (collection === "best-sellers") base = base.filter(p => p.badge === "best-seller");
  if (collection === "favorites") base = base.filter(p => favorites.includes(p.id));
  const categories = [...new Set(base.map(p => p.category))];
  let filtered = base.filter(p => (category === "all" || p.category === category) && (!inStock || p.stock > 0) && (!maxPrice || p.price <= Number(maxPrice)) && `${p.name} ${p.nameAr} ${p.description} ${p.descriptionAr}`.toLowerCase().includes(search.toLowerCase()));
  filtered = [...filtered].sort((a,b) => sort === "price-asc" ? a.price-b.price : sort === "price-desc" ? b.price-a.price : sort === "newest" ? b.createdAt.localeCompare(a.createdAt) : Number(b.badge === "best-seller")-Number(a.badge === "best-seller"));
  const pages = Math.max(1,Math.ceil(filtered.length/12));
  const currentPage = Math.min(page,pages);
  const reset = () => { setSearch(""); setCategory("all"); setInStock(false); setMaxPrice(""); setSort("featured"); setPage(1); };
  return <div className="pb-20"><div className="border-b bg-secondary/50 py-12 text-center sm:py-16"><div className="page-container"><p className="eyebrow mb-4 text-primary">Oops Skin / {t(collection === "favorites" ? "Your favorites" : "The collection",collection === "favorites" ? "المفضلة" : "المجموعة")}</p><h1 className="heading text-primary">{t(title[0],title[1])}</h1><p className="mt-4 text-sm text-muted-foreground">{t(title[2],title[3])}</p></div></div>
    <div className="page-container pt-8"><div className="mb-6 flex flex-wrap items-center justify-between gap-4"><div className="relative min-w-48 flex-1 sm:max-w-80"><Search className="absolute start-3 top-3 size-4 text-muted-foreground" /><Input value={search} onChange={e => { setSearch(e.target.value); setPage(1); }} aria-label={t("Search collection", "البحث في المجموعة")} placeholder={t("Search the collection…", "ابحثي في المجموعة…")} className="h-10 ps-9" /></div><div className="flex items-center gap-3"><Button variant="outline" className="h-10" onClick={() => setShowFilters(!showFilters)} aria-expanded={showFilters}><SlidersHorizontal className="size-4" />{t("Filters", "تصفية")}</Button><Select value={sort} onValueChange={v => { setSort(v); setPage(1); }}><SelectTrigger className="w-43" aria-label={t("Sort products", "ترتيب المنتجات")}><SelectValue /></SelectTrigger><SelectContent><SelectItem value="featured">{t("Featured", "المميزة")}</SelectItem><SelectItem value="price-asc">{t("Price: low to high", "السعر: من الأقل")}</SelectItem><SelectItem value="price-desc">{t("Price: high to low", "السعر: من الأعلى")}</SelectItem><SelectItem value="newest">{t("Newest", "الأحدث")}</SelectItem></SelectContent></Select></div></div>
    {showFilters && <div className="mb-8 flex flex-wrap items-end gap-5 rounded-xl bg-muted p-5"><label className="field text-xs">{t("Category", "الفئة")}<select className="h-10 rounded-md border bg-background px-3" value={category} onChange={e => { setCategory(e.target.value); setPage(1); }}><option value="all">{t("All categories", "كل الفئات")}</option>{categories.map(c => <option key={c} value={c}>{categoryName(c,t)}</option>)}</select></label><label className="field text-xs">{t("Maximum price (ILS)", "أقصى سعر (شيكل)")}<Input type="number" min="0" value={maxPrice} onChange={e => { setMaxPrice(e.target.value); setPage(1); }} placeholder={currency(200)} className="w-40 bg-background" /></label><label className="flex h-10 items-center gap-2 text-xs"><input type="checkbox" checked={inStock} onChange={e => { setInStock(e.target.checked); setPage(1); }} className="size-4 accent-primary" />{t("In stock only", "المتوفر فقط")}</label><Button variant="ghost" onClick={reset}>{t("Reset", "إعادة تعيين")}</Button></div>}
    <p aria-live="polite" className="mb-6 text-xs text-muted-foreground">{filtered.length} {t("products", "منتج")}</p>
    {filtered.length ? <><div className="grid grid-cols-2 gap-x-4 gap-y-9 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4">{filtered.slice((currentPage-1)*12,currentPage*12).map(p => <ProductCard key={p.id} product={p} />)}</div>{pages>1 && <div className="mt-12 flex items-center justify-center gap-5"><Button variant="outline" disabled={currentPage===1} onClick={() => { setPage(currentPage-1); window.scrollTo({top:0,behavior:"smooth"}); }}>{t("Previous", "السابق")}</Button><span className="text-sm">{currentPage} / {pages}</span><Button variant="outline" disabled={currentPage===pages} onClick={() => { setPage(currentPage+1); window.scrollTo({top:0,behavior:"smooth"}); }}>{t("Next", "التالي")}</Button></div>}</> : <div className="py-20 text-center"><Heart className="mx-auto mb-5 size-10 text-accent" /><h2 className="text-xl font-medium">{t(collection === "favorites" ? "Your love list starts here" : "No products found",collection === "favorites" ? "المفضلة بتبدأ من هون" : "لم يتم العثور على منتجات")}</h2><p className="mb-6 mt-3 text-sm text-muted-foreground">{t(collection === "favorites" ? "Tap a heart on any product to save it here." : "Try a different search or reset your filters.",collection === "favorites" ? "اضغطي القلب على أي منتج لحفظه هون." : "جربي بحث مختلف أو أعيدي تعيين التصفية.")}</p><Button onClick={reset} variant="outline">{t("Reset filters", "إعادة تعيين التصفية")}</Button><Button asChild className="ms-3"><Link href="/all-products">{t("Explore the shop", "تصفحي المتجر")}</Link></Button></div>}
    </div></div>;
}
