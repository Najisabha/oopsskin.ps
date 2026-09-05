"use client";
import Link from "next/link";
import { useState } from "react";
import { Heart, Plus, Loader2 } from "lucide-react";
import { toast } from "sonner";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { ProductImage } from "./product-image";
import { useStore } from "./provider";
import type { Product } from "@/lib/types";
import { errorMessage } from "@/lib/client";
export function ProductCard({ product }: { product: Product }) {
  const { t, currency, favorites, toggleFavorite, addToCart, ready } = useStore();
  const [busy, setBusy] = useState(false);
  const favorite = favorites.includes(product.id);
  return <article className="group min-w-0">
    <div className="relative aspect-[4/5] overflow-hidden rounded-xl bg-muted">
      <Link href={`/product/${product.id}`} className="absolute inset-0" aria-label={t(product.name,product.nameAr)}><ProductImage src={product.images[0]} alt={t(product.name,product.nameAr)} className="transition-transform duration-700 group-hover:scale-105" /></Link>
      {product.badge && <Badge className="absolute start-3 top-3 border-0 bg-background/95 px-2.5 py-1 text-[10px] font-medium text-primary">{product.badge === "new" ? t("JUST IN", "وصل حديثاً") : t("BEST SELLER", "الأكثر مبيعاً")}</Badge>}
      <Button variant="secondary" size="icon" className="absolute end-3 top-3 size-8 rounded-full bg-background/95 hover:bg-background" aria-label={favorite ? t("Remove from favorites", "إزالة من المفضلة") : t("Like product", "أعجبني")} aria-pressed={favorite} onClick={() => toggleFavorite(product.id)}><Heart className={favorite ? "size-4 fill-primary text-primary" : "size-4"} /></Button>
      {product.stock === 0 && <div className="absolute inset-x-0 bottom-0 bg-background/90 p-3 text-center text-xs">{t("Out of stock", "خلصت حالياً")}</div>}
    </div>
    <div className="pt-4"><p className="mb-1.5 text-[10px] font-medium uppercase tracking-widest text-muted-foreground">{categoryName(product.category,t)}</p><Link href={`/product/${product.id}`} className="block min-h-12 text-sm font-semibold leading-6 hover:text-primary">{t(product.name,product.nameAr)}</Link><div className="mt-2 flex items-center justify-between gap-2"><div className="flex flex-wrap items-center gap-2 text-sm"><span className="font-semibold text-primary">{currency(product.price)}</span>{product.compareAtPrice && <del className="text-xs text-muted-foreground">{currency(product.compareAtPrice)}</del>}</div><Button size="icon" variant="outline" className="size-8 shrink-0 rounded-full" disabled={busy || !ready || !product.stock} aria-label={`${t("Add to bag", "إضافة إلى السلة")}: ${t(product.name,product.nameAr)}`} onClick={async () => { setBusy(true); try { await addToCart(product.id); } catch(e) { toast.error(errorMessage(e)); } finally { setBusy(false); } }}>{busy ? <Loader2 className="size-3.5 animate-spin" /> : <Plus className="size-4" />}</Button></div></div>
  </article>;
}
export function categoryName(category: string, t: (en: string, ar: string) => string) { return t(category, ({ Skincare: "العناية بالبشرة", Makeup: "المكياج", Packages: "المجموعات", Haircare: "العناية بالشعر", Fragrance: "العطور", Tools: "الأدوات" } as Record<string,string>)[category] || category); }
