import { Schema, model, models, type InferSchemaType } from "mongoose";

const ProductSchema = new Schema({
  _id: { type: String, required: true },
  id: { type: String },
  slug: { type: String, default: null },
  class_id: { type: Schema.Types.Mixed },
  barcode: { type: Schema.Types.Mixed },
  item_img: { type: Schema.Types.Mixed },
  item_pdf: { type: Schema.Types.Mixed },
  product_prices: { type: Schema.Types.Mixed },
  unit: { type: Schema.Types.Mixed },
  tax_class: { type: Schema.Types.Mixed },
  company_id: { type: Schema.Types.Mixed },
  trade_id: { type: Schema.Types.Mixed },
  style_id: { type: Schema.Types.Mixed },
  model_id: { type: Schema.Types.Mixed },
  color_id: { type: Schema.Types.Mixed },
  note: { type: Schema.Types.Mixed },
  bonus_group: { type: Schema.Types.Mixed },
  name_e: { type: Schema.Types.Mixed },
  other_codes: { type: Schema.Types.Mixed },
  model_no: { type: Schema.Types.Mixed },
  cost: { type: Schema.Types.Mixed },
  amount: { type: Schema.Types.Mixed },
  active_units: { type: Schema.Types.Mixed },
  measure: { type: Schema.Types.Mixed },
  storefront: { type: Schema.Types.Mixed },
  reservedStock: { type: Number, default: 0 },
  name: { type: String, required: true },
  nameAr: { type: String, required: true },
  description: { type: String, required: true },
  descriptionAr: { type: String, required: true },
  price: { type: Schema.Types.Mixed, required: true },
  compareAtPrice: { type: Number, default: null },
  category: { type: String, required: true },
  images: { type: [String], required: true },
  stock: { type: Number, required: true },
  badge: { type: String, enum: ["", "new", "best-seller"], default: "" },
  active: { type: Boolean, default: true },
  externalId: { type: String, default: null },
  externalSource: { type: String, default: null },
  syncedAt: { type: String, default: null },
  createdAt: { type: String, required: true },
}, { versionKey: false, strict: false, id: false });
ProductSchema.index(
  { externalSource: 1, externalId: 1 },
  { unique: true, partialFilterExpression: { externalId: { $type: "string" } } }
);
// Slug is the public URL segment; supplier products carry it on the storefront view.
ProductSchema.index({ "storefront.slug": 1 }, { sparse: true });
ProductSchema.index({ slug: 1 }, { sparse: true });

const UserSchema = new Schema({
  _id: { type: String, required: true },
  name: { type: String, required: true },
  email: { type: String, required: true, unique: true },
  passwordHash: { type: String, required: true },
  phone: { type: String, default: "" },
  address: { type: String, default: "" },
  city: { type: String, default: "" },
  role: { type: String, enum: ["customer", "admin"], default: "customer" },
}, { versionKey: false });

const SessionSchema = new Schema({
  _id: { type: String, required: true }, // token hash
  userId: { type: String, required: true },
  expiresAt: { type: Number, required: true },
}, { versionKey: false });
SessionSchema.index({ expiresAt: 1 });

const CartSchema = new Schema({
  _id: { type: String, required: true }, // owner
  items: { type: [{ productId: String, quantity: Number, _id: false }], default: [] },
  voucherCode: { type: String, default: "" },
}, { versionKey: false });

const OrderSchema = new Schema({
  _id: { type: String, required: true },
  userId: { type: String, default: null },
  requestKey: { type: String, required: true, unique: true },
  owner: { type: String, required: true },
  name: { type: String, required: true },
  email: { type: String, required: true },
  phone: { type: String, required: true },
  address: { type: String, required: true },
  city: { type: String, required: true },
  notes: { type: String, default: "" },
  items: {
    type: [{ productId: String, name: String, price: Number, quantity: Number, _id: false }],
    required: true,
  },
  subtotal: { type: Number, required: true },
  discount: { type: Number, required: true },
  shipping: { type: Number, required: true },
  total: { type: Number, required: true },
  voucherCode: { type: String, default: "" },
  status: {
    type: String,
    enum: ["pending", "confirmed", "processing", "shipped", "delivered", "cancelled"],
    default: "pending",
  },
  createdAt: { type: String, required: true },
  paymentMethod: { type: String, enum: ["cash-on-delivery"], default: "cash-on-delivery" },
}, { versionKey: false });
OrderSchema.index({ userId: 1, createdAt: -1 });

const VoucherSchema = new Schema({
  _id: { type: String, required: true }, // code
  percent: { type: Number, required: true },
  minimum: { type: Number, required: true },
  maxUses: { type: Number, required: true },
  used: { type: Number, default: 0 },
  active: { type: Boolean, default: true },
  expiresAt: { type: String, default: null },
}, { versionKey: false });

const SettingsSchema = new Schema({
  _id: { type: String, required: true },
  shippingFee: { type: Number, required: true },
  freeShippingThreshold: { type: Number, required: true },
  contactEmail: { type: String, default: "" },
  initialized: { type: Boolean, default: undefined },
}, { versionKey: false, strict: false });

const LoginAttemptSchema = new Schema({
  _id: { type: String, required: true }, // key (digest of email)
  count: { type: Number, required: true },
  resetAt: { type: Number, required: true },
}, { versionKey: false });

export type ProductDoc = InferSchemaType<typeof ProductSchema>;
export type UserDoc = InferSchemaType<typeof UserSchema>;
export type OrderDoc = InferSchemaType<typeof OrderSchema>;
export type VoucherDoc = InferSchemaType<typeof VoucherSchema>;

export const ProductModel = models.Product || model("Product", ProductSchema);
export const UserModel = models.User || model("User", UserSchema);
export const SessionModel = models.Session || model("Session", SessionSchema);
export const CartModel = models.Cart || model("Cart", CartSchema);
export const OrderModel = models.Order || model("Order", OrderSchema);
export const VoucherModel = models.Voucher || model("Voucher", VoucherSchema);
export const SettingsModel = models.Settings || model("Settings", SettingsSchema);
export const LoginAttemptModel = models.LoginAttempt || model("LoginAttempt", LoginAttemptSchema);

const SyncStateSchema = new Schema({ _id: String, lockedUntil: Date, runId: String, status: String, startedAt: String, finishedAt: String, error: String, lastSuccess: Schema.Types.Mixed, history: [Schema.Types.Mixed] }, { versionKey: false });
export const SyncStateModel = models.SyncState || model("SyncState", SyncStateSchema);
