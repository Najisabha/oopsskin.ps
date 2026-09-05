import test from "node:test";
import assert from "node:assert/strict";
import { mkdtempSync } from "node:fs";
import os from "node:os";
import path from "node:path";
import { randomUUID } from "node:crypto";
import { db, get, put } from "../src/lib/db";
import { quote, readCart, saveCart } from "../src/lib/commerce";
import { placeOrder, updateOrderStatus } from "../src/lib/orders";
import { checkoutSchema, productSchema } from "../src/lib/validation";
import type { Product, Voucher } from "../src/lib/types";
process.env.DATABASE_PATH = path.join(mkdtempSync(path.join(os.tmpdir(),"oopsskin-unit-")),"store.sqlite");
const customer = () => checkoutSchema.parse({name:"Test",email:"test@example.com",phone:"0599123456",address:"Test Street",city:"Tulkarm",notes:"",requestKey:randomUUID()});

test("money and shipping are calculated consistently in ILS", () => {
  assert.equal(quote([{productId:"lipstick-red",quantity:2}]).total,120);
  assert.equal(quote([{productId:"lipstick-red",quantity:4}]).shipping,0);
  assert.equal(quote([]).total,0);
});
test("checkout rejects overselling without writing an order", () => {
  saveCart("guest:stock",{items:[{productId:"lipstick-red",quantity:99}],voucherCode:""});
  const before=db().prepare("SELECT count(*) AS n FROM orders").get()!.n;
  assert.throws(()=>placeOrder("guest:stock",null,customer()),/unavailable/);
  assert.equal(db().prepare("SELECT count(*) AS n FROM orders").get()!.n,before);
  assert.equal(get<Product>("products","lipstick-red")!.stock,10);
});
test("guest order persists, ignores client totals, clears cart, and retry is idempotent", () => {
  const payload=checkoutSchema.parse({...customer(),total:1,discount:999});
  saveCart("guest:order",{items:[{productId:"lipstick-red",quantity:2}],voucherCode:""});
  const order=placeOrder("guest:order",null,payload);
  assert.equal(order.total,120);
  assert.equal(order.userId,null);
  assert.equal(get<Product>("products","lipstick-red")!.stock,8);
  assert.equal(readCart("guest:order").items.length,0);
  assert.equal(placeOrder("guest:order",null,payload).id,order.id);
  assert.equal(get<Product>("products","lipstick-red")!.stock,8);
  assert.ok(db().prepare("SELECT id FROM orders WHERE id=?").get(order.id));
  assert.throws(()=>placeOrder("guest:other",null,payload),/already used/);
});
test("voucher use and stock changes are atomic", () => {
  const voucher:Voucher={code:"ONCE",percent:10,minimum:50,maxUses:1,used:0,active:true,expiresAt:null};
  put("vouchers",voucher.code,voucher);
  saveCart("guest:voucher",{items:[{productId:"face-cream",quantity:1}],voucherCode:"ONCE"});
  const order=placeOrder("guest:voucher",null,customer());
  assert.equal(order.discount,8);
  assert.equal(order.total,92);
  assert.equal(get<Voucher>("vouchers","ONCE")!.used,1);
  saveCart("guest:voucher-again",{items:[{productId:"face-cream",quantity:1}],voucherCode:"ONCE"});
  assert.throws(()=>placeOrder("guest:voucher-again",null,customer()),/voucher/);
  assert.equal(get<Product>("products","face-cream")!.stock,19);
});
test("cancelling restores stock exactly once and final states cannot be reopened", () => {
  saveCart("guest:cancel",{items:[{productId:"face-mask",quantity:1}],voucherCode:""});
  const before=get<Product>("products","face-mask")!.stock;
  const order=placeOrder("guest:cancel",null,customer());
  updateOrderStatus(order.id,"cancelled");
  updateOrderStatus(order.id,"cancelled");
  assert.equal(get<Product>("products","face-mask")!.stock,before);
  assert.throws(()=>updateOrderStatus(order.id,"confirmed"),/not allowed/);
});
test("failed order insert rolls back stock and voucher changes", () => {
  put<Voucher>("vouchers","ROLLBACK",{code:"ROLLBACK",percent:10,minimum:0,maxUses:5,used:0,active:true,expiresAt:null});
  saveCart("guest:rollback",{items:[{productId:"face-mask",quantity:1}],voucherCode:"ROLLBACK"});
  const before=get<Product>("products","face-mask")!.stock;
  db().exec("CREATE TRIGGER test_order_failure BEFORE INSERT ON orders BEGIN SELECT RAISE(ABORT, 'test failure'); END;");
  try { assert.throws(()=>placeOrder("guest:rollback",null,customer()),/test failure/); }
  finally { db().exec("DROP TRIGGER test_order_failure"); }
  assert.equal(get<Product>("products","face-mask")!.stock,before);
  assert.equal(get<Voucher>("vouchers","ROLLBACK")!.used,0);
  assert.equal(readCart("guest:rollback").items.length,1);
});
test("archived products cannot be purchased and stale cart quantities are normalized", () => {
  const product=get<Product>("products","eyeliner-black")!;
  put("products",product.id,{...product,stock:2});
  assert.equal(quote([{productId:product.id,quantity:4}]).items[0].quantity,2);
  put("products",product.id,{...product,active:false});
  assert.equal(quote([{productId:product.id,quantity:1}]).items.length,0);
  assert.throws(()=>quote([{productId:product.id,quantity:1}],"",true),/unavailable/);
});
test("product validation and external source identity prevent ambiguous records", () => {
  const product=get<Product>("products","hair-oil")!;
  assert.equal(productSchema.safeParse({...product,price:-1}).success,false);
  assert.equal(productSchema.safeParse({...product,compareAtPrice:1}).success,false);
  assert.equal(productSchema.safeParse({...product,stock:0.5}).success,false);
  assert.equal(productSchema.safeParse({...product,images:["javascript:alert(1)"]}).success,false);
  put("products",product.id,{...product,externalSource:"supplier",externalId:"123"});
  assert.throws(()=>put("products","duplicate",{...product,id:"duplicate",externalSource:"supplier",externalId:"123"}),/UNIQUE/);
});
