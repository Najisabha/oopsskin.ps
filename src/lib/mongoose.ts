import mongoose from "mongoose";

// Propagate transaction sessions to model operations, including stock reservations.
mongoose.set("transactionAsyncLocalStorage", true);

const globalMongoose = globalThis as unknown as {
  oopsskinMongoose?: { conn: typeof mongoose | null; promise: Promise<typeof mongoose> | null };
};

const cache = (globalMongoose.oopsskinMongoose ??= { conn: null, promise: null });

export async function connectMongo() {
  if (cache.conn) return cache.conn;
  const uri = process.env.MONGODB_URI;
  if (!uri) throw new Error("MONGODB_URI is not set. Copy .env.example to .env.local and set it.");
  if (!cache.promise) cache.promise = mongoose.connect(uri, { bufferCommands: false });
  cache.conn = await cache.promise;
  return cache.conn;
}
