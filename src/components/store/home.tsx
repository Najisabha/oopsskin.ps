"use client";
import Link from "next/link";
import { useRef, useState } from "react";
import { ArrowLeft, ArrowRight, ChevronLeft, ChevronRight, Heart, Sparkles } from "lucide-react";
import { Button } from "@/components/ui/button";
import { useStore } from "./provider";
import { ProductCard } from "./product-card";
import { ProductImage } from "./product-image";
import { defaultPages, pageProducts } from "@/lib/store-content";
import type { Product } from "@/lib/types";
const slides = ["/images/beauty-collection.jpg", "/images/beauty-ritual.jpg", "/images/makeup.jpg"];
export function HomeContent({ products }: { products: Product[] }) {
  const { t, language, settings } = useStore();
  const [slide, setSlide] = useState(0);
  const collectionProducts = (slug: string) => { const page = (settings.pages ?? defaultPages).find(p => p.slug === slug && p.active); return page ? pageProducts(products, page).slice(0, 12) : []; };
  const Arrow = language === "ar" ? ArrowLeft : ArrowRight;
  return <>
    <section className="relative overflow-hidden bg-secondary">
      <div className="page-container grid items-center lg:min-h-143 lg:grid-cols-2">
        <div className="relative z-10 py-14 pe-0 lg:py-18 lg:pe-16">
          <div className="mb-6 flex items-center gap-2"><span className="h-px w-7 bg-primary" /><span className="eyebrow text-primary">{t("YOUR EVERYDAY BEAUTY, REIMAGINED", "مساحتك للجمال والعناية")}</span></div>
          <h1 className="max-w-xl font-display text-[clamp(2.8rem,5.8vw,5.1rem)] font-semibold leading-[1.12] tracking-[-0.055em] text-primary rtl:leading-[1.5] rtl:tracking-normal">{t("A little care.", "شوية عناية.")}<br /><span className="text-primary/65">{t("A lot of you.", "كتير إنتِ.")}</span></h1>
          <p className="mb-8 mt-6 max-w-95 text-sm leading-7 text-muted-foreground">{t("Skincare to fall in love with. Makeup to make your own. Discover your everyday favorites, thoughtfully chosen for you.", "سكين كير بتحبيه، وميك أب بيشبهك. اكتشفي منتجاتك المفضلة، اخترناها بعناية عشانك.")}</p>
          <Button asChild className="h-12 rounded-full px-7"><Link href="/all-products">{t("Find your favorites", "اكتشفي منتجاتك المفضلة")}<Arrow className="ms-3 size-4" /></Link></Button>
          <div className="mt-9 flex items-center gap-3 text-xs text-muted-foreground"><span className="flex size-8 items-center justify-center rounded-full border border-accent"><Heart className="size-3.5 text-primary" /></span>{t("From Tulkarm, with love", "من طولكرم، بكل حب")}</div>
        </div>
        <div className="relative -mx-4 h-90 sm:-mx-6 sm:h-110 lg:mx-0 lg:h-full lg:min-h-143">
          <ProductImage key={slides[slide]} src={slides[slide]} alt={t("A thoughtfully arranged collection of beauty and makeup essentials", "مجموعة من مستحضرات التجميل والمكياج")} priority sizes="(max-width: 1024px) 100vw, 50vw" />
          <div className="absolute inset-0 bg-primary/5" />
          <div className="absolute bottom-6 start-6 flex items-center gap-4 rounded-lg border border-white/50 bg-background/90 p-4 backdrop-blur-md"><div className="flex size-10 items-center justify-center rounded-full bg-secondary"><Sparkles className="size-5 text-primary" /></div><div><p className="text-sm font-semibold text-primary">{t("Your glow starts here", "جمالك بيبدأ هون")}</p><p className="mt-1 text-xs text-muted-foreground">{t("A ritual, just for you.", "لحظة عناية، إلك.")}</p></div></div>
          <div className="absolute end-5 top-5 flex gap-1.5">{slides.map((_, i) => <button key={i} className={`h-2.5 rounded-full border border-white/60 transition-all ${i === slide ? "w-7 bg-primary" : "w-2.5 bg-white/70"}`} aria-label={t(`Show image ${i + 1}`, `عرض الصورة ${i + 1}`)} aria-pressed={slide === i} onClick={() => setSlide(i)} />)}</div>
          <div className="absolute bottom-6 end-6 flex gap-2"><Button variant="secondary" size="icon" className="size-8 rounded-full bg-background/90" aria-label={t("Previous image", "الصورة السابقة")} onClick={() => setSlide((slide + slides.length - 1) % slides.length)}><ChevronLeft className="size-4" /></Button><Button variant="secondary" size="icon" className="size-8 rounded-full bg-background/90" aria-label={t("Next image", "الصورة التالية")} onClick={() => setSlide((slide + 1) % slides.length)}><ChevronRight className="size-4" /></Button></div>
        </div>
      </div>
    </section>
    <section className="page-container section-space">
      <div className="mb-9 flex flex-wrap items-end justify-between gap-4"><div><p className="eyebrow mb-3 text-primary">{t("A BEAUTY MOMENT FOR EVERY MOOD", "لكل لحظة، جمالها")}</p><h2 className="heading">{t("What are you in the mood for?", "شو حابة تدلّلي اليوم؟")}</h2></div><Link href="/all-products" className="flex items-center gap-2 border-b border-primary pb-1 text-xs font-medium text-primary">{t("Explore everything", "اكتشفي كل المنتجات")}<Arrow className="size-3.5" /></Link></div>
      <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">{[["/skincare", "Skincare", "العناية بالبشرة", "Your daily dose of care", "جرعتك اليومية من العناية", "cream"], ["/makeup", "Makeup", "المكياج", "A little color. All you.", "لمسة لون بتشبهك", "makeup"], ["/packages", "Habibti kits", "مجموعات حبيبتي", "Better together", "أحلى مع بعض", "beauty-collection"], ["/new", "New arrivals", "وصل حديثاً", "Meet your next favorite", "تعرفي على مفضلتك الجديدة", "serum"]].map(([href, en, ar, desc, descAr, img]) => <Link href={href} key={href} className="group relative aspect-[1.12] overflow-hidden rounded-xl bg-muted"><ProductImage src={`/images/${img}.jpg`} alt={t(en, ar)} className="transition-transform duration-700 group-hover:scale-105" /><div className="absolute inset-0 bg-linear-to-t from-black/70 via-black/10 to-transparent" /><div className="absolute inset-x-4 bottom-4 text-white sm:inset-x-5 sm:bottom-5"><div className="flex items-center justify-between"><h3 className="text-base font-medium sm:text-xl">{t(en, ar)}</h3><Arrow className="size-4" /></div><p className="mt-2 hidden text-xs text-white/80 sm:block">{t(desc, descAr)}</p></div></Link>)}</div>
    </section>
    <section className="page-container pb-16">
      <div className="mb-8 flex flex-wrap items-end justify-between gap-4"><h2 className="heading">{t("Discover more favorites", "اكتشفي المزيد من المنتجات")}</h2><Link href="/all-products" className="text-sm text-primary underline">{t("Shop all products", "تسوقي كل المنتجات")}</Link></div>
      <div className="grid grid-cols-2 gap-x-4 gap-y-9 sm:grid-cols-3 lg:grid-cols-4">{products.slice(0, settings.homeProductCount ?? 24).map(product => <ProductCard key={product.id} product={product} />)}</div>
    </section>
    <ProductShelf products={collectionProducts("best-sellers")} title={t("The ones you'll love", "منتجات رح تحبيها")} label={t("THE EVERYDAY FAVORITES", "المفضلات اليومية")} href="/best-sellers" />
    <section className="page-container py-12">
      <div className="grid overflow-hidden rounded-2xl bg-secondary md:grid-cols-2"><div className="relative min-h-80"><ProductImage src="/images/beauty-collection.jpg" alt={t("The Habibti makeup collection", "مجموعة مكياج حبيبتي")} sizes="(max-width: 768px) 100vw, 50vw" /></div><div className="flex flex-col items-start justify-center p-8 sm:p-12 lg:p-16"><p className="eyebrow mb-5 text-primary">{t("A LITTLE SOMETHING FOR YOUR HABIBTI", "هدية حلوة لحبيبتك… أو إلك")}</p><h2 className="heading text-primary">{t("Habibti, this one's for you.", "حبيبتي، هاي إلك.")}</h2><p className="mb-7 mt-5 text-sm leading-7 text-muted-foreground">{t("Your favorite things, all together. Discover beauty sets made for gifting, sharing, or a little well-deserved self-love.", "أشيائك المفضلة، كلها مع بعض. اكتشفي مجموعات الجمال للهدايا، للمشاركة، أو لشوية دلع بتستاهليهم.")}</p><Button asChild className="h-11 rounded-full px-6"><Link href="/packages">{t("Shop the kits", "تسوقي المجموعات")}<Arrow className="ms-2 size-4" /></Link></Button></div></div>
    </section>
    <ProductShelf products={collectionProducts("skincare")} title={t("Good days start with good care", "يومك الحلو بيبدأ بعناية")} label={t("SKIN FIRST, ALWAYS", "بشرتك أولاً، دايماً")} href="/skincare" />
  </>;
}
function ProductShelf({ products, title, label, href }: { products: Product[]; title: string; label: string; href: string }) {
  const { t, language } = useStore();
  const ref = useRef<HTMLDivElement>(null);
  if (!products.length) return null;
  return <section className="page-container pb-16"><div className="mb-8 flex items-end justify-between gap-5"><div><p className="eyebrow mb-3 text-primary">{label}</p><h2 className="heading">{title}</h2></div><div className="flex shrink-0 items-center gap-2"><Button variant="outline" size="icon" className="hidden size-9 rounded-full sm:inline-flex" aria-label={t("Previous products", "المنتجات السابقة")} onClick={() => ref.current?.scrollBy({ left: language === "ar" ? 320 : -320, behavior: "smooth" })}><ChevronLeft className="size-4 rtl:rotate-180" /></Button><Button variant="outline" size="icon" className="hidden size-9 rounded-full sm:inline-flex" aria-label={t("Next products", "المنتجات التالية")} onClick={() => ref.current?.scrollBy({ left: language === "ar" ? -320 : 320, behavior: "smooth" })}><ChevronRight className="size-4 rtl:rotate-180" /></Button></div></div><div ref={ref} className="grid auto-cols-[minmax(155px,46%)] grid-flow-col gap-4 overflow-x-auto pb-4 sm:auto-cols-[31%] sm:gap-6 lg:auto-cols-[calc((100%_-_4.5rem)/4)] snap-x">{products.map(p => <div className="snap-start" key={p.id}><ProductCard product={p} /></div>)}</div><Link href={href} className="mx-auto mt-5 block w-fit border-b border-primary pb-1 text-xs font-medium text-primary">{t("View the collection", "شاهدي المجموعة")}</Link></section>;
}
