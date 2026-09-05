"use client";
import Image from "next/image";
import { useState } from "react";
import { cn } from "@/lib/utils";
export function ProductImage({ src, alt, className, priority = false, sizes = "(max-width: 640px) 50vw, (max-width: 1024px) 33vw, 25vw" }: { src: string; alt: string; className?: string; priority?: boolean; sizes?: string }) {
  const [failed, setFailed] = useState(false);
  return <Image src={failed ? "/images/product-placeholder.svg" : src} alt={alt} fill sizes={sizes} priority={priority} className={cn("object-cover", className)} unoptimized={src.startsWith("https://")} onError={() => setFailed(true)} />;
}
