# CLAUDE.en.md - AI Development Guide

This file helps AI assistants understand the project with minimal tokens.

## Project Summary

**CK Shared App Core** is a modular CodeIgniter 4 application optimized for shared hosting.
- PHP 8.1+, SQLite (default), Bootstrap 5
- No Node.js/Redis/queue workers
- Languages: DE, EN, TR

## Directory Layout

```
app/
|-- Config/                # Framework settings
|-- Controllers/
|   |-- BaseController.php # Base class for controllers
|   |-- Admin/             # Admin controllers
|   |-- Auth/              # Login/logout
|   `-- Frontend/          # Public pages
|-- Models/                # Database models
|-- Views/
|   |-- layouts/           # Base layouts
|   |-- admin/             # Admin pages
|   |-- auth/              # Login pages
|   `-- frontend/          # Public pages
|-- Modules/               # Modular structure
|   `-- Property/          # Example module
|-- Database/
|   |-- Migrations/        # Table schema
|   `-- Seeds/             # Demo data
|-- Filters/               # Middleware
`-- Language/{de,en,tr}/   # Translations

public/                    # Web root (index.php)
writable/                  # Logs, cache, database
```

## Module Structure (Critical)

Each module lives under `app/Modules/{ModuleName}/`:

```
{ModuleName}/
|-- Config/Routes.php
|-- Controllers/
|   |-- Admin/{ModuleName}Controller.php
|   `-- Frontend/{ModuleName}Controller.php
|-- Models/{ModuleName}Model.php
|-- Entities/{ModuleName}.php
|-- Database/
|   |-- Migrations/
|   `-- Seeds/
|-- Views/
|   |-- admin/{index,create,edit,show}.php
|   `-- frontend/{index,show}.php
|-- Language/{de,en,tr}/{ModuleName}.php
|-- Helpers/{modulename}_helper.php
`-- README.md
```

## Routing Rules

```php
// Frontend: /modulename, /modulename/{slug}
$routes->group('modulename', ['namespace' => 'App\Modules\ModuleName\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'ModuleNameController::index');
    $routes->get('(:segment)', 'ModuleNameController::show/$1');
});

// Admin: /admin/modulename/* (protected by auth filter)
$routes->group('admin/modulename', ['namespace' => 'App\Modules\ModuleName\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ModuleNameController::index');
    $routes->get('create', 'ModuleNameController::create');
    $routes->post('/', 'ModuleNameController::store');
    $routes->get('(:num)', 'ModuleNameController::show/$1');
    $routes->get('(:num)/edit', 'ModuleNameController::edit/$1');
    $routes->put('(:num)', 'ModuleNameController::update/$1');
    $routes->post('(:num)', 'ModuleNameController::update/$1');
    $routes->delete('(:num)', 'ModuleNameController::delete/$1');
    $routes->post('(:num)/delete', 'ModuleNameController::delete/$1');
});
```

## Model Template

```php
<?php
namespace App\Modules\{ModuleName}\Models;

use CodeIgniter\Model;
use App\Modules\{ModuleName}\Entities\{ModuleName};

class {ModuleName}Model extends Model
{
    protected $table = '{tablename}';
    protected $primaryKey = 'id';
    protected $returnType = {ModuleName}::class;
    protected $useTimestamps = true;
    protected $allowedFields = ['field1', 'field2'];

    protected $validationRules = [
        'field1' => 'required|min_length[3]|max_length[255]',
        'field2' => 'required|numeric|greater_than[0]',
    ];
}
```

## Entity Template

```php
<?php
namespace App\Modules\{ModuleName}\Entities;

use CodeIgniter\Entity\Entity;

class {ModuleName} extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'price' => 'float',
        'is_active' => 'boolean',
        'images' => 'json-array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at'];
}
```

## Migration Template

```php
<?php
namespace App\Modules\{ModuleName}\Database\Migrations;

use CodeIgniter\Database\Migration;

class Create{TableName} extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->createTable('{tablename}');
    }

    public function down()
    {
        $this->forge->dropTable('{tablename}');
    }
}
```

## Admin Controller Template

```php
<?php
namespace App\Modules\{ModuleName}\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\{ModuleName}\Models\{ModuleName}Model;

class {ModuleName}Controller extends BaseController
{
    protected {ModuleName}Model $model;

    public function __construct()
    {
        $this->model = new {ModuleName}Model();
        helper(['form', '{modulename}']);
    }
}
```

## Common Commands

```bash
php spark migrate --all
php spark db:seed AdminSeeder
php spark db:seed "App\\Modules\\Property\\Database\\Seeds\\PropertySeeder"
php spark routes
```

## Code Standards

1. No business logic in controllers; delegate to models.
2. All strings should live in language files.
3. Validation rules belong in models.
4. Use full view namespaces in modules.
5. Load helpers in constructors.

## New Module (Quick Steps)

1. Create `app/Modules/{ModuleName}/`
2. Copy from `_Template`
3. Update namespace/class names
4. Register in `app/Config/Routes.php`
5. Run migrations: `php spark migrate --all`

## Database

- Default: SQLite (`writable/database/app.sqlite`)
- Test: SQLite (`writable/database/test.sqlite`)
- Datetime format: `datetime` (ISO 8601)
- Foreign keys: enabled

## Authentication

- Session based (`isLoggedIn` flag)
- AuthFilter protects `/admin/*`
- Login: `/login`, Logout: `/logout`

## Layout Usage

```php
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
    <!-- Content -->
<?= $this->endSection() ?>
```

## Debugging

- Logs: `writable/logs/`
- Debug mode: set `CI_ENVIRONMENT = development` in `.env`
- Error pages: `app/Views/errors/`
