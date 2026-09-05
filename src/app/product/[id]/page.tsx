import { notFound } from "next/navigation";
import { get, products } from "@/lib/db";
import type { Product } from "@/lib/types";
import { ProductDetail } from "@/components/store/product-detail";
export async function generateMetadata({ params }: { params: Promise<{ id: string }> }) { const product = get<Product>("products",(await params).id); return { title: product?.nameAr || "المنتج غير موجود", description: product?.descriptionAr }; }
export default async function Page({ params }: { params: Promise<{ id: string }> }) { const product = get<Product>("products",(await params).id); if (!product?.active) notFound(); return <ProductDetail product={product} related={products().filter(p => p.category===product.category && p.id!==product.id).slice(0,4)} key={product.id} />; }
