"use client";
import { useState } from "react";
import Link from "next/link";
import { ArrowDown, ArrowUp, Plus, Trash2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { useStore } from "@/components/store/provider";
import { defaultNavigation, defaultPages } from "@/lib/store-content";
import type { Product, StorePage, StoreSettings } from "@/lib/types";

function move<T>(items: T[], index: number, direction: number): T[] {
  const next = [...items];
  [next[index], next[index + direction]] = [next[index + direction], next[index]];
  return next;
}
export function ContentEditor({ section, settings, products, save, busy }: {
  section: string; settings: StoreSettings; products: Product[];
  save: (body: Partial<StoreSettings>) => Promise<boolean>; busy: boolean;
}) {
  const { t } = useStore();
  const [navigation, setNavigation] = useState(settings.navigation ?? defaultNavigation);
  const [pages, setPages] = useState(settings.pages ?? defaultPages);
  const [selected, setSelected] = useState(0);
  const [search, setSearch] = useState("");
  const [homeProductCount, setHomeProductCount] = useState(settings.homeProductCount ?? 24);
  const page = pages[selected];
  const updatePage = (patch: Partial<StorePage>) => setPages(pages.map((p, i) => i === selected ? { ...p, ...patch } : p));
  const byId = new Map(products.map(p => [p.id, p]));
  const reorder = (index: number, length: number, action: (direction: number) => void) => <div className="flex gap-1"><Button type="button" variant="outline" size="icon" disabled={index === 0} aria-label={t("Move up", "تحريك لأعلى")} onClick={() => action(-1)}><ArrowUp className="size-4" /></Button><Button type="button" variant="outline" size="icon" disabled={index === length - 1} aria-label={t("Move down", "تحريك لأسفل")} onClick={() => action(1)}><ArrowDown className="size-4" /></Button></div>;
  if (section === "navigation") return <form className="space-y-5" onSubmit={async e => { e.preventDefault(); await save({ navigation }); }}>
    <p className="text-sm text-muted-foreground">{t("Edit links shown in the desktop and mobile menus. Use a page path such as /skincare or /summer-picks. Save to publish your changes.", "عدّلي روابط قائمة الكمبيوتر والموبايل. استخدمي مسار صفحة مثل /skincare أو /summer-picks. احفظي لنشر التغييرات.")}</p>
    <fieldset disabled={busy} className="space-y-4">{navigation.map((link, index) => <div key={index} className="soft-panel grid gap-4 xl:grid-cols-[1fr_1fr_1fr_auto]">
      <label className="field text-sm">{t("English label", "الاسم بالإنجليزية")}<Input required maxLength={80} value={link.label} onChange={e => setNavigation(navigation.map((l,i) => i === index ? { ...l, label: e.target.value } : l))} /></label>
      <label className="field text-sm">{t("Arabic label", "الاسم بالعربية")}<Input required maxLength={80} value={link.labelAr} onChange={e => setNavigation(navigation.map((l,i) => i === index ? { ...l, labelAr: e.target.value } : l))} /></label>
      <label className="field text-sm">{t("Link path", "مسار الرابط")}<Input dir="ltr" required pattern="/.*" maxLength={500} value={link.href} onChange={e => setNavigation(navigation.map((l,i) => i === index ? { ...l, href: e.target.value } : l))} /></label>
      <div className="flex flex-wrap items-end gap-2"><label className="flex h-9 items-center gap-2 text-sm"><input type="checkbox" checked={link.visible} onChange={e => setNavigation(navigation.map((l,i) => i === index ? { ...l, visible: e.target.checked } : l))} />{t("Visible", "ظاهر")}</label>{reorder(index, navigation.length, direction => setNavigation(move(navigation, index, direction)))}<Button type="button" variant="ghost" size="icon" aria-label={t("Remove link", "حذف الرابط")} onClick={() => setNavigation(navigation.filter((_,i) => i !== index))}><Trash2 className="size-4" /></Button></div>
    </div>)}<div className="flex gap-3"><Button type="button" variant="outline" disabled={navigation.length >= 20} onClick={() => setNavigation([...navigation, { href: "/", label: "", labelAr: "", visible: true }])}><Plus className="size-4" />{t("Add link", "إضافة رابط")}</Button><Button type="submit">{t("Save navigation", "حفظ القائمة")}</Button></div></fieldset>
  </form>;
  return <form className="space-y-6" onSubmit={async e => { e.preventDefault(); await save({ pages, homeProductCount }); }}>
    <fieldset disabled={busy} className="space-y-6">
      <label className="soft-panel field max-w-sm text-sm">{t("Products on homepage (8–48)", "عدد منتجات الرئيسية (8–48)")}<Input type="number" required min={8} max={48} value={homeProductCount} onChange={e => setHomeProductCount(Number(e.target.value))} /></label>
      <div className="flex flex-wrap gap-3"><label className="field min-w-0 flex-1 text-sm">{t("Choose page", "اختاري الصفحة")}<select className="h-10 max-w-full rounded-md border bg-white px-3" value={selected} onChange={e => { setSelected(Number(e.target.value)); setSearch(""); }}>{pages.map((p,i) => <option key={i} value={i}>{t(p.title,p.titleAr) || t("Untitled page", "صفحة جديدة")} /{p.slug}</option>)}</select></label><Button type="button" className="self-end" variant="outline" disabled={pages.length >= 50} onClick={() => { let slug = "custom-page"; let suffix = 1; while (pages.some(p => p.slug === slug)) slug = `custom-page-${suffix++}`; setPages([...pages, { slug, title: "Custom page", titleAr: "صفحة مخصصة", description: "", descriptionAr: "", active: true, mode: "manual", productIds: [] }]); setSelected(pages.length); setSearch(""); }}><Plus className="size-4" />{t("Create page", "إنشاء صفحة")}</Button></div>
      {page && <div className="soft-panel space-y-6">
        <div className="grid gap-4 md:grid-cols-2">{([['title', 'English title', 'العنوان بالإنجليزية'], ['titleAr', 'Arabic title', 'العنوان بالعربية'], ['slug', 'URL path (without /)', 'مسار الصفحة (بدون /)']] as const).map(([key,en,ar]) => <label className="field text-sm" key={key}>{t(en,ar)}<Input required maxLength={key === "slug" ? 100 : 200} pattern={key === "slug" ? "[a-z0-9]+(-[a-z0-9]+)*" : undefined} value={page[key]} onChange={e => updatePage({ [key]: e.target.value })} /></label>)}<label className="flex items-center gap-2 text-sm"><input type="checkbox" checked={page.active} onChange={e => updatePage({ active: e.target.checked })} />{t("Published", "منشورة")}</label>
        {([['description','English description','الوصف بالإنجليزية'],['descriptionAr','Arabic description','الوصف بالعربية']] as const).map(([key,en,ar]) => <label className="field text-sm" key={key}>{t(en,ar)}<Textarea maxLength={2000} value={page[key]} onChange={e => updatePage({ [key]: e.target.value })} /></label>)}</div>
        <label className="field text-sm">{t("Product selection", "اختيار المنتجات")}<select className="h-10 rounded-md border bg-white px-3" value={page.mode} onChange={e => updatePage({ mode: e.target.value as StorePage['mode'] })}><option value="manual">{t("Choose products manually", "اختيار المنتجات يدوياً")}</option><option value="automatic">{t("Automatic collection", "مجموعة تلقائية")}</option></select></label>
        <p className="text-sm text-muted-foreground">{t("Automatic uses the category or badge for built-in collections and all active products for custom pages. Manual selection keeps your chosen order. Inactive products stay hidden. Add the page path in Navigation to include it in the menu.", "الوضع التلقائي يستخدم الفئة أو الشارة للمجموعات الأساسية وكل المنتجات النشطة للصفحات المخصصة. الاختيار اليدوي يحفظ ترتيبك ويخفي المنتجات غير النشطة. أضيفي مسار الصفحة في القائمة الرئيسية لإظهار رابطها.")}</p>
        {page.mode === "manual" && <div className="grid gap-6 xl:grid-cols-2"><div className="space-y-3"><h2 className="font-semibold">{t("Available products", "المنتجات المتاحة")}</h2><Input aria-label={t("Find products", "البحث عن منتجات")} placeholder={t("Search by name or ID", "ابحثي بالاسم أو الرقم")} value={search} onChange={e => setSearch(e.target.value)} /><div className="max-h-96 overflow-y-auto rounded-lg border">{products.filter(p => p.active && `${p.name} ${p.nameAr} ${p.id}`.toLowerCase().includes(search.toLowerCase())).map(p => <label key={p.id} className="flex items-center gap-3 border-b p-3 text-sm"><input type="checkbox" checked={page.productIds.includes(p.id)} onChange={e => updatePage({ productIds: e.target.checked ? [...page.productIds,p.id] : page.productIds.filter(id => id !== p.id) })} /><span>{t(p.name,p.nameAr)} <small className="text-muted-foreground">{p.id}</small></span></label>)}</div></div><div className="space-y-3"><h2 className="font-semibold">{t("Selected products", "المنتجات المختارة")} ({page.productIds.length})</h2><div className="max-h-110 space-y-2 overflow-y-auto">{page.productIds.map((id,i) => { const p = byId.get(id); return <div key={id} className="flex items-center gap-2 rounded-lg border p-3"><span className="min-w-0 flex-1 text-sm">{p ? t(p.name,p.nameAr) : id}{!p?.active && <small className="block text-muted-foreground">{t("Hidden / unavailable", "مخفي / غير متاح")}</small>}</span>{reorder(i,page.productIds.length,d => updatePage({productIds:move(page.productIds,i,d)}))}<Button type="button" size="icon" variant="ghost" aria-label={t("Remove product", "إزالة المنتج")} onClick={() => updatePage({productIds:page.productIds.filter(value => value !== id)})}><Trash2 className="size-4" /></Button></div>; })}</div></div></div>}
        <div className="flex flex-wrap gap-3"><Button type="button" variant="outline" asChild><Link href={`/${page.slug}`} target="_blank">{t("View saved page", "عرض الصفحة المحفوظة")}</Link></Button><Button type="button" variant="ghost" onClick={() => { setPages(pages.filter((_,i) => i !== selected)); setSelected(0); }}>{t("Remove page", "حذف الصفحة")}</Button></div>
      </div>}
      <Button type="submit">{t("Save pages & homepage", "حفظ الصفحات والرئيسية")}</Button>
    </fieldset>
  </form>;
}
