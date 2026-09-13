import test from "node:test";
import assert from "node:assert/strict";
import { defaultPages, pageProducts } from "../src/lib/store-content";
import { settingsSchema } from "../src/lib/validation";
import { seedProducts } from "../src/lib/seed";

test("manual collections preserve order and exclude archived or missing products", () => {
  const [first, second] = seedProducts;
  const page = { ...defaultPages[0], mode: "manual" as const, productIds: [second.id, "missing", first.id] };
  assert.deepEqual(pageProducts([first,second],page).map(p => p.id), [second.id,first.id]);
  assert.deepEqual(pageProducts([{...first,active:false},second],page).map(p => p.id), [second.id]);
});
test("manual selection can override badge-based collections and stay empty", () => {
  const page = { ...defaultPages.find(p => p.slug === "new")!, mode: "manual" as const, productIds: [seedProducts[0].id] };
  assert.equal(pageProducts([{...seedProducts[0],badge:""}],page).length,1);
  assert.deepEqual(pageProducts(seedProducts,{...page,productIds:[]}),[]);
});
test("settings reject unsafe links, reserved or duplicate pages, and invalid counts", () => {
  for (const href of ["javascript:alert(1)", "//example.com", "/\\example.com"]) assert.equal(settingsSchema.safeParse({navigation:[{href,label:"Test",labelAr:"تجربة",visible:true}]}).success,false);
  assert.equal(settingsSchema.safeParse({pages:[{...defaultPages[0],slug:"admin"}]}).success,false);
  assert.equal(settingsSchema.safeParse({pages:[defaultPages[0],defaultPages[0]]}).success,false);
  for (const homeProductCount of [0,49,10.5]) assert.equal(settingsSchema.safeParse({homeProductCount}).success,false);
  assert.deepEqual(settingsSchema.parse({homeProductCount:24}),{homeProductCount:24});
});

test("catalog and detail lookups share canonical IDs, including legacy supplier links", async () => {
  const { default: mongoose } = await import("mongoose");
  const { ProductModel, SettingsModel } = await import("../src/lib/models");
  const { products, getProduct } = await import("../src/lib/db");
  const canonical = { ...seedProducts[0], id: "hsabate:123", externalSource: "hsabate", externalId: "123" };
  const doc = { _id: canonical.id, id: "123", externalSource: "hsabate", externalId: "123", storefront: canonical };
  const mocks = [
    test.mock.method(mongoose, "connect", async () => mongoose),
    test.mock.method(SettingsModel, "findById", () => ({ lean: async () => ({ _id: "initialized" }) })),
    test.mock.method(ProductModel, "find", () => ({ lean: async () => [doc] })),
    test.mock.method(ProductModel, "findById", (id: string) => ({ lean: async () => id === canonical.id ? doc : null })),
    test.mock.method(ProductModel, "findOne", (query: { externalId: string }) => ({ lean: async () => query.externalId === "123" ? doc : null })),
  ];
  const previous = process.env.MONGODB_URI;
  process.env.MONGODB_URI = "mongodb://unused/test";
  try {
    const [listed] = await products();
    assert.equal(listed.id, canonical.id);
    assert.deepEqual(await getProduct(listed.id), listed);
    assert.deepEqual(await getProduct("123"), listed);
    assert.equal(await getProduct("does-not-exist"), undefined);
  } finally {
    mocks.forEach(mock => mock.mock.restore());
    if (previous === undefined) delete process.env.MONGODB_URI; else process.env.MONGODB_URI = previous;
  }
});
