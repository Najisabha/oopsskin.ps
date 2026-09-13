import { z } from "zod";
const text = (max = 200) => z.string().trim().min(1).max(max);
const price = z.number().finite().min(0).max(1000000).transform(v => Math.round(v * 100) / 100);
export const profileSchema = z.object({ name: text(100), phone: z.string().trim().max(30).default(""), address: z.string().trim().max(500).default(""), city: z.string().trim().max(100).default("") });
export const authSchema = z.object({ email: z.email().max(254).transform(v => v.toLowerCase()), password: z.string().min(8).max(128) });
export const registerSchema = authSchema.extend({ name: text(100), phone: z.string().max(30).default("") });
export const cartSchema = z.object({ productId: text(100), quantity: z.number().int().min(0).max(99) });
export const checkoutSchema = z.object({ name: text(100), email: z.email().max(254), phone: z.string().trim().regex(/^[+\d\s()-]{7,25}$/, "Enter a valid phone number"), address: text(500), city: text(100), notes: z.string().max(1000).default(""), requestKey: z.uuid() });
export const productSchema = z.object({ name: text(200), nameAr: text(200), description: text(5000), descriptionAr: text(5000), price, compareAtPrice: price.nullable().default(null), category: z.enum(["Skincare", "Makeup", "Packages", "Haircare", "Fragrance", "Tools"]), images: z.array(z.string().max(2000).refine(v => /^\/images\/[\w.-]+$/.test(v) || /^https:\/\/[^\s]+$/.test(v), "Use a local /images/ path or HTTPS URL")).min(1).max(8), stock: z.number().int().min(0).max(1000000), badge: z.enum(["", "new", "best-seller"]).default(""), active: z.boolean().default(true), externalId: z.string().trim().min(1).max(200).nullable().default(null), externalSource: z.string().trim().min(1).max(200).nullable().default(null) }).refine(p => p.compareAtPrice === null || p.compareAtPrice > p.price, { message: "Original price must be greater than the sale price", path: ["compareAtPrice"] });
export const voucherSchema = z.object({ code: text(40).transform(v => v.toUpperCase()), percent: z.number().min(1).max(100), minimum: price, maxUses: z.number().int().min(1).max(1000000), active: z.boolean(), expiresAt: z.iso.datetime().nullable().default(null) });
const navigationLinkSchema = z.object({
  href: text(500).refine(v => /^\/(?!\/)[^\s\\]*$/.test(v), "Use an internal path starting with /"),
  label: text(80), labelAr: text(80), visible: z.boolean(),
});
const storePageSchema = z.object({
  slug: text(100).regex(/^[a-z0-9]+(?:-[a-z0-9]+)*$/).refine(v => !["admin", "api", "product", "about", "cart", "checkout", "favorites", "login", "profile", "register"].includes(v), "This path is reserved"),
  title: text(200), titleAr: text(200), description: z.string().trim().max(2000), descriptionAr: z.string().trim().max(2000),
  active: z.boolean(), mode: z.enum(["automatic", "manual"]), productIds: z.array(text(100)).max(1000).refine(ids => new Set(ids).size === ids.length, "Duplicate products"),
});
export const settingsSchema = z.object({
  shippingFee: price.optional(), freeShippingThreshold: price.optional(), contactEmail: z.union([z.email(), z.literal("")]).optional(),
  navigation: z.array(navigationLinkSchema).max(20).optional(),
  pages: z.array(storePageSchema).max(50).refine(pages => new Set(pages.map(p => p.slug)).size === pages.length, "Page paths must be unique").optional(),
  homeProductCount: z.number().int().min(8).max(48).optional(),
}).refine(value => Object.keys(value).length > 0, "No settings supplied");
