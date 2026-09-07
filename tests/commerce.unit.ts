import test from "node:test";
import assert from "node:assert/strict";
import { randomUUID } from "node:crypto";
import mongoose from "mongoose";
process.env.MONGODB_URI = process.env.TEST_MONGODB_URI || `mongodb://127.0.0.1:27017/oopsskin_unit_${Date.now()}`;
import { db, get, put } from "../src/lib/db";
import { OrderModel } from "../src/lib/models";
import { quote, readCart, saveCart } from "../src/lib/commerce";
import { placeOrder, updateOrderStatus } from "../src/lib/orders";
import { checkoutSchema, productSchema } from "../src/lib/validation";
import type { Product, Voucher } from "../src/lib/types";

const customer = () => checkoutSchema.parse({name:"Test",email:"test@example.com",phone:"0599123456",address:"Test Street",city:"Tulkarm",notes:"",requestKey:randomUUID()});
const rejects = async (fn: () => Promise<unknown>, pattern: RegExp) => {
  await assert.rejects(fn, pattern);
};

test("money and shipping are calculated consistently in ILS", async () => {
  assert.equal((await quote([{productId:"lipstick-red",quantity:2}])).total,120);
  assert.equal((await quote([{productId:"lipstick-red",quantity:4}])).shipping,0);
  assert.equal((await quote([])).total,0);
});
test("checkout rejects overselling without writing an order", async () => {
  await saveCart("guest:stock",{items:[{productId:"lipstick-red",quantity:99}],voucherCode:""});
  await db();
  const before = await OrderModel.countDocuments();
  await rejects(() => placeOrder("guest:stock",null,customer()),/unavailable/);
  assert.equal(await OrderModel.countDocuments(),before);
  assert.equal((await get<Product>("products","lipstick-red"))!.stock,10);
});
test("guest order persists, ignores client totals, clears cart, and retry is idempotent", async () => {
  const payload=checkoutSchema.parse({...customer(),total:1,discount:999});
  await saveCart("guest:order",{items:[{productId:"lipstick-red",quantity:2}],voucherCode:""});
  const order=await placeOrder("guest:order",null,payload);
  assert.equal(order.total,120);
  assert.equal(order.userId,null);
  assert.equal((await get<Product>("products","lipstick-red"))!.stock,8);
  assert.equal((await readCart("guest:order")).items.length,0);
  assert.equal((await placeOrder("guest:order",null,payload)).id,order.id);
  assert.equal((await get<Product>("products","lipstick-red"))!.stock,8);
  await db();
  assert.ok(await OrderModel.findById(order.id).lean());
  await rejects(() => placeOrder("guest:other",null,payload),/already used/);
});
test("voucher use and stock changes are atomic", async () => {
  const voucher:Voucher={code:"ONCE",percent:10,minimum:50,maxUses:1,used:0,active:true,expiresAt:null};
  await put("vouchers",voucher.code,voucher);
  await saveCart("guest:voucher",{items:[{productId:"face-cream",quantity:1}],voucherCode:"ONCE"});
  const order=await placeOrder("guest:voucher",null,customer());
  assert.equal(order.discount,8);
  assert.equal(order.total,92);
  assert.equal((await get<Voucher>("vouchers","ONCE"))!.used,1);
  await saveCart("guest:voucher-again",{items:[{productId:"face-cream",quantity:1}],voucherCode:"ONCE"});
  await rejects(() => placeOrder("guest:voucher-again",null,customer()),/voucher/);
  assert.equal((await get<Product>("products","face-cream"))!.stock,19);
});
test("cancelling restores stock exactly once and final states cannot be reopened", async () => {
  await saveCart("guest:cancel",{items:[{productId:"face-mask",quantity:1}],voucherCode:""});
  const before=(await get<Product>("products","face-mask"))!.stock;
  const order=await placeOrder("guest:cancel",null,customer());
  await updateOrderStatus(order.id,"cancelled");
  await updateOrderStatus(order.id,"cancelled");
  assert.equal((await get<Product>("products","face-mask"))!.stock,before);
  await rejects(() => updateOrderStatus(order.id,"confirmed"),/not allowed/);
});
test("failed order insert rolls back stock and voucher changes", async () => {
  await put<Voucher>("vouchers","ROLLBACK",{code:"ROLLBACK",percent:10,minimum:0,maxUses:5,used:0,active:true,expiresAt:null});
  await saveCart("guest:rollback",{items:[{productId:"face-mask",quantity:1}],voucherCode:"ROLLBACK"});
  const before=(await get<Product>("products","face-mask"))!.stock;
  await db();
  const spy = OrderModel.create;
  // Simulate a failure during the order-insert step to verify the transaction rolls back stock/voucher writes.
  (OrderModel as unknown as { create: typeof OrderModel.create }).create = (async () => { throw new Error("test failure"); }) as typeof OrderModel.create;
  try { await rejects(() => placeOrder("guest:rollback",null,customer()),/test failure/); }
  finally { (OrderModel as unknown as { create: typeof OrderModel.create }).create = spy; }
  assert.equal((await get<Product>("products","face-mask"))!.stock,before);
  assert.equal((await get<Voucher>("vouchers","ROLLBACK"))!.used,0);
  assert.equal((await readCart("guest:rollback")).items.length,1);
});
test("archived products cannot be purchased and stale cart quantities are normalized", async () => {
  const product=(await get<Product>("products","eyeliner-black"))!;
  await put("products",product.id,{...product,stock:2});
  assert.equal((await quote([{productId:product.id,quantity:4}])).items[0].quantity,2);
  await put("products",product.id,{...product,active:false});
  assert.equal((await quote([{productId:product.id,quantity:1}])).items.length,0);
  await rejects(() => quote([{productId:product.id,quantity:1}],"",true),/unavailable/);
});
test("product validation and external source identity prevent ambiguous records", async () => {
  const product=(await get<Product>("products","hair-oil"))!;
  assert.equal(productSchema.safeParse({...product,price:-1}).success,false);
  assert.equal(productSchema.safeParse({...product,compareAtPrice:1}).success,false);
  assert.equal(productSchema.safeParse({...product,stock:0.5}).success,false);
  assert.equal(productSchema.safeParse({...product,images:["javascript:alert(1)"]}).success,false);
  await put("products",product.id,{...product,externalSource:"supplier",externalId:"123"});
  await rejects(() => put("products","duplicate",{...product,id:"duplicate",externalSource:"supplier",externalId:"123"}),/E11000|duplicate key/);
});
test.after(async () => {
  await mongoose.connection.dropDatabase();
  await mongoose.disconnect();
});
