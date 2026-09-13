# Oops Skin

Next.js App Router + TypeScript + Tailwind CSS 4 + official shadcn/ui components, recreated from the old Oopsskin project. Arabic is the default; English and RTL/LTR switching are included.

## Run

Requires Node.js **22.13+** (SQLite is provided by Node).

```bash
npm install
npm run dev
```

Open http://localhost:3000. The first request creates `data/store.sqlite` and the sample catalog. No separate Express/MySQL service is required.

```bash
npm run admin:create
```

Prompts for an admin email, name and hidden password. Sign in at `/login`, then visit `/admin`. No default password. For automation use `ADMIN_EMAIL`, `ADMIN_NAME`, and `ADMIN_PASSWORD`. Existing accounts are never silently promoted.

## Features

- Home, collections, search, category/stock/price filters, sorting and pagination.
- Product detail: add to bag, checkout now and like buttons. **No ratings or reviews.**
- Navbar favorites heart; favorites persist on the current browser, across tabs.
- Server-side guest/account carts, stock checks, vouchers and cash-on-delivery checkout.
- Guest purchase or account purchase, with “هل تريد إنشاء الحساب؟”.
- Registration, login, logout, profile and account order history. Guest order numbers appear after checkout; creating an account afterwards does not attach prior guest orders.
- Protected admin: products, stock, order statuses, customers, vouchers and delivery settings.
- Vector logo from the supplied PDF; exact supplied Arabic About Us text in the footer and `/about`.

## Theme

Edit `src/app/globals.css`. Semantic Tailwind classes reference these shared variables:

| Variable | Value | Use |
| --- | --- | --- |
| `--primary` | `#770D3D` | Logo burgundy: actions/headings |
| `--accent` | `#DB949D` | Logo dusty rose |
| `--muted-foreground` | `#635D60` | Logo gray |
| `--secondary` | `#F7E9E9` | Soft rose panels |
| `--background` | `#FFFDFB` | Warm background |
| `--font-body`, `--font-heading` | DM Sans Variable | English |
| `--font-arabic` | Noto Sans Arabic Variable | Arabic |

Fonts are bundled locally. shadcn primitives are in `src/components/ui`, shared storefront components in `src/components/store`, and admin UI in `src/components/admin`. `components.json` supports adding more shadcn components.

## Hsabate product sync

Set server-only `HSABATE_EMAIL` and `HSABATE_PASSWORD` in `.env.local`. Open **/admin/hsabate** for API diagnostics, sync history and the **Sync products now** button. Only administrators can access these endpoints. Sync is manual; no scheduler or supplier upload is enabled.

`POST https://s.hesabate.com/store_api.php` supplies the catalog. Each run authenticates afresh, downloads all products (`all=1`, `view_items_by=1`), the e-commerce subset (`all=0`), and categories. All supplier fields are stored at the product document's top level with their exact API names and JSON types, including `id`, `price`, `amount`, `product_prices`, `measure` and `cost`. MongoDB adds `_id`, source/sync metadata, `reservedStock`, and a separate `storefront` projection. For example, API `price: "85"` stays a string in MongoDB; the storefront exposes numeric `price: 85`. Only the projection is sent to storefront clients, so supplier costs remain private.

Supplier IDs have stable local identities (`hsabate:<id>`); existing source-linked IDs are preserved. Hsabate owns product edits and visibility; local admin product writes return 409. API-relative image paths resolve against the production host. Missing images use the placeholder. API categories map known store collections, with unknown categories retained. The API does not provide the store's badge/discount fields, so these stay empty/null.

A successful sync archives the previous local catalog and products removed from the supplier catalog; only the e-commerce subset is visible in the shop. Archival preserves order references. Empty, malformed or duplicate-ID downloads stop the sync. Catalog writes and success history commit in one MongoDB transaction (Atlas/replica set required); a database lock prevents overlapping syncs. The last ten successful runs and latest error are available in the dashboard.

Local checkout reservations are tracked separately from API `amount`, subtracted from shop availability during sync, and released on cancellation. Orders are not uploaded to Hsabate, so these reservations are not automatically reconciled against orders entered manually in Hsabate.

CLI: `npm run sync:products` creates a private backup under ignored `data/backups/` and runs the same sync function. `npm run sync:products -- --debug` tests the API without changing products. `npm run test:sync` runs offline validation tests. `node --import tsx --test tests/hsabate.integration.ts` uses mocked supplier responses and a temporary isolated database on the configured MongoDB server, then clears its test records (the restricted Atlas account cannot drop databases).

## Backend

API routes: `src/app/api/[...path]/route.ts`. Persistence: `src/lib/db.ts`. Uses validated inputs, parameterized SQL, scrypt passwords, expiring HttpOnly sessions with hashed tokens, origin checks and admin authorization.

| Endpoint | Methods | Purpose |
| --- | --- | --- |
| `/api/products[/:id]` | GET | Catalog |
| `/api/settings` | GET | Delivery configuration |
| `/api/auth/register`, `/api/auth/login`, `/api/auth/logout` | POST | Sessions |
| `/api/auth/current` | GET | Current account |
| `/api/profile` | PATCH | Own profile |
| `/api/cart` | GET, PATCH, DELETE | Cart; PATCH sets absolute quantity |
| `/api/cart/voucher` | POST | Apply/remove voucher |
| `/api/orders` | POST, GET | Guest/account checkout; GET returns own orders |
| `/api/admin/overview` | GET | Protected store data |
| `/api/admin/products[/:id]` | POST, PATCH, DELETE | Disabled: products are managed in Hsabate |
| `/api/admin/hsabate` | GET | Configuration and sync status |
| `/api/admin/hsabate/debug` | POST | Read-only supplier diagnostics |
| `/api/admin/hsabate/sync` | POST | Manual product sync |
| `/api/admin/orders/:id` | PATCH | Allowed status transitions |
| `/api/admin/vouchers[/:code]` | POST, DELETE | Create/update/disable |
| `/api/admin/settings` | PATCH | Delivery configuration/contact email |

Checkout computes prices, discounts and delivery on the server. Order creation, voucher consumption, stock decrement and cart clearing are one SQLite transaction. A request UUID prevents duplicate orders on retry. Order items retain name/price snapshots. Cancellation restores stock once. Default sample delivery: **₪20**, free from **₪200**, editable in admin; these are configurable defaults, not a confirmed business policy.

## Checks

```bash
npm run lint
npm run typecheck
npm run test:unit
npm run build
npx playwright install chromium
npm test
```

Playwright uses an isolated temporary SQLite database and a production server on port 3107. Set `PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH` to an already installed Chromium binary if needed. Tests cover guest checkout, price/stock validation, idempotency, account isolation, admin authorization, favorites, bilingual navigation and mobile checkout.

Unit tests can run without a server or browser. Webpack is selected for dev/build because this workspace blocks Turbopack’s internal process port.

## Deploy

```bash
npm run build
npm start
```

Use a **single Node server/container with persistent writable storage**. Set `DATABASE_PATH` to a persistent SQLite file, preserving its WAL/SHM files. This is not a static export. Ephemeral or multi-instance serverless hosting requires a shared database adapter first. Set `APP_ORIGIN` if a reverse proxy changes the public origin visible to Next.js. Production uses secure session cookies and requires HTTPS (browsers allow localhost exceptions).

Password reset, payment gateway, carrier integration, customer notifications and supplier sync are not configured. This application does not send external emails or supplier orders.

## References

[Next.js installation](https://nextjs.org/docs/app/getting-started/installation), [shadcn/ui setup](https://ui.shadcn.com/docs/installation/next), [theme variables](https://ui.shadcn.com/docs/theming), [Node SQLite](https://nodejs.org/api/sqlite.html).
