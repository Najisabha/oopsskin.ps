import { HomeContent } from "@/components/store/home";
import { products } from "@/lib/db";
export default async function Home() { return <HomeContent products={await products()} />; }
