import { Catalog } from "@/components/store/catalog";
import { products } from "@/lib/db";
export const metadata = { title: "المفضلة" };
export default function FavoritesPage() { return <Catalog products={products()} collection="favorites" />; }
