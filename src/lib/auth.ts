import { randomBytes, scryptSync, timingSafeEqual, createHash } from "node:crypto";
import { cookies } from "next/headers";
import { db } from "./db";
import type { User } from "./types";

export function hashPassword(password: string) { const salt = randomBytes(16).toString("hex"); return `${salt}:${scryptSync(password, salt, 64).toString("hex")}`; }
export function verifyPassword(password: string, stored: string) { const [salt, hash] = stored.split(":"); const expected = Buffer.from(hash, "hex"); const actual = scryptSync(password, salt, 64); return expected.length === actual.length && timingSafeEqual(expected, actual); }
const digest = (value: string) => createHash("sha256").update(value).digest("hex");
const cookieOptions = { httpOnly: true, secure: process.env.NODE_ENV === "production", sameSite: "lax" as const, path: "/" };
export async function currentUser(): Promise<User | null> {
  const token = (await cookies()).get("oopsskin_session")?.value;
  if (!token) return null;
  const row = db().prepare("SELECT u.data FROM sessions s JOIN users u ON s.user_id=u.id WHERE s.token_hash=? AND s.expires_at>?").get(digest(token), Date.now());
  return row ? JSON.parse(String(row.data)) : null;
}
export async function startSession(userId: string) {
  await endSession();
  const token = randomBytes(32).toString("hex");
  db().prepare("DELETE FROM sessions WHERE expires_at < ?").run(Date.now());
  db().prepare("INSERT INTO sessions VALUES (?,?,?)").run(digest(token), userId, Date.now() + 30 * 86400000);
  (await cookies()).set("oopsskin_session", token, { ...cookieOptions, maxAge: 30 * 86400 });
}
export async function endSession() { const jar = await cookies(); const token = jar.get("oopsskin_session")?.value; if (token) db().prepare("DELETE FROM sessions WHERE token_hash=?").run(digest(token)); jar.delete("oopsskin_session"); }
export async function cartOwner(user: User | null) {
  if (user) return `user:${user.id}`;
  const jar = await cookies();
  let id = jar.get("oopsskin_cart")?.value;
  if (!id || !/^[a-f0-9]{48}$/.test(id)) { id = randomBytes(24).toString("hex"); jar.set("oopsskin_cart", id, { ...cookieOptions, maxAge: 30 * 86400 }); }
  return `guest:${id}`;
}
export function limitAuth(email: string) {
  const key = digest(email);
  const now = Date.now();
  db().prepare("DELETE FROM login_attempts WHERE reset_at<?").run(now);
  const row = db().prepare("SELECT count FROM login_attempts WHERE key=?").get(key);
  if (row && Number(row.count) >= 15) return false;
  db().prepare("INSERT INTO login_attempts VALUES (?,1,?) ON CONFLICT(key) DO UPDATE SET count=count+1").run(key, now + 15 * 60000);
  return true;
}
