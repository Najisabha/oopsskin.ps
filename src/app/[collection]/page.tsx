import { notFound } from "next/navigation";
import { products } from "@/lib/db";
import { Catalog } from "@/components/store/catalog";
const collections = ["all-products", "best-sellers", "new", "makeup", "skincare", "packages"];
export async function generateMetadata({ params }: { params: Promise<{ collection: string }> }) { const { collection } = await params; return { title: collection.split("-").map(w => w[0].toUpperCase() + w.slice(1)).join(" ") }; }
export default async function CollectionPage({ params, searchParams }: { params: Promise<{ collection: string }>; searchParams: Promise<{ search?: string; category?: string }> }) {
  const { collection } = await params;
  if (!collections.includes(collection)) notFound();
  const query = await searchParams;
  return <Catalog products={products()} collection={collection} initialSearch={query.search || ""} initialCategory={query.category || "all"} key={`${collection}-${query.search}-${query.category}`} />;
}
