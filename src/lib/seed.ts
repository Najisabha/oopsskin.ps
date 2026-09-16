import type { Product } from "./types";

// Development catalog, adapted from the old site's seeder and homepage.
// These are illustrative products and images, not a synchronized supplier catalog.
const samples = [
  ["lipstick-red", "Lipstick Red", "أحمر شفاه أحمر", "Smooth red lipstick for every occasion.", "أحمر شفاه ناعم لكل مناسبة.", 50, 60, "Makeup", "makeup", 10, "new"],
  ["eyeliner-black", "Eyeliner Black", "آيلاينر أسود", "An everyday essential for a defined eye look.", "أساسي لإطلالة عيون محددة.", 30, null, "Makeup", "makeup", 15, ""],
  ["face-cream", "Face Cream", "كريم الوجه", "A little everyday care for your skin.", "عناية يومية بسيطة لبشرتك.", 80, 100, "Skincare", "cream", 20, "best-seller"],
  ["perfume-classic", "Perfume Classic", "عطر كلاسيك", "The finishing touch to your daily ritual.", "اللمسة الأخيرة لروتينك اليومي.", 120, null, "Fragrance", "serum", 5, ""],
  ["hair-oil", "Hair Oil", "زيت الشعر", "Make a moment for your haircare routine.", "امنحي شعرك لحظة من العناية.", 40, null, "Haircare", "serum", 25, ""],
  ["blush-pink", "Blush Pink", "بلاشر وردي", "A soft pop of pink for your everyday makeup.", "لمسة وردية ناعمة لمكياجك اليومي.", 35, null, "Makeup", "beauty-collection", 12, "new"],
  ["shampoo-daily", "Shampoo Daily", "شامبو يومي", "A fresh start to your haircare routine.", "بداية منعشة لروتين العناية بالشعر.", 25, null, "Haircare", "cream", 30, ""],
  ["face-mask", "Face Mask", "ماسك الوجه", "A moment of calm in your skincare ritual.", "لحظة هدوء في روتين العناية ببشرتك.", 45, null, "Skincare", "mask", 18, ""],
  ["lip-gloss", "Lip Gloss", "ملمع الشفاه", "A glossy finishing touch for your lips.", "لمسة نهائية لامعة لشفتيك.", 20, null, "Makeup", "makeup", 22, "best-seller"],
  ["eyelash-curler", "Eyelash Curler", "مكبس الرموش", "A simple addition to your makeup bag.", "إضافة بسيطة لحقيبة مكياجك.", 60, null, "Tools", "beauty-collection", 8, ""],
  ["hydrating-face-serum", "Hydrating Face Serum", "سيروم الوجه المرطب", "Meet your new skincare ritual. A lightweight serum for your daily routine.", "اكتشفي روتينك الجديد مع سيروم خفيف للعناية اليومية.", 45, null, "Skincare", "serum", 20, "best-seller"],
  ["vitamin-c-glow-cream", "Vitamin C Glow Cream", "كريم فيتامين سي", "A feel-good addition to your morning routine.", "إضافة لطيفة لروتينك الصباحي.", 52, null, "Skincare", "cream", 20, "new"],
  ["night-recovery-mask", "Night Recovery Mask", "ماسك العناية الليلي", "Wind down with a little evening self-care.", "اختتمي يومك بقليل من العناية المسائية.", 38, null, "Skincare", "mask", 20, ""],
  ["habibti-kit", "The Habibti Kit", "مجموعة حبيبتي", "Your everyday makeup edit: Lipstick Red, Blush Pink, and Lip Gloss together in one set.", "مجموعة مكياجك اليومية: أحمر الشفاه والبلاشر الوردي وملمع الشفاه في مجموعة واحدة.", 90, 105, "Packages", "beauty-collection", 8, "new"],
] as const;
export const seedProducts: Product[] = samples.map(([id, name, nameAr, description, descriptionAr, price, compareAtPrice, category, image, stock, badge]) => ({ id, slug: id, name, nameAr, description, descriptionAr, price, compareAtPrice, category, images: [`/images/${image}.jpg`], stock, badge, active: true, externalId: null, externalSource: null, syncedAt: null, createdAt: "2026-09-01T00:00:00.000Z" }));
