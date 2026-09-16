"use client";
import Image from "next/image";
import Link from "next/link";
import { ArrowUpRight, Heart, MapPin } from "lucide-react";
import { useStore } from "./provider";
export const aboutArabic = [
  "Oops Skin هو أكثر من مجرد محل ميك أب وسكين كير في طولكرم – فلسطين 🤍",
  "هو مساحة لكل بنت بتحب تهتم ببشرتها وتختار منتجاتها بثقة.",
  "من البداية كان هدفنا نوفر براندات أصلية ومضمونة، مختارة بعناية لتناسب مختلف أنواع البشرة واحتياجاتها. نهتم بالتفاصيل، بالجودة، وبإننا نساعدك تختاري الصح لبشرتك من خلال نصائح صادقة وتجربة قريبة منكِ.",
  "في Oops Skin بنؤمن إن الجمال مش بس ميك أب… الجمال يبدأ من بشرة صح وعناية صح ✨",
  "ومهمتنا نكون وجهتك الأولى لكل ما يخص السكين كير والميك أب، مع خدمة حلوة وتجربة تسوّق مريحة.",
  "جمالك علينا… وثقتك بتكبرنا 💕"
];
const aboutEnglish = [
  "Oops Skin is more than a makeup and skincare store in Tulkarm, Palestine 🤍",
  "It is a space for every girl who loves caring for her skin and choosing her products with confidence.",
  "From the beginning, our aim has been to offer authentic, trusted brands, carefully selected for different skin types and needs. We care about the details, quality, and helping you find what is right for your skin through honest advice and a personal experience.",
  "At Oops Skin, we believe beauty is more than makeup… it starts with healthy skin and the right care ✨",
  "Our mission is to be your first destination for skincare and makeup, with friendly service and a comfortable shopping experience.",
  "Your beauty is our care… your trust helps us grow 💕"
];
export function AboutText() { const { language } = useStore(); return <div className="space-y-4 text-sm leading-8 text-muted-foreground">{(language === "ar" ? aboutArabic : aboutEnglish).map((p,i) => <p key={i} className={i === 5 ? "font-semibold text-primary" : ""}>{p}</p>)}</div>; }
export function Footer() {
  const { t, settings } = useStore();
  return <footer className="border-t bg-secondary/50" id="about">
    <div className="page-container grid gap-12 py-16 lg:grid-cols-[1.8fr_1fr] lg:gap-24">
      <div><div className="mb-6 flex items-center gap-4"><span className="eyebrow text-primary">{t("A little about us", "من نحن")}</span><span className="h-px flex-1 bg-border" /><Heart className="size-4 text-primary" /></div><AboutText /></div>
      <div className="flex flex-col justify-between gap-8"><div className="grid grid-cols-2 gap-8"><div><h3 className="mb-5 text-sm font-semibold">{t("Explore", "تسوقي معنا")}</h3><div className="grid gap-3 text-sm text-muted-foreground">{[["/all-products","Shop all","كل المنتجات"],["/skincare","Skincare","العناية بالبشرة"],["/makeup","Makeup","المكياج"],["/packages","Habibti kits","مجموعات حبيبتي"]].map(([href,en,ar]) => <Link className="hover:text-primary" href={href} key={href}>{t(en,ar)}</Link>)}</div></div><div><h3 className="mb-5 text-sm font-semibold">{t("Your space", "مساحتك")}</h3><div className="grid gap-3 text-sm text-muted-foreground">{[["/profile","My account","حسابي"],["/favorites","My favorites","المفضلة"],["/cart","Shopping cart","سلة التسوق"],["/about","Our story","من نحن"]].map(([href,en,ar]) => <Link className="hover:text-primary" href={href} key={href}>{t(en,ar)}</Link>)}</div></div></div><div className="border-t pt-6 text-sm text-muted-foreground"><p className="flex items-center gap-2"><MapPin className="size-4 text-primary" />{t("Tulkarm, Palestine", "طولكرم، فلسطين")}</p>{settings.contactEmail && <a className="mt-3 flex items-center gap-2" href={`mailto:${settings.contactEmail}`}>{settings.contactEmail}<ArrowUpRight className="size-4" /></a>}</div></div>
    </div>
    <div className="page-container flex flex-wrap items-center justify-between gap-4 border-t py-5"><Image src="/images/logo.svg" alt="Oops Skin" width={72} height={43} /><p className="text-xs text-muted-foreground">© {new Date().getFullYear()} Oops Skin. {t("Made with love, for you.", "بكل حب، إلك.")}</p><span className="text-xs text-muted-foreground">{t("Palestine · ILS ₪", "فلسطين · شيكل ₪")}</span></div>
  </footer>;
}
