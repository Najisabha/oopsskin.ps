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

## Products and future sync

The old `.env` referenced `https://oopsskin.ps/api`; the products endpoint returned 404 during inspection. Per the requested approach, the new store has **no dependency on that service** and does not perform external sync yet.

`src/lib/types.ts` defines the product model: stable local ID, bilingual names/descriptions, ILS price, optional original price, category, images, stock, visibility, collection badge, creation date and nullable `externalId`, `externalSource`, `syncedAt`. There is a unique index on external source + ID. Validation lives in `src/lib/validation.ts`.

When the supplier API is provided, add a server-side adapter to validate/map products and upsert by external source + ID, preserving local IDs and updating `syncedAt`. Decide ownership of local edits, stock and prices before syncing. Supplier credentials must remain server-side.

**The seed catalog is demo data**, adapted from the old seeder and homepage, plus an illustrative Habibti kit. Local images reuse the original site's Unsplash photography; they are not exact supplier product images. Replace/archive sample products before taking real orders. Admin image fields accept HTTPS URLs or existing `/images/…` paths. Image uploading is not configured.

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
| `/api/admin/products[/:id]` | POST, PATCH, DELETE | Create/edit/archive |
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
