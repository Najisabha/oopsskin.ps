import { connectMongo } from "./mongoose";
import { ProductModel, VoucherModel, SettingsModel } from "./models";
import { seedProducts } from "./seed";
import type { Product, StoreSettings } from "./types";

type Table = "products" | "vouchers" | "settings";
const modelFor = { products: ProductModel, vouchers: VoucherModel, settings: SettingsModel } as const;

function toPlain<T>(doc: Record<string, unknown>): T {
  if (doc.externalSource === "hsabate" && doc.storefront) return { ...(doc.storefront as Product), id: String(doc._id) } as T;
  const { _id, ...rest } = doc;
  return { id: _id, ...rest } as T;
}
function toDoc<T extends { id: string }>(value: T) {
  const { id, ...rest } = value;
  return { _id: id, ...rest };
}

let seeded: Promise<void> | null = null;
export async function db() {
  await connectMongo();
  if (!seeded) seeded = ensureSeed();
  await seeded;
}

async function ensureSeed() {
  const marker = await SettingsModel.findById("initialized").lean();
  if (marker) return;
  for (const product of seedProducts) {
    await ProductModel.updateOne({ _id: product.id }, { $setOnInsert: toDoc(product) }, { upsert: true });
  }
  await SettingsModel.updateOne(
    { _id: "store" },
    { $setOnInsert: { shippingFee: 20, freeShippingThreshold: 200, contactEmail: "" } },
    { upsert: true }
  );
  await SettingsModel.updateOne({ _id: "initialized" }, { $setOnInsert: { value: true } }, { upsert: true });
}

export async function all<T>(table: Table): Promise<T[]> {
  await db();
  const docs = await modelFor[table].find(table === "settings" ? { _id: { $ne: "initialized" } } : {}).lean();
  return docs.map(d => toPlain<T>(d as Record<string, unknown>));
}
export async function get<T>(table: Table, id: string): Promise<T | undefined> {
  await db();
  const doc = await modelFor[table].findById(id).lean();
  return doc ? toPlain<T>(doc as Record<string, unknown>) : undefined;
}
export async function put<T extends { id?: string } & Record<string, unknown>>(table: Table, id: string, value: T) {
  await db();
  if (table === "products") {
    const existing = await ProductModel.findById(id).lean();
    if (existing?.externalSource === "hsabate") {
      // Checkout reservations affect availability, never overwrite supplier fields.
      if (typeof value.stock !== "number") throw new Error("Hsabate products are API managed.");
      const previous = Number(existing.storefront.stock);
      const updated = await ProductModel.updateOne({ _id: id, "storefront.stock": previous }, { $inc: { reservedStock: previous - value.stock }, $set: { "storefront.stock": value.stock } });
      if (!updated.matchedCount) throw new Error("Product availability changed. Please retry.");
      return;
    }
  }
  const { id: _omit, ...rest } = value;
  await modelFor[table].updateOne({ _id: id }, { $set: rest }, { upsert: true });
}
export async function products(): Promise<Product[]> {
  const list = await all<Product>("products");
  return list.filter(p => p.active);
}
export async function settings(): Promise<StoreSettings> {
  return (await get<StoreSettings>("settings", "store"))!;
}

export async function transaction<T>(fn: () => Promise<T>): Promise<T> {
  await db();
  const mongoose = await connectMongo();
  try {
    return await mongoose.connection.transaction(async () => fn());
  } catch (error) {
    // Existing local standalone development databases cannot use transactions.
    if (error instanceof Error && /Transaction numbers are only allowed|IllegalOperation/.test(error.message)) return fn();
    throw error;
  }
}
