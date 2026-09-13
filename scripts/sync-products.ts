import { loadEnvConfig } from '@next/env';
import { mkdir, writeFile } from 'node:fs/promises';
import mongoose from 'mongoose';
import { connectMongo } from '../src/lib/mongoose';
import { ProductModel } from '../src/lib/models';
import { debugHsabate, syncHsabate } from '../src/lib/hsabate';
loadEnvConfig(process.cwd());
async function main() {
  if (process.argv.includes('--debug')) { console.log(JSON.stringify(await debugHsabate(), null, 2)); return; }
  await connectMongo();
  await mkdir('data/backups', { recursive: true });
  const path = `data/backups/products-before-sync-${Date.now()}.json`;
  await writeFile(path, JSON.stringify(await ProductModel.collection.find({}).toArray()), { mode: 0o600 });
  console.log(`Product backup saved: ${path}`);
  console.log(JSON.stringify(await syncHsabate(), null, 2));
}
main().catch(() => { console.error('Sync failed. Check the admin API dashboard for the sanitized error.'); process.exitCode = 1; }).finally(() => mongoose.disconnect());
