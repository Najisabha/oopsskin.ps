import { test, expect } from "@playwright/test";
import mongoose from "mongoose";
import { scryptSync } from "node:crypto";
async function testDb() {
  if (mongoose.connection.readyState === 0) await mongoose.connect(process.env.TEST_MONGODB_URI!, { bufferCommands: false });
  return mongoose.connection;
}
const checkout = (requestKey = crypto.randomUUID()) => ({ name: "Test Customer", email: "guest@example.com", phone: "+970599123456", city: "Tulkarm", address: "Test Street 10", notes: "Automated test", requestKey });

test("guest checkout uses server totals, persists, and deduplicates retries", async ({ request }) => {
  await request.get("/api/cart");
  expect((await request.patch("/api/cart",{data:{productId:"lipstick-red",quantity:999}})).status()).toBe(400);
  const {cart} = await (await request.patch("/api/cart",{data:{productId:"lipstick-red",quantity:2}})).json();
  expect(cart.subtotal).toBe(100);
  expect(cart.total).toBe(120);
  const payload = {...checkout(),total:1,price:1,discount:9999};
  const response = await request.post("/api/orders",{data:payload});
  expect(response.status()).toBe(201);
  const {order} = await response.json();
  expect(order.total).toBe(120);
  expect(order.userId).toBeNull();
  expect((await (await request.get("/api/cart")).json()).cart.items).toHaveLength(0);
  expect((await (await request.post("/api/orders",{data:payload})).json()).order.id).toBe(order.id);
  expect((await (await request.get("/api/products/lipstick-red")).json()).product.stock).toBe(8);
  const connection = await testDb();
  expect(await connection.collection("orders").findOne({ _id: order.id })).toBeTruthy();
});

test("account auth merges guest cart and isolates order history", async ({ request, playwright }) => {
  await request.get("/api/cart");
  await request.patch("/api/cart",{data:{productId:"face-mask",quantity:1}});
  const response = await request.post("/api/auth/register",{data:{name:"Registered Tester",email:"registered@example.com",password:"StrongPassword123",role:"admin"}});
  expect(response.status()).toBe(201);
  expect((await response.json()).user.role).toBe("customer");
  expect((await (await request.get("/api/cart")).json()).cart.items).toHaveLength(1);
  expect((await request.get("/api/admin/overview")).status()).toBe(403);
  expect((await request.post("/api/admin/products",{data:{}})).status()).toBe(403);
  expect((await request.post("/api/orders",{data:checkout()})).status()).toBe(201);
  expect((await (await request.get("/api/orders")).json()).orders).toHaveLength(1);
  const other = await playwright.request.newContext({baseURL:"http://localhost:3107"});
  expect((await other.get("/api/orders")).status()).toBe(401);
  expect((await other.get("/api/admin/overview")).status()).toBe(401);
  expect((await other.get("/api/admin/hsabate")).status()).toBe(401);
  expect((await other.post("/api/admin/hsabate/sync")).status()).toBe(401);
  expect((await request.post("/api/admin/hsabate/debug")).status()).toBe(403);
  await other.dispose();
  await request.post("/api/auth/logout",{data:{}});
  expect((await (await request.get("/api/auth/current")).json()).user).toBeNull();
  expect((await request.get("/api/orders")).status()).toBe(401);
});

test("admin changes affect checkout and cancelled stock is restored once", async ({ request }) => {
  const connection = await testDb();
  const salt = "12345678901234567890123456789012";
  const hash = `${salt}:${scryptSync("AdminPassword123",salt,64).toString("hex")}`;
  const admin = {_id:"test-admin",name:"Test Admin",email:"admin@example.com",phone:"",address:"",city:"",role:"admin",passwordHash:hash};
  await connection.collection<typeof admin>("users").updateOne({ _id: admin._id }, { $setOnInsert: admin }, { upsert: true });
  expect((await request.post("/api/auth/login",{data:{email:admin.email,password:"AdminPassword123"}})).status()).toBe(200);
  const product = {name:"Test Serum",nameAr:"سيروم تجريبي",description:"Testing product",descriptionAr:"منتج تجريبي",price:70,compareAtPrice:80,category:"Skincare",images:["/images/serum.jpg"],stock:2,badge:"new",active:true,externalId:"test-123",externalSource:"test"};
  const created = await request.post("/api/admin/products",{data:product});
  expect(created.status()).toBe(409);
  const id = "api-owned-test";
  await connection.collection<{ _id: string } & typeof product & { createdAt: string }>("products").insertOne({ _id: id, ...product, createdAt: new Date().toISOString() });
  expect((await request.post("/api/admin/products",{data:product})).status()).toBe(409);
  expect((await request.post("/api/admin/vouchers",{data:{code:"TEST10",percent:10,minimum:50,maxUses:1,active:true,expiresAt:null}})).status()).toBe(200);
  await request.patch("/api/cart",{data:{productId:id,quantity:1}});
  expect((await request.post("/api/cart/voucher",{data:{code:"TEST10"}})).status()).toBe(200);
  const {order} = await (await request.post("/api/orders",{data:checkout()})).json();
  expect(order.total).toBe(83);
  expect(order.discount).toBe(7);
  expect((await request.patch(`/api/admin/orders/${order.id}`,{data:{status:"cancelled"}})).status()).toBe(200);
  expect((await request.patch(`/api/admin/orders/${order.id}`,{data:{status:"cancelled"}})).status()).toBe(200);
  expect((await (await request.get(`/api/products/${id}`)).json()).product.stock).toBe(2);
  expect((await request.patch(`/api/admin/orders/${order.id}`,{data:{status:"confirmed"}})).status()).toBe(400);
  await request.patch("/api/cart",{data:{productId:id,quantity:1}});
  expect((await request.post("/api/cart/voucher",{data:{code:"TEST10"}})).status()).toBe(400);
  expect((await request.patch(`/api/admin/products/${id}`, {data:product})).status()).toBe(409);
  expect((await request.delete(`/api/admin/products/${id}`)).status()).toBe(409);
  await connection.collection("products").updateOne({ externalId: "test-123" }, { $set: { active: false } });
  expect((await request.get(`/api/products/${id}`)).status()).toBe(404);
});

test("rejects cross-origin writes and invalid checkout data", async ({ request }) => {
  expect((await request.patch("/api/cart",{headers:{Origin:"https://untrusted.example"},data:{productId:"face-mask",quantity:1}})).status()).toBe(403);
  expect((await request.post("/api/orders",{data:{...checkout(),phone:"abc"}})).status()).toBe(400);
});

test("desktop favorites, language switch and search work without ratings", async ({ page }) => {
  const errors: string[] = [];
  page.on("pageerror",e=>errors.push(e.message));
  await page.goto("/");
  await expect(page.locator("html")).toHaveAttribute("dir","rtl");
  await expect(page.getByRole("heading",{level:1})).toContainText("شوية عناية");
  await page.getByRole("button",{name:"Switch to English"}).click();
  await expect(page.locator("html")).toHaveAttribute("lang","en");
  await page.goto("/product/hydrating-face-serum");
  await page.getByRole("button",{name:"Like",exact:true}).click();
  await page.getByRole("link",{name:"Favorites",exact:true}).click();
  await expect(page.getByRole("link",{name:"Hydrating Face Serum",exact:true}).first()).toBeVisible();
  await page.reload();
  await expect(page.getByRole("link",{name:"Hydrating Face Serum",exact:true}).first()).toBeVisible();
  await page.getByRole("button",{name:"Search products",exact:true}).click();
  await page.getByRole("textbox",{name:"Search products",exact:true}).fill("Lipstick Red");
  await page.getByRole("button",{name:"Search",exact:true}).click();
  await expect(page.getByRole("link",{name:"Lipstick Red",exact:true}).first()).toBeVisible();
  expect(await page.getByText(/\breviews?\b|\bratings?\b|التقييمات/).count()).toBe(0);
  expect(errors).toEqual([]);
});

test("mobile guest purchase works without horizontal overflow", async ({ page }) => {
  await page.setViewportSize({width:390,height:844});
  await page.goto("/");
  expect(await page.evaluate(()=>document.documentElement.scrollWidth<=window.innerWidth)).toBe(true);
  await page.getByRole("button",{name:"فتح القائمة"}).click();
  await expect(page.getByRole("dialog")).toBeVisible();
  await page.getByRole("dialog").getByRole("link",{name:"العناية بالبشرة",exact:true}).click();
  await expect(page).toHaveURL(/skincare/);
  await page.goto("/product/night-recovery-mask");
  await expect(page.getByRole("button",{name:"إتمام الطلب",exact:true})).toBeEnabled();
  await page.getByRole("button",{name:"إتمام الطلب",exact:true}).click();
  await expect(page).toHaveURL(/checkout/);
  await expect(page.getByRole("link",{name:"هل تريد إنشاء الحساب؟",exact:true})).toBeVisible();
  await page.getByLabel("الاسم الكامل",{exact:false}).fill("مستخدم تجريبي");
  await page.getByLabel("البريد الإلكتروني",{exact:false}).fill("mobile@example.com");
  await page.getByLabel("رقم الهاتف",{exact:false}).fill("0599123456");
  await page.getByLabel("المدينة",{exact:false}).fill("طولكرم");
  await page.getByLabel("العنوان بالتفصيل",{exact:false}).fill("شارع الاختبار 10");
  expect(await page.evaluate(()=>document.documentElement.scrollWidth<=window.innerWidth)).toBe(true);
  await page.getByRole("button",{name:/تأكيد الطلب/}).click();
  await expect(page.getByRole("heading",{name:"شكراً يا حلوة."})).toBeVisible();
  await expect(page.getByText(/OOPS-/)).toBeVisible();
});


test("admin API dashboard renders diagnostics and manual sync feedback", async ({ page }) => {
  const errors: string[] = [];
  page.on("pageerror", error => errors.push(error.message));
  const connection = await testDb();
  const salt = "12345678901234567890123456789012";
  const admin = { _id: "dashboard-admin", name: "Dashboard Admin", email: "dashboard@example.com", role: "admin", passwordHash: `${salt}:${scryptSync("AdminPassword123", salt, 64).toString("hex")}` };
  await connection.collection<typeof admin>("users").updateOne({ _id: admin._id }, { $set: admin }, { upsert: true });
  expect((await page.request.post("/api/auth/login", { data: { email: admin.email, password: "AdminPassword123" } })).status()).toBe(200);
  const state = await (await page.request.get("/api/admin/hsabate")).json();
  expect(state.endpoint).toBe("https://s.hesabate.com/store_api.php");
  expect(JSON.stringify(state)).not.toContain("HSABATE_PASSWORD");
  await page.goto("/admin/hsabate");
  await page.getByRole("button", { name: "Switch to English" }).click();
  await expect(page.getByRole("heading", { name: "Hsabate product sync" })).toBeVisible();
  await page.route("**/api/admin/hsabate/debug", route => route.fulfill({ json: { total: 2645, ecommerce: 705, fields: ["id", "name", "price"] } }));
  await page.getByRole("button", { name: "Test API", exact: true }).click();
  await expect(page.locator("pre")).toContainText("2645");
  await page.route("**/api/admin/hsabate/sync", route => route.fulfill({ json: { received: 2645, active: 705, inserted: 2645, updated: 0, archived: 10 } }));
  await page.getByRole("button", { name: "Sync products now" }).click();
  await expect(page.getByRole("status").filter({ hasText: "Sync completed" })).toBeVisible();
  await page.setViewportSize({ width: 390, height: 844 });
  expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBe(true);
  expect(errors).toEqual([]);
});
test.afterAll(async () => {
  if (mongoose.connection.readyState) {
    if (!mongoose.connection.name.startsWith("oopsskin_test_")) throw new Error("Refusing to clean non-test database");
    try { for (const collection of await mongoose.connection.db!.collections()) await collection.deleteMany({}); } finally { await mongoose.disconnect(); }
  }
});
