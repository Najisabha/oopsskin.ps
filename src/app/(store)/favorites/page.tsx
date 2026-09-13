import { Catalog } from "@/components/store/catalog";
import { products } from "@/lib/db";
export const metadata = { title: "المفضلة" };
export default async function FavoritesPage() { return <Catalog products={await products()} collection="favorites" />; }
