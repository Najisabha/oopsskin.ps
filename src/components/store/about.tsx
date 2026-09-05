"use client";
import { useStore } from "./provider";
import { AboutText } from "./footer";
import { ProductImage } from "./product-image";
export function AboutPage() { const { t } = useStore(); return <section className="page-container section-space grid items-center gap-12 lg:grid-cols-2"><div><p className="eyebrow mb-4 text-primary">{t("OUR STORY", "حكايتنا")}</p><h1 className="heading mb-8 text-primary">{t("A little world of beauty. A whole lot of heart.", "عالم صغير من الجمال، وقلب كبير.")}</h1><AboutText /></div><div className="relative aspect-[4/5] overflow-hidden rounded-2xl"><ProductImage src="/images/beauty-ritual.jpg" alt={t("Beauty and self-care", "الجمال والعناية بالنفس")} sizes="(max-width: 1024px) 100vw, 50vw" /></div></section>; }
