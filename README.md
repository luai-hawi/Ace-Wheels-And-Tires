# Ace Wheels and Tires

Laravel + PostgreSQL rebuild of the Ace Wheels and Tires website, with a Filament-powered
admin panel for managing every page's content (sections, cards/images, animations) without
touching code.

## Requirements

- PHP 8.2+, Composer
- Node.js + npm
- MySQL locally (this repo's `.env` is set up for MySQL for local development) / PostgreSQL in production —
  the app works with either, only the `DB_*` values in `.env` need to change.

## Setup

1. Install dependencies:
    ```
    composer install
    npm install
    ```
2. Update the `DB_USERNAME` / `DB_PASSWORD` in `.env` to match your local MySQL server
   (defaults to `root` with no password), and make sure a database named `ace_wheels_tires`
   exists — create it with your usual MySQL client/GUI if it doesn't.
3. Run migrations and seed the starter content (all pages, sections, settings and a demo admin user):
    ```
    php artisan migrate --seed
    php artisan storage:link
    ```
4. Build the front-end assets:
    ```
    npm run build      # production build
    npm run dev        # or: watch mode while developing
    ```
5. Serve the app (via Herd, `php artisan serve`, or your usual local server).

On your production server, switch `.env` to `DB_CONNECTION=pgsql` with your PostgreSQL
credentials — no code changes are needed, the migrations and queries are database-agnostic.

## Admin panel

Visit `/admin`. The seeder creates a starter admin account:

- Email: `admin@acewheelsandtires.com`
- Password: `password`

**Change this password immediately after first login.** From the admin panel you can:

- Manage **Pages & Services** (every page, service, service area and blog post) and their
  **Sections** — each section can hold text, images/cards, buttons and a scroll-in animation.
- Manage **Site Settings** (phone, address, hours, social links, financing links, and the
  homepage promo popup — image, text and button, toggled on/off).
- View **Contact leads** submitted through the site's Contact/Request Service form.

## Content still needed

The homepage was fully rebuilt from the original site. About Us, Contact, FAQs, Financing,
Blog, the 9 service pages and the 6 service-area pages are seeded with placeholder starter
content — replace them with real copy either by editing the seeder or directly in `/admin`.

Images are placeholders (generated via `App\Support\Placeholder`) until real photos are
uploaded through the admin panel's file upload fields.
