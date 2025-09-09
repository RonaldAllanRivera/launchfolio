# Changelog

All notable changes to this project will be documented in this file.

## [0.2.5] - 2025-09-09

- Site Settings: introduce SEO fields replacing branding
  - New fields: `seo_title`, `seo_description`, `seo_keywords`
  - Migration: `2025_09_09_093600_add_seo_fields_to_site_settings_table.php`
- Site Settings: move publishing controls here
  - New fields: `handle` (site-wide), `is_public` (site-wide)
  - Migration: `2025_09_09_101300_move_handle_is_public_to_site_settings.php`
  - Profiles form/table/model cleaned of `handle` and `is_public`
- Site Settings: slider images for homepage hero/slider
  - Field: `slider_images` (JSON), multi-upload, reorderable, preview smaller, limited to 5
  - Migration: `2025_09_08_203500_add_slider_images_to_site_settings_table.php`
- Profiles: remove banner image
  - UI removed, model fillable updated
  - Migration: `2025_09_09_103500_drop_banner_path_from_profiles_table.php`
- Cleanup: remove legacy branding columns
  - Dropped `site_name`, `tagline` via `2025_09_09_095900_drop_site_name_tagline_from_site_settings.php`
- Fix: ensure profile photos render in list by setting ImageColumn disk('public')

## [0.2.4] - 2025-09-08

- Site Settings: remove duplicated profile fields from UI and model (`email`, `phone`, `address`, `about`)
- Migration: `2025_09_08_202900_update_site_settings_drop_contact_add_domains.php` drops duplicate columns; adds `primary_domain`, `custom_domain`
- Site Settings UI: add "Domains" section with `primary_domain` and `custom_domain`
- Tables: update columns to display domains (remove email/phone)

## [0.2.3] - 2025-09-08

- Profiles: Add Middle Name (stored as `middle_initial`) and `state_province` fields
- Migration: `2025_09_07_193600_add_middle_initial_and_state_province_to_profiles_table.php`
- Profile model: add fields to `$fillable`; format full name as "First M. Last" when middle name present
- Countries/States: implement hybrid loader in `config/countries.php` that prefers JSON datasets and falls back to curated arrays
- Add `countries:refresh` artisan command to generate datasets (uses `symfony/intl` + `commerceguys/addressing` when installed)
- Scheduler: monthly refresh registered in `routes/console.php`
- Filament Profiles form: country required with validation, dynamic state/province loading + validation
- Filament Profiles form UI: wider layout, First/Middle/Last on separate rows; full-width social links; labels made explicit
- Fix: Filament v4 utilities namespace for `Get`/`Set` to resolve closure type mismatch
- Fix: Select option label type error for Country select
- Docs: README updated with Windows Composer SSL fix commands and dataset refresh steps

## [0.2.2] - 2025-09-07

- De-duplicate social links: `Profiles` is now the single source of truth for Website, LinkedIn, GitHub, Twitter
- Remove "Social Links" section from Site Settings form UI
- Add migration `2025_09_07_191900_drop_social_links_from_site_settings_table.php` to drop `facebook_url`, `twitter_url`, `linkedin_url`, `github_url` from `site_settings`
- Update `App\Models\SiteSetting` to remove dropped fields from `$fillable`

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
