# Restaurant Management System

A Petpooja-style restaurant management platform built on **Laravel 10** with the GetSkills admin theme as the UI shell. Restaurant features will be developed incrementally under `/admin` and `/pos`.

## Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (with WSL2 backend on Windows)
- Git

All PHP, Composer, Node, and Artisan commands run inside Laravel Sail containers — no local PHP installation required.

## First-Time Setup

```bash
# Clone the repository, then:
cp .env.example .env

# Start Docker containers (first run downloads images; may take several minutes)
./vendor/bin/sail up -d

# Generate application key (skip if already set in .env)
./vendor/bin/sail artisan key:generate

# Run database migrations
./vendor/bin/sail artisan migrate

# Optional: compile frontend assets with Vite
./vendor/bin/sail npm run dev
```

Open the app at **http://localhost:8080**. The GetSkills theme demo dashboard is served at `/`.

> If port 8080 is in use, change `APP_PORT` in `.env` and run `docker compose up -d` again.

## Service URLs

| Service   | URL                        |
|-----------|----------------------------|
| App       | http://localhost:8080      |
| Mailpit   | http://localhost:8025      |
| MySQL     | localhost:3307             |
| Redis     | localhost:6379             |

## Common Sail Commands

```bash
./vendor/bin/sail up -d          # Start containers in background
./vendor/bin/sail down           # Stop containers
./vendor/bin/sail artisan ...    # Run Artisan commands
./vendor/bin/sail composer ...   # Run Composer commands
./vendor/bin/sail npm ...        # Run npm commands
./vendor/bin/sail test           # Run PHPUnit tests
./vendor/bin/sail shell          # Open a shell in the app container
```

On Windows you can also use `vendor\bin\sail` from PowerShell or Git Bash.

**Windows note:** Run Sail from **WSL2** (recommended) or use `docker compose` directly from Git Bash/PowerShell. The `./vendor/bin/sail` script does not support MINGW/Git Bash natively — use WSL or the `docker compose` commands below as an alternative:

```bash
docker compose up -d
docker compose exec app php artisan migrate
docker compose exec app php artisan test
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Back-office: menu, inventory, reports, settings
│   │   ├── Pos/            # POS: billing, tables, KOT
│   │   └── Api/V1/         # REST API for mobile & integrations
│   ├── Requests/           # Form request validation
│   └── Resources/          # API transformers
├── Services/               # Business logic layer
├── Repositories/
│   ├── Contracts/          # Repository interfaces
│   └── Eloquent/             # Eloquent implementations
├── Enums/                  # Status enums, payment methods, etc.
└── Support/                # Shared helpers

routes/
├── web.php                 # GetSkills theme demo routes (unchanged)
├── admin.php               # Restaurant admin routes  → /admin/*
├── pos.php                 # POS routes               → /pos/*
└── api.php                 # API routes               → /api/*

resources/views/
├── getskills/              # Theme demo views (reference UI)
├── layout/                 # Theme layouts
└── restaurant/             # Future restaurant-specific views
    ├── admin/
    ├── pos/
    └── components/

config/restaurant.php       # App-level restaurant settings (currency, timezone)
```

## Route Conventions

- **Theme demos** — existing URLs (`/`, `/courses`, `/ecom-*`, etc.) remain unchanged for UI reference.
- **Admin module** — new back-office features go under `/admin` (see `routes/admin.php`).
- **POS module** — in-restaurant operations go under `/pos` (see `routes/pos.php`).
- **API** — versioned endpoints will live under `/api/v1` (placeholder in `routes/api.php`).

## Environment Variables

Key variables in `.env`:

| Variable              | Default                  | Description              |
|-----------------------|--------------------------|--------------------------|
| `APP_NAME`            | Restaurant Management System | Application name     |
| `DB_DATABASE`         | restaurant_management    | MySQL database name      |
| `RESTAURANT_CURRENCY` | INR                      | Default currency         |
| `RESTAURANT_TIMEZONE` | Asia/Kolkata             | Restaurant timezone      |

Sail sets `DB_HOST=mysql`, `REDIS_HOST=redis`, and `MAIL_HOST=mailpit` automatically.

## Documentation

Product and API specifications for the Petpooja-style RMS:

| Document | Description |
|----------|-------------|
| [plans/prd-restaurant-management-system.md](plans/prd-restaurant-management-system.md) | Master PRD — vision, roles, data schemas, functional requirements, phased roadmap |
| [plans/menus-and-navigation.md](plans/menus-and-navigation.md) | Admin sidebar, POS navigation, routes, and role-based access matrix |
| [docs/api.md](docs/api.md) | Master API reference — all planned `/api/v1` endpoints by phase |

Per-endpoint Postman docs will be added under `docs/{feature}/` as APIs are implemented.

## License

MIT
