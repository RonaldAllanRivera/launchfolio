# Launchfolio SaaS

Launchfolio is a SaaS platform to publish a polished professional profile and projects in minutes. Create LinkedIn‑style profiles and visually compose pages with a modern block builder, while an API‑first backend powers fast, reliable delivery.

Built for speed and maintainability: Laravel 12 + Filament v4 for the admin, and a Vue 3 frontend for public pages.

### Highlights

- API‑first content model (profiles, experiences, projects, certifications)
- Visual page builder (Elementor‑style) for non‑technical users
- Admin UX on Filament v4 (TALL), immediate productivity out of the box
- Deployment‑friendly architecture (Vue on Vercel/Netlify, Laravel API on VPS)
- Multi‑tenant ready roadmap (roles, billing, onboarding)

### What you get

- Fast publishing workflow: create profile, add projects, go live
- Professional defaults: clean structure, SEO basics, sensible content types
- Extensible foundation: API‑first backend + Vue frontend
- Deployment‑ready: CDN‑friendly static hosting for frontend, cached API responses

## Monorepo layout

- `backend/` — Laravel + Filament admin API
- `base/` — legacy/static assets (CSS/JS/images) to reuse in frontend

## Architecture & Deployment

- Architecture Option B (chosen):
  - Vue 3.5.18 + Nuxt 4.1.0 frontend on Vercel/Netlify (SSR/SSG)
  - Laravel + Filament backend on a VPS at `api.<domain>`
  - Focus on fast loading; Octane not required initially
  - Prefer SSG via Nuxt and trigger rebuilds on content publish for speed & SEO
- Storage: public disk (`storage/app/public`) with `php artisan storage:link` locally; S3 later
- DB: MySQL or SQLite per environment; migrations are the source of truth
- CI/CD: planned GitHub Actions for test, build, deploy (frontend + backend)

Admin (local): http://127.0.0.1:8000/admin

## Features

- Profiles: avatar, socials, bio
- Experiences: roles, companies, locations, start/end, ordering
- Projects: title, slug, image uploads, category, external URL, publish state, ordering
- Certifications: PDF/image uploads, issuer, date, publish state
- Site settings: branding, contact links, SEO basics
- Admin: Filament v4 with modern UX
- Public API: read-only endpoints for frontend (see API)

## API (planned)

- GET `/api/public/profile/{slug}`
- GET `/api/public/projects` and `/api/public/projects/{slug}`
- GET `/api/public/experiences`
- GET `/api/public/certifications`

Notes:
- Responses cached; pagination for collections
- Public rate limiting

## Local development (backend)

From `backend/`:

1) Copy env and configure DB
```
cp .env.example .env
```
Set DB creds; set `APP_URL=http://127.0.0.1:8000`

2) Install deps
```
composer install
```

3) Generate key
```
php artisan key:generate
```

4) Migrate
```
php artisan migrate
```

5) Storage link (Windows: recreate if needed)
```
php artisan storage:link
```

6) Serve
```
php artisan serve
```
Open http://127.0.0.1:8000

## Roadmap

- MVP
  - CRUD for Profiles, Experiences, Projects, Certifications in Filament
  - Public read-only API consumed by Vue frontend
  - Public disk uploads + docs for storage link
- Multi-tenant SaaS
  - Tenant-aware data scopes
  - Roles & permissions
  - Stripe subscriptions + onboarding
- Page Builder (Elementor-style)
  - Nuxt 4 drag-and-drop blocks (hero, features, testimonials, project lists)
  - Versioning & publish flow to Vercel/Netlify
- DevEx & Ops
  - GitHub Actions CI/CD
  - S3 + CDN, image optimization

## Windows notes (storage link)

If images don’t render in admin previews on Windows:

1) Delete `backend/public/storage` if it’s a normal folder
2) Run `php artisan storage:link`

## License

MIT
