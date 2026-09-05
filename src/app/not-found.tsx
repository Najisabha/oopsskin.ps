import Link from "next/link";
import { Button } from "@/components/ui/button";
export default function NotFound() { return <div className="page-container py-24 text-center"><p className="eyebrow text-primary">404</p><h1 className="heading my-5">الصفحة غير موجودة</h1><p className="mb-7 text-sm text-muted-foreground">This page could not be found.</p><Button asChild><Link href="/all-products">تصفحي المتجر / Back to shop</Link></Button></div>; }
