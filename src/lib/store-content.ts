import type { NavigationLink, Product, StorePage, Order } from "./types";

// International format, no leading "+", as required by wa.me links.
export const businessWhatsApp = "972598199142";
export function orderWhatsAppUrl(order: Order, currency: (value: number) => string) {
  const lines = [
    `New order ${order.id}`,
    "",
    ...order.items.map(i => `- ${i.name} x${i.quantity} (${currency(i.price * i.quantity)})`),
    "",
    `Total: ${currency(order.total)} (Cash on delivery)`,
    "",
    `Name: ${order.name}`,
    `Phone: ${order.phone}`,
    `City: ${order.city}`,
    `Address: ${order.address}`,
    ...(order.notes ? [`Notes: ${order.notes}`] : []),
  ];
  return `https://wa.me/${businessWhatsApp}?text=${encodeURIComponent(lines.join("\n"))}`;
}

// Categories are whatever the catalogue actually contains — synced products keep their raw
// source category when hsabate-product's categoryMap has no entry, so a hardcoded list goes
// stale silently (that is how "body care" and the Arabic-named categories were missed).
// Keys are lowercased; a category with no entry here falls back to its raw name in both languages.
const categoryLabels: Record<string, [string, string]> = {
  skincare: ["Skincare", "العناية بالبشرة"], makeup: ["Makeup", "المكياج"], packages: ["Habibti kits", "مجموعات حبيبتي"],
  haircare: ["Haircare", "العناية بالشعر"], fragrance: ["Fragrance", "العطور"], tools: ["Tools", "الأدوات"],
  "body care": ["Body care", "العناية بالجسم"], "الاضافر": ["Nails", "الأظافر"], "مناكير": ["Nail polish", "مناكير"],
  "رموش مميزة": ["Lashes", "رموش مميزة"], "مستلمزات انثى": ["Women's essentials", "مستلزمات أنثى"],
  "منتجات عالمية": ["Global picks", "منتجات عالمية"], uncategorized: ["More", "منتجات أخرى"],
};
// Placeholder categories from the supplier feed that shouldn't surface as a shop destination.
const hiddenCategories = new Set(["بلا", "uncategorized"]);
export type MenuCategory = { name: string; nameAr: string; href: string; count: number; products: Product[] };
export function menuCategories(products: Product[], perCategory = 4): MenuCategory[] {
  const grouped = new Map<string, Product[]>();
  for (const product of products) {
    const category = product.category?.trim();
    if (!product.active || !category || hiddenCategories.has(category.toLowerCase())) continue;
    const list = grouped.get(category);
    if (list) list.push(product); else grouped.set(category, [product]);
  }
  return [...grouped.entries()]
    .map(([category, items]) => {
      const [name, nameAr] = categoryLabels[category.toLowerCase()] ?? [category, category];
      return {
        name, nameAr, href: `/all-products?category=${encodeURIComponent(category)}`, count: items.length,
        // Lead with what a shopper can actually buy, then best sellers.
        products: [...items].sort((a, b) => Number(b.stock > 0) - Number(a.stock > 0) || Number(b.badge === "best-seller") - Number(a.badge === "best-seller")).slice(0, perCategory),
      };
    })
    .sort((a, b) => b.count - a.count || a.name.localeCompare(b.name));
}
export const defaultNavigation: NavigationLink[] = [
  ["/", "Home", "الرئيسية"], ["/best-sellers", "Best sellers", "الأكثر مبيعاً"],
  ["/new", "New arrivals", "وصل حديثاً"], ["/makeup", "Makeup", "المكياج"],
  ["/skincare", "Skincare", "العناية بالبشرة"], ["/packages", "Habibti kits", "مجموعات حبيبتي"],
  ["/all-products", "Shop all", "كل المنتجات"], ["/about", "Our story", "من نحن"],
].map(([href, label, labelAr]) => ({ href, label, labelAr, visible: true }));
export const defaultPages: StorePage[] = defaultNavigation.filter(link => !["/", "/about"].includes(link.href)).map(link => ({
  slug: link.href.slice(1), title: link.label, titleAr: link.labelAr, description: "", descriptionAr: "", active: true, mode: "automatic", productIds: [],
}));
export function pageProducts(products: Product[], page: StorePage): Product[] {
  const active = products.filter(p => p.active);
  if (page.mode === "manual") {
    const byId = new Map(active.map(p => [p.id, p]));
    return page.productIds.flatMap(id => byId.has(id) ? [byId.get(id)!] : []);
  }
  if (["makeup", "skincare", "packages"].includes(page.slug)) return active.filter(p => p.category.toLowerCase() === page.slug);
  if (page.slug === "new") return active.filter(p => p.badge === "new");
  if (page.slug === "best-sellers") return active.filter(p => p.badge === "best-seller");
  return active;
}
