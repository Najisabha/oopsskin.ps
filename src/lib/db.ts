import { DatabaseSync } from "node:sqlite";
import { mkdirSync } from "node:fs";
import path from "node:path";
import { seedProducts } from "./seed";
import type { Product, StoreSettings } from "./types";

const globalDb = globalThis as unknown as { oopsskinDb?: DatabaseSync };
export function db() {
  if (globalDb.oopsskinDb) return globalDb.oopsskinDb;
  const filename = process.env.DATABASE_PATH || path.join(process.cwd(), "data", "store.sqlite");
  mkdirSync(path.dirname(filename), { recursive: true });
  const database = new DatabaseSync(filename);
  database.exec(`PRAGMA journal_mode = WAL; PRAGMA foreign_keys = ON; PRAGMA busy_timeout = 5000;
    CREATE TABLE IF NOT EXISTS products (id TEXT PRIMARY KEY, data TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS users (id TEXT PRIMARY KEY, email TEXT NOT NULL UNIQUE, password_hash TEXT NOT NULL, data TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS sessions (token_hash TEXT PRIMARY KEY, user_id TEXT NOT NULL REFERENCES users(id), expires_at INTEGER NOT NULL);
    CREATE TABLE IF NOT EXISTS carts (owner TEXT PRIMARY KEY, data TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS orders (id TEXT PRIMARY KEY, user_id TEXT, request_key TEXT NOT NULL UNIQUE, owner TEXT NOT NULL, data TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS vouchers (id TEXT PRIMARY KEY, data TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS settings (id TEXT PRIMARY KEY, data TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS login_attempts (key TEXT PRIMARY KEY, count INTEGER NOT NULL, reset_at INTEGER NOT NULL);
    CREATE UNIQUE INDEX IF NOT EXISTS products_external ON products(json_extract(data, '$.externalSource'), json_extract(data, '$.externalId')) WHERE json_extract(data, '$.externalId') IS NOT NULL;
  `);
  globalDb.oopsskinDb = database;
  if (!database.prepare("SELECT id FROM settings WHERE id = 'initialized'").get()) {
    database.exec("BEGIN IMMEDIATE");
    try {
      for (const product of seedProducts) database.prepare("INSERT OR IGNORE INTO products VALUES (?,?)").run(product.id, JSON.stringify(product));
      database.prepare("INSERT INTO settings VALUES ('store',?)").run(JSON.stringify({ shippingFee: 20, freeShippingThreshold: 200, contactEmail: "" }));
      database.prepare("INSERT INTO settings VALUES ('initialized','true')").run();
      database.exec("COMMIT");
    } catch (e) { database.exec("ROLLBACK"); throw e; }
  }
  return database;
}
type Table = "products" | "vouchers" | "settings";
export function all<T>(table: Table): T[] { return db().prepare(`SELECT data FROM ${table}`).all().map(row => JSON.parse(String(row.data))); }
export function get<T>(table: Table, id: string): T | undefined { const row = db().prepare(`SELECT data FROM ${table} WHERE id = ?`).get(id); return row ? JSON.parse(String(row.data)) : undefined; }
export function put<T>(table: Table, id: string, value: T) { db().prepare(`INSERT INTO ${table}(id,data) VALUES (?,?) ON CONFLICT(id) DO UPDATE SET data=excluded.data`).run(id, JSON.stringify(value)); }
export function products() { return all<Product>("products").filter(p => p.active); }
export function settings() { return get<StoreSettings>("settings", "store")!; }
export function transaction<T>(fn: () => T): T { db().exec("BEGIN IMMEDIATE"); try { const result = fn(); db().exec("COMMIT"); return result; } catch (e) { db().exec("ROLLBACK"); throw e; } }
