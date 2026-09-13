import type { NavigationLink, Product, StorePage } from "./types";

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
