# CK Shared App Core

**CK Shared App Core** is a shared-hosting-friendly, modular web app foundation built on
CodeIgniter 4 + Bootstrap 5 + SQLite.

## Features

- Shared hosting friendly (no Node.js, Redis, or queue workers)
- Modular structure (add or remove modules cleanly)
- SQLite-first (MySQL optional)
- Multi-language support (DE, EN, TR)
- AI-friendly docs (CLAUDE.md and PROMPTS.md)
- Bootstrap 5 admin panel

## Quick Start

### Requirements

- PHP 8.1+ (intl extension)
- SQLite3 extension
- Composer
- Apache (mod_rewrite)

### Install

```bash
git clone https://github.com/YOUR_USERNAME/ck-shared-app-core.git
cd ck-shared-app-core

composer install
cp .env.example .env

php spark migrate --all
php spark db:seed AdminSeeder
php spark db:seed "App\\Modules\\Property\\Database\\Seeds\\PropertySeeder"

php spark serve
```

Open: `http://localhost:8080`

## Project Structure

```
ck-shared-app-core/
|-- app/
|   |-- Config/          # Framework config
|   |-- Controllers/     # MVC controllers
|   |-- Models/          # Database models
|   |-- Views/           # Templates
|   |-- Modules/         # Modular structure
|   |   |-- Property/    # Example module
|   |   `-- _Template/   # Module template
|   |-- Database/        # Migrations and seeds
|   |-- Filters/         # Middleware filters
|   `-- Language/        # Translations
|-- public/              # Web root
|-- writable/            # Writable files
|-- CLAUDE.md            # AI assistant guide
|-- PROMPTS.md           # Prompt templates
|-- DEPLOYMENT.md        # Deployment guide
`-- README.md            # Turkish README
```

## Usage

### Create a New Module

1. Copy `app/Modules/_Template/`
2. Rename files and classes
3. Register routes in `app/Config/Routes.php`
4. Run migrations

See: `app/Modules/_Template/README.md`

### AI-Assisted Development

- **CLAUDE.md** explains the project for AI assistants
- **PROMPTS.md** includes ready-to-use prompt templates

Example prompt:

```
Create a blog module.
Fields: title, content, author, published_at, is_featured
Use _Template as reference.
```

## Documentation

| File | Description |
|------|-------------|
| [CLAUDE.md](CLAUDE.md) | AI assistant guide (Turkish) |
| [CLAUDE.en.md](CLAUDE.en.md) | AI assistant guide (English) |
| [PROMPTS.md](PROMPTS.md) | Prompt templates |
| [DEPLOYMENT.md](DEPLOYMENT.md) | Shared hosting deployment |

## Principles

- No Node.js
- No Redis
- No queues/workers
- Request-response architecture
- SQLite-first

## Target Users

- Freelancers
- Small/medium projects
- Corporate websites (real estate, legal, consulting)
- Shared hosting environments

## Not Ideal For

- High-traffic SaaS
- Real-time apps
- Microservice architectures

## Tech Stack

| Category | Technology |
|----------|------------|
| Framework | CodeIgniter 4.4+ |
| PHP | 8.1+ |
| Database | SQLite (default), MySQL (optional) |
| Frontend | Bootstrap 5 |
| Icons | Bootstrap Icons |

## License

MIT License

## Contributing

Pull requests are welcome. For major changes, open an issue first.
