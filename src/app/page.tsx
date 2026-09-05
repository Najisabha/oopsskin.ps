import { HomeContent } from "@/components/store/home";
import { products } from "@/lib/db";
export default function Home() { return <HomeContent products={products()} />; }
