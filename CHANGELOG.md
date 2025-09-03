# Changelog

All notable changes to this project will be documented in this file.

## [0.2.1] - 2025-09-03

- Rebrand product to "Launchfolio SaaS" (README title and language)
- Strengthen README overview with value-focused highlights
- Canonical docs now at repo root (`README.md`, `CHANGELOG.md`); backend duplicates slated for removal
- Document frontend plan: Vue 3.5.18 + Nuxt 4.1.0 (SSR/SSG) on Vercel/Netlify with SSG rebuilds on publish
- No functional code changes

## [0.2.0] - 2025-09-03

- Remove Portfolio module (model, Filament resource, migrations, stored images)
- Add migration to drop `portfolio_items` table
- Fix Filament v4 Schemas namespaces for `Section`/`Grid` and utilities `Get`/`Set`
- Implement slug auto-generation and uniqueness for Projects
- Documentation overhaul: README updated with SaaS plan, Architecture Option B, API outline, roadmap, Windows storage notes

## [0.1.0] - 2025-08-25

- Initialize Laravel 12 app in `backend/`.
- Install Filament v4 and set up admin panel provider (`app/Providers/Filament/AdminPanelProvider.php`) with path `/admin`.
- Create first admin user via `php artisan make:filament-user`.
- Add project-specific README with TALL stack notes and local dev steps.

## [Unreleased]

- Multi-tenant SaaS: tenant accounts, roles/permissions, onboarding, billing (Stripe)
- Page builder (Elementor-style) for Vue frontend: blocks, versioning, publish pipeline
- Public API: profiles, experiences, projects, certifications with caching and rate limits
- CI/CD via GitHub Actions for backend and frontend
- S3 storage option, CDN, image optimization
