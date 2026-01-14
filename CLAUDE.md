# CLAUDE.md - AI Development Guide

Bu dosya, Claude Code ve benzeri AI asistanların bu projeyi minimum token ile anlamasini saglar.

## Proje Ozeti

**CK Shared App Core** - CodeIgniter 4 tabanli moduler web uygulamasi.
- PHP 8.1+, SQLite (varsayilan), Bootstrap 5
- Shared hosting icin optimize (Node.js/Redis yok)
- Coklu dil: DE, EN, TR

## Dizin Yapisi

```
app/
├── Config/                    # Framework ayarlari
├── Controllers/
│   ├── BaseController.php     # Tum controller'larin base class'i
│   ├── Admin/                 # Admin paneli controller'lari
│   ├── Auth/                  # Login/logout
│   └── Frontend/              # Genel sayfalar
├── Models/                    # Veritabani modelleri
├── Views/
│   ├── layouts/               # Ana layout'lar (frontend.php, admin.php)
│   ├── admin/                 # Admin sayfalari
│   ├── auth/                  # Login sayfasi
│   └── frontend/              # Genel sayfalar
├── Modules/                   # MODULER YAPI - her modul bagimsiz
│   └── Property/              # Ornek modul (emlak yonetimi)
├── Database/
│   ├── Migrations/            # Tablo olusturma
│   └── Seeds/                 # Demo veri
├── Filters/                   # Middleware'ler (AuthFilter)
└── Language/{de,en,tr}/       # Ceviri dosyalari

public/                        # Web root (index.php)
writable/
├── database/app.sqlite        # SQLite veritabani
├── cache/                     # Onbellek
├── logs/                      # Log dosyalari
└── session/                   # Oturum
```

## Modul Yapisi (Kritik)

Her modul `app/Modules/{ModuleName}/` altinda ve su yapida:

```
{ModuleName}/
├── Config/Routes.php                           # Modul rotalari
├── Controllers/
│   ├── Admin/{ModuleName}Controller.php        # Admin CRUD
│   └── Frontend/{ModuleName}Controller.php     # Genel listeleme
├── Models/{ModuleName}Model.php                # DB islemleri + validation
├── Entities/{ModuleName}.php                   # Entity class (type casting)
├── Database/
│   ├── Migrations/                             # Tablo olusturma
│   └── Seeds/                                  # Demo veri
├── Views/
│   ├── admin/{index,create,edit,show}.php      # Admin arayuzu
│   └── frontend/{index,show}.php               # Genel arayuz
├── Language/{de,en,tr}/{ModuleName}.php        # Ceviriler
├── Helpers/{modulename}_helper.php             # Yardimci fonksiyonlar
└── README.md                                   # Modul dokumantasyonu
```

## Routing Kurallari

```php
// Frontend: /modulename, /modulename/{slug}
$routes->group('modulename', ['namespace' => 'App\Modules\ModuleName\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'ModuleNameController::index');
    $routes->get('(:segment)', 'ModuleNameController::show/$1');
});

// Admin: /admin/modulename/* (auth filter ile korunur)
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

## Model Sablonu

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
    protected $allowedFields = ['field1', 'field2', ...];

    protected $validationRules = [
        'field1' => 'required|min_length[3]|max_length[255]',
        'field2' => 'required|numeric|greater_than[0]',
    ];

    // Slug'a gore bul
    public function findBySlug(string $slug): ?{ModuleName}
    {
        return $this->where('slug', $slug)->first();
    }

    // Benzersiz slug uret
    public function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = mb_strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = trim($slug, '-');

        $original = $slug;
        $counter = 1;
        while (true) {
            $builder = $this->builder()->where('slug', $slug);
            if ($excludeId) $builder->where('id !=', $excludeId);
            if ($builder->countAllResults() === 0) break;
            $slug = $original . '-' . $counter++;
        }
        return $slug;
    }
}
```

## Entity Sablonu

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

## Migration Sablonu

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

## Admin Controller Sablonu

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

    public function index(): string
    {
        return view('App\Modules\{ModuleName}\Views\admin\index', [
            'title' => lang('{ModuleName}.admin.title'),
            'items' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function create(): string
    {
        return view('App\Modules\{ModuleName}\Views\admin\create', [
            'title' => lang('{ModuleName}.admin.create'),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['slug'] = $this->model->generateUniqueSlug($data['title']);

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return redirect()->to('/admin/{modulename}')->with('message', lang('{ModuleName}.messages.created'));
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/{modulename}')->with('error', lang('{ModuleName}.messages.not_found'));

        return view('App\Modules\{ModuleName}\Views\admin\edit', [
            'title' => lang('{ModuleName}.admin.edit'),
            'item' => $item,
        ]);
    }

    public function update(int $id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/{modulename}')->with('error', lang('{ModuleName}.messages.not_found'));

        $data = $this->request->getPost();
        if ($data['title'] !== $item->title) {
            $data['slug'] = $this->model->generateUniqueSlug($data['title'], $id);
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return redirect()->to('/admin/{modulename}')->with('message', lang('{ModuleName}.messages.updated'));
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/{modulename}')->with('message', lang('{ModuleName}.messages.deleted'));
    }
}
```

## Sik Kullanilan Komutlar

```bash
# Migration calistir
php spark migrate --all

# Seed calistir
php spark db:seed AdminSeeder
php spark db:seed "App\\Modules\\Property\\Database\\Seeds\\PropertySeeder"

# Route listesi
php spark routes
```

## Kod Standartlari

1. **Controller'da is mantigi yok** - Model'e delege et
2. **Tum string'ler Language dosyasinda** - Hardcoded string yok
3. **Validation kurallari Model'de** - Controller'da degil
4. **View path'leri tam namespace ile** - `App\Modules\X\Views\...`
5. **Helper'lar constructor'da yukle** - `helper(['form', 'modulename'])`

## Yeni Modul Olusturma (Hizli Referans)

1. `app/Modules/{ModuleName}/` dizini olustur
2. Property modulunu referans alarak dosyalari kopyala
3. Namespace ve class isimlerini degistir
4. `app/Config/Routes.php` sonuna `require_once APPPATH . 'Modules/{ModuleName}/Config/Routes.php';` ekle
5. Migration calistir: `php spark migrate --all`

## Veritabani

- **Varsayilan:** SQLite (`writable/database/app.sqlite`)
- **Test:** SQLite (`writable/database/test.sqlite`)
- **Tarih formati:** `datetime` (ISO 8601)
- **Foreign key:** Aktif

## Authentication

- Session tabanli (`isLoggedIn` flag)
- AuthFilter middleware: `app/Filters/AuthFilter.php`
- Admin rotalar `['filter' => 'auth']` ile korunur
- Login: `/login`, Logout: `/logout`

## Layout Sistemi

```php
// View icinde layout kullanimi
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
    <!-- Icerik -->
<?= $this->endSection() ?>
```

## Hata Ayiklama

- Log dosyalari: `writable/logs/`
- Debug modu: `.env` dosyasinda `CI_ENVIRONMENT = development`
- Hata sayfasi: `app/Views/errors/`
