import { Header } from "@/components/store/header";
import { Footer } from "@/components/store/footer";
import { products } from "@/lib/db";
import { menuCategories } from "@/lib/store-content";
export default async function StoreLayout({ children }: { children: React.ReactNode }) {
  return <><Header categories={menuCategories(await products())} /><main id="main-content" className="min-h-[55vh]">{children}</main><Footer /></>;
}
