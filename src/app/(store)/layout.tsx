import { Header } from "@/components/store/header";
import { Footer } from "@/components/store/footer";
export default function StoreLayout({ children }: { children: React.ReactNode }) {
  return <><Header /><main id="main-content" className="min-h-[55vh]">{children}</main><Footer /></>;
}
