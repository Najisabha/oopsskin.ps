import { notFound } from "next/navigation";
import { products, settings } from "@/lib/db";
import { Catalog } from "@/components/store/catalog";
import { pageProducts } from "@/lib/store-content";
type Props = { params: Promise<{ collection: string }>; searchParams: Promise<{ search?: string; category?: string }> };
export async function generateMetadata({ params }: Props) {
  const { collection } = await params;
  const page = (await settings()).pages?.find(p => p.slug === collection && p.active);
  return { title: page?.titleAr || "الصفحة غير موجودة", description: page?.descriptionAr };
}
export default async function CollectionPage({ params, searchParams }: Props) {
  const { collection } = await params;
  const page = (await settings()).pages?.find(p => p.slug === collection && p.active);
  if (!page) notFound();
  const query = await searchParams;
  return <Catalog products={pageProducts(await products(), page)} collection={collection} pageContent={page} initialSearch={query.search || ""} initialCategory={query.category || "all"} key={`${collection}-${query.search}-${query.category}`} />;
}
