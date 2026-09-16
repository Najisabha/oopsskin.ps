import type { Product } from './types';

export type ApiProduct = Record<string, unknown> & { id: string; name: string; price: string | number; amount: string | number };
export function validateProducts(value: unknown): ApiProduct[] {
  if (!Array.isArray(value) || !value.length) throw new Error('Hsabate returned an empty product catalog; sync was stopped.');
  const ids = new Set<string>();
  return value.map(row => {
    if (!row || typeof row !== 'object' || Array.isArray(row)) throw new Error('Invalid product record.');
    if (typeof row.id !== 'string' || !/^\d+$/.test(row.id) || ids.has(row.id)) throw new Error('Missing, invalid or duplicate product ID.');
    if (typeof row.name !== 'string' || !row.name.trim()) throw new Error(`Product ${row.id} has no name.`);
    for (const field of ['price', 'amount']) {
      if (!['string', 'number'].includes(typeof row[field]) || String(row[field]).trim() === '' || !Number.isFinite(Number(row[field]))) throw new Error(`Product ${row.id} has invalid ${field}.`);
    }
    if (Number(row.price) < 0) throw new Error(`Product ${row.id} has a negative price.`);
    if (Object.keys(row).some(key => key.startsWith('$') || key.includes('.') || ['_id', '__proto__', 'constructor', 'prototype', 'storefront', 'externalSource', 'externalId', 'syncedAt', 'createdAt', 'reservedStock'].includes(key))) throw new Error('Unexpected reserved product field.');
    ids.add(row.id);
    return row as ApiProduct;
  });
}
// Readable URL segment. Latin and Arabic letters are kept, everything else becomes a dash.
// The supplier id is appended so slugs stay unique even when two products share a name.
export function productSlug(name: string, externalId: string): string {
  const base = name
    .normalize('NFKD')
    .replace(/[̀-ًͯ-ْ]/g, '')
    .toLowerCase()
    .replace(/[^a-z0-9ء-ي]+/g, '-')
    .replace(/^-+|-+$/g, '')
    .slice(0, 60)
    .replace(/-+$/g, '');
  return base ? `${base}-${externalId}` : externalId;
}

export function productView(row: ApiProduct, category: string, active: boolean, now: string, reserved = 0): Product {
  const english = typeof row.name_e === 'string' && row.name_e.trim() ? row.name_e : row.name;
  const description = typeof row.note === 'string' ? row.note : '';
  const image = typeof row.item_img === 'string' && /^https:\/\//i.test(row.item_img) ? row.item_img : typeof row.item_img === 'string' && /^\/?storage\/[\w/.-]+$/.test(row.item_img) ? new URL(row.item_img, 'https://s.hesabate.com/').href : '/images/product-placeholder.svg';
  const categoryMap: Record<string, string> = { 'skin care': 'Skincare', 'hair care': 'Haircare', 'make up': 'Makeup', 'global makeup': 'Makeup', 'ميك اب براند': 'Makeup', 'العطور': 'Fragrance' };
  return { id: `hsabate:${row.id}`, slug: productSlug(english || row.name, row.id), name: english, nameAr: row.name, description, descriptionAr: description, price: Number(row.price), compareAtPrice: null, category: categoryMap[category.toLowerCase()] || category || 'Uncategorized', images: [image], stock: Math.max(0, Math.floor(Number(row.amount) - reserved)), badge: '', active, externalId: row.id, externalSource: 'hsabate', syncedAt: now, createdAt: now };
}
