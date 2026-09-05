"use client";
import { Button } from "@/components/ui/button";
export default function ErrorPage({ reset }: { reset: () => void }) { return <div className="page-container py-24 text-center"><h1 className="heading mb-5">تعذر تحميل الصفحة</h1><p className="mb-8 text-sm text-muted-foreground">We could not load this page. Please try again.</p><Button onClick={reset}>حاولي مرة ثانية / Try again</Button></div>; }
