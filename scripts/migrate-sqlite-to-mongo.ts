import { DatabaseSync } from "node:sqlite";
import path from "node:path";
import { connectMongo } from "../src/lib/mongoose";
import {
  ProductModel,
  UserModel,
  SessionModel,
  CartModel,
  OrderModel,
  VoucherModel,
  SettingsModel,
  LoginAttemptModel,
} from "../src/lib/models";

// One-time migration from the legacy node:sqlite store (data/store.sqlite) into MongoDB.
// Run with: npx tsx scripts/migrate-sqlite-to-mongo.ts
async function main() {
  const sqlitePath = process.env.DATABASE_PATH || path.join(process.cwd(), "data", "store.sqlite");
  const sqlite = new DatabaseSync(sqlitePath);
  await connectMongo();

  let migrated = 0;

  for (const row of sqlite.prepare("SELECT id, data FROM products").all()) {
    const data = JSON.parse(String(row.data));
    await ProductModel.updateOne({ _id: row.id }, { $set: data }, { upsert: true });
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT id, email, password_hash, data FROM users").all()) {
    const data = JSON.parse(String(row.data));
    const { id: _id, ...rest } = data;
    await UserModel.updateOne({ _id: row.id }, { $set: { ...rest, email: row.email, passwordHash: row.password_hash } }, { upsert: true });
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT token_hash, user_id, expires_at FROM sessions").all()) {
    await SessionModel.updateOne({ _id: row.token_hash }, { $set: { userId: row.user_id, expiresAt: row.expires_at } }, { upsert: true });
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT owner, data FROM carts").all()) {
    const data = JSON.parse(String(row.data));
    await CartModel.updateOne({ _id: row.owner }, { $set: data }, { upsert: true });
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT id, user_id, request_key, owner, data FROM orders").all()) {
    const data = JSON.parse(String(row.data));
    const { id: _id, ...rest } = data;
    await OrderModel.updateOne({ _id: row.id }, { $set: { ...rest, userId: row.user_id, requestKey: row.request_key, owner: row.owner } }, { upsert: true });
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT id, data FROM vouchers").all()) {
    const data = JSON.parse(String(row.data));
    const { code: _code, ...rest } = data;
    await VoucherModel.updateOne({ _id: row.id }, { $set: rest }, { upsert: true });
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT id, data FROM settings").all()) {
    const data = JSON.parse(String(row.data));
    if (row.id === "initialized") {
      await SettingsModel.updateOne({ _id: "initialized" }, { $set: { value: true } }, { upsert: true });
    } else {
      await SettingsModel.updateOne({ _id: row.id }, { $set: data }, { upsert: true });
    }
    migrated++;
  }

  for (const row of sqlite.prepare("SELECT key, count, reset_at FROM login_attempts").all()) {
    await LoginAttemptModel.updateOne({ _id: row.key }, { $set: { count: row.count, resetAt: row.reset_at } }, { upsert: true });
    migrated++;
  }

  sqlite.close();
  console.log(`Migrated ${migrated} records from SQLite to MongoDB.`);
  process.exit(0);
}

void main().catch(e => { console.error(e); process.exit(1); });
