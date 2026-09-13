import { randomUUID } from 'node:crypto';
import { connectMongo } from './mongoose';
import { ProductModel, SyncStateModel } from './models';
import { ApiError } from './commerce';
import { productView, validateProducts } from './hsabate-product';

export const HSABATE_URL = 'https://s.hesabate.com/store_api.php';
const scope = { all: '1', view_items_by: '1', pro_id: '' };
async function request(fields: Record<string, string>) {
  const form = new FormData();
  for (const [key, value] of Object.entries(fields)) form.set(key, value);
  let response: Response;
  try { response = await fetch(HSABATE_URL, { method: 'POST', body: form, cache: 'no-store', redirect: 'error', signal: AbortSignal.timeout(45000) }); }
  catch { throw new ApiError('Hsabate connection failed or timed out.', 502); }
  if (!response.ok) throw new ApiError(`Hsabate HTTP error ${response.status}.`, 502);
  try { return await response.json() as Record<string, unknown>; }
  catch { throw new ApiError('Hsabate returned invalid JSON.', 502); }
}
async function authenticate() {
  const username = process.env.HSABATE_EMAIL, password = process.env.HSABATE_PASSWORD;
  if (!username || !password) throw new ApiError('Configure HSABATE_EMAIL and HSABATE_PASSWORD on the server.', 503);
  const data = await request({ action: 'Auth', username, password });
  if (typeof data.token !== 'string' || !data.token) throw new ApiError('Hsabate authentication failed. Check the configured credentials.', 502);
  return data.token;
}
async function download(token: string, type: string, params: Record<string, string> = {}) {
  const data = await request({ action: 'download', token, type, ...params });
  if (data.status !== 'succes' || !Array.isArray(data.table)) {
    const code = /^\d+$/.test(String(data.code)) ? String(data.code) : 'unknown';
    throw new ApiError(`Hsabate ${type} failed (code ${code}).`, 502);
  }
  return data.table;
}
export async function fetchCatalog() {
  const token = await authenticate();
  // Sequential requests avoid overlapping use of the account token.
  const rows = validateProducts(await download(token, 'products', scope));
  const visible = validateProducts(await download(token, 'products', { all: '0', view_items_by: '1', pro_id: '' }));
  const categories = await download(token, 'category');
  const ids = new Set(rows.map(row => row.id));
  if (visible.some(row => !ids.has(row.id))) throw new ApiError('Hsabate catalog changed during download. Retry sync.', 502);
  return { rows, visible: new Set(visible.map(row => row.id)), categories: new Map(categories.map(row => [String(row.id), String(row.name)])) };
}
export async function hsabateStatus() {
  await connectMongo();
  const state = await SyncStateModel.findById('hsabate').lean();
  const [total, active] = await Promise.all([
    ProductModel.countDocuments({ externalSource: 'hsabate' }),
    ProductModel.countDocuments({ externalSource: 'hsabate', 'storefront.active': true }),
  ]);
  return { locked: Boolean(state?.lockedUntil && new Date(state.lockedUntil).getTime() > Date.now()), endpoint: HSABATE_URL, configured: Boolean(process.env.HSABATE_EMAIL && process.env.HSABATE_PASSWORD), total, active, state };
}
export async function debugHsabate() {
  const start = Date.now();
  const catalog = await fetchCatalog();
  return { checkedAt: new Date().toISOString(), durationMs: Date.now() - start, total: catalog.rows.length, ecommerce: catalog.visible.size, fields: Object.keys(catalog.rows[0]), sample: catalog.rows.slice(0, 3) };
}
export async function syncHsabate() {
  const mongo = await connectMongo();
  await ProductModel.init();
  const collection = mongo.connection.db!.collection<{ _id: string; [key: string]: unknown }>(ProductModel.collection.name);
  await SyncStateModel.updateOne({ _id: 'hsabate' }, { $setOnInsert: { lockedUntil: new Date(0) } }, { upsert: true });
  const runId = randomUUID(), startedAt = new Date();
  const lock = await SyncStateModel.findOneAndUpdate({ _id: 'hsabate', lockedUntil: { $lte: startedAt } }, { $set: { runId, lockedUntil: new Date(Date.now() + 10 * 60_000), startedAt: startedAt.toISOString(), status: 'running', error: null } }, { returnDocument: 'after' });
  if (!lock) throw new ApiError('A product sync is already running.', 409);
  try {
    const { rows, visible, categories } = await fetchCatalog();
    const now = new Date().toISOString();
    const session = await mongo.startSession();
    let summary = { received: rows.length, active: visible.size, inserted: 0, updated: 0, archived: 0, durationMs: 0, finishedAt: now };
    try {
      await session.withTransaction(async () => {
        const current = await collection.find({ externalSource: 'hsabate' }, { session }).toArray();
        const byId = new Map(current.map(row => [String(row.externalId), row]));
        const operations = rows.map(row => {
          const old = byId.get(row.id);
          const view = productView(row, categories.get(String(row.class_id)) || '', visible.has(row.id), now, Number(old?.reservedStock || 0));
          view.id = String(old?._id || view.id);
          view.createdAt = String(old?.createdAt || now);
          return { replaceOne: { filter: { _id: view.id }, replacement: { ...row, _id: view.id, storefront: view, externalSource: 'hsabate', externalId: row.id, syncedAt: now, createdAt: view.createdAt, reservedStock: Number(old?.reservedStock || 0) }, upsert: true } };
        });
        // Native collection keeps every supplier field and JSON value type unchanged.
        const result = await collection.bulkWrite(operations, { session });
        const missing = await collection.updateMany({ externalSource: 'hsabate', externalId: { $nin: rows.map(row => row.id) }, 'storefront.active': true }, { $set: { 'storefront.active': false, 'storefront.stock': 0, 'storefront.syncedAt': now, syncedAt: now } }, { session });
        const legacy = await collection.updateMany({ externalSource: { $ne: 'hsabate' }, active: true }, { $set: { active: false } }, { session });
        summary = { ...summary, inserted: result.upsertedCount, updated: result.matchedCount, archived: missing.modifiedCount + legacy.modifiedCount, durationMs: Date.now() - startedAt.getTime(), finishedAt: new Date().toISOString() };
        const released = await SyncStateModel.updateOne({ _id: 'hsabate', runId, lockedUntil: { $gt: new Date() } }, { $set: { status: 'success', lockedUntil: new Date(0), lastSuccess: summary, error: null }, $push: { history: { $each: [summary], $slice: -10 } } }, { session });
        if (!released.matchedCount) throw new Error('Sync lock expired. Retry sync.');
      });
    } finally { await session.endSession(); }
    return summary;
  } catch (error) {
    const message = error instanceof ApiError ? error.message : 'Product sync failed validation or database commit. No partial catalog was committed.';
    await SyncStateModel.updateOne({ _id: 'hsabate', runId }, { $set: { status: 'error', error: message, lockedUntil: new Date(0), finishedAt: new Date().toISOString() } });
    throw new ApiError(message, 502);
  }
}
