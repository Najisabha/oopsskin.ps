import { randomBytes, scryptSync, timingSafeEqual, createHash } from "node:crypto";
import { cookies } from "next/headers";
import { db } from "./db";
import { SessionModel, UserModel, LoginAttemptModel } from "./models";
import type { User } from "./types";

export function hashPassword(password: string) { const salt = randomBytes(16).toString("hex"); return `${salt}:${scryptSync(password, salt, 64).toString("hex")}`; }
export function verifyPassword(password: string, stored: string) { const [salt, hash] = stored.split(":"); const expected = Buffer.from(hash, "hex"); const actual = scryptSync(password, salt, 64); return expected.length === actual.length && timingSafeEqual(expected, actual); }
const digest = (value: string) => createHash("sha256").update(value).digest("hex");
const cookieOptions = { httpOnly: true, secure: process.env.NODE_ENV === "production", sameSite: "lax" as const, path: "/" };

function toUser(doc: Record<string, unknown>): User {
  const { _id, passwordHash: _ph, ...rest } = doc;
  return { id: _id as string, ...rest } as User;
}

export async function currentUser(): Promise<User | null> {
  const token = (await cookies()).get("oopsskin_session")?.value;
  if (!token) return null;
  await db();
  const session = await SessionModel.findOne({ _id: digest(token), expiresAt: { $gt: Date.now() } }).lean();
  if (!session) return null;
  const user = await UserModel.findById(session.userId).lean();
  return user ? toUser(user as Record<string, unknown>) : null;
}
export async function startSession(userId: string) {
  await endSession();
  await db();
  const token = randomBytes(32).toString("hex");
  await SessionModel.deleteMany({ expiresAt: { $lt: Date.now() } });
  await SessionModel.create({ _id: digest(token), userId, expiresAt: Date.now() + 30 * 86400000 });
  (await cookies()).set("oopsskin_session", token, { ...cookieOptions, maxAge: 30 * 86400 });
}
export async function endSession() {
  const jar = await cookies();
  const token = jar.get("oopsskin_session")?.value;
  if (token) { await db(); await SessionModel.deleteOne({ _id: digest(token) }); }
  jar.delete("oopsskin_session");
}
export async function cartOwner(user: User | null) {
  if (user) return `user:${user.id}`;
  const jar = await cookies();
  let id = jar.get("oopsskin_cart")?.value;
  if (!id || !/^[a-f0-9]{48}$/.test(id)) { id = randomBytes(24).toString("hex"); jar.set("oopsskin_cart", id, { ...cookieOptions, maxAge: 30 * 86400 }); }
  return `guest:${id}`;
}
export async function limitAuth(email: string) {
  await db();
  const key = digest(email);
  const now = Date.now();
  await LoginAttemptModel.deleteMany({ resetAt: { $lt: now } });
  const row = await LoginAttemptModel.findById(key).lean();
  if (row && row.count >= 15) return false;
  await LoginAttemptModel.updateOne(
    { _id: key },
    row
      ? { $inc: { count: 1 } }
      : { $set: { count: 1, resetAt: now + 15 * 60000 } },
    { upsert: true }
  );
  return true;
}
