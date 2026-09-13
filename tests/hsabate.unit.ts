import test from 'node:test';
import assert from 'node:assert/strict';
import { productView, validateProducts } from '../src/lib/hsabate-product';
const row = { id: '3', name: 'منتج', name_e: 'Product', price: '85.50', amount: 12, class_id: '3', item_img: 'https://example.com/product.jpg', cost: '10', measure: [{ id: 1 }] };
test('supplier record keeps all original field names and types', () => {
  const result = validateProducts([row])[0];
  assert.deepEqual(result, row);
  assert.equal(typeof result.price, 'string');
  assert.equal(typeof result.amount, 'number');
});
test('storefront projection converts price and retains order reservations', () => {
  const product = productView(row, 'SKIN CARE', true, '2026-09-13', 4);
  assert.equal(product.price, 85.5);
  assert.equal(product.stock, 8);
  assert.equal(product.category, 'Skincare');
  assert.equal(product.name, 'Product');
  assert.equal(product.nameAr, 'منتج');
  assert.equal('cost' in product, false);
  assert.equal('measure' in product, false);
  assert.equal(row.amount, 12);
});
test('visibility, negative stock and unsafe images are handled', () => {
  const product = productView({ ...row, amount: '-3', item_img: 'javascript:alert(1)' }, 'Other', false, 'now');
  assert.equal(product.stock, 0);
  assert.equal(product.active, false);
  assert.deepEqual(product.images, ['/images/product-placeholder.svg']);
});
test('empty, duplicate, malformed and reserved-field payloads stop the whole sync', () => {
  for (const bad of [[], null, [row, row], [{ ...row, price: '' }], [{ ...row, amount: 'NaN' }], [{ ...row, price: -1 }], [{ ...row, _id: 'override' }], [{ ...row, name: '' }]]) assert.throws(() => validateProducts(bad));
});
test('supplier storage image paths resolve against the production host', () => {
  assert.equal(productView({ ...row, item_img: 'storage/db_22503/db_22503p3.gif' }, '', true, 'now').images[0], 'https://s.hesabate.com/storage/db_22503/db_22503p3.gif');
});
