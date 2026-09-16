import { notFound, permanentRedirect } from "next/navigation";
import { getProduct, products } from "@/lib/db";
import { ProductDetail } from "@/components/store/product-detail";

export async function generateMetadata({ params }: { params: Promise<{ id: string }> }) {
  const product = await getProduct(decodeURIComponent((await params).id));
  return { title: product?.nameAr || "المنتج غير موجود", description: product?.descriptionAr };
}

export default async function Page({ params }: { params: Promise<{ id: string }> }) {
  const requested = decodeURIComponent((await params).id);
  const product = await getProduct(requested);
  if (!product?.active) notFound();
  // Legacy "hsabate:6" and bare supplier-number links settle on the canonical slug.
  if (product.slug && requested !== product.slug) permanentRedirect(`/product/${product.slug}`);
  const all = await products();
  return <ProductDetail product={product} related={all.filter(p => p.category === product.category && p.id !== product.id).slice(0, 4)} key={product.id} />;
}
