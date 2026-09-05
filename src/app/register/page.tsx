import { AuthForm } from "@/components/store/auth-form";
export const metadata = { title: "إنشاء حساب" };
export default async function Page({ searchParams }: { searchParams: Promise<{ next?: string }> }) { return <AuthForm register next={(await searchParams).next} />; }
