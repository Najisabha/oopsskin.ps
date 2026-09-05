import { AuthForm } from "@/components/store/auth-form";
export const metadata = { title: "تسجيل الدخول" };
export default async function Page({ searchParams }: { searchParams: Promise<{ next?: string }> }) { return <AuthForm next={(await searchParams).next} />; }
