# _Template Module

Bu modul, yeni moduller olusturmak icin kullanilan bir sablondur.

## Yeni Modul Olusturma Adimlari

### 1. Modulu Kopyala

```bash
cp -r app/Modules/_Template app/Modules/{YeniModulAdi}
```

### 2. Dosya Adlarini Degistir

```
Controllers/Admin/TemplateController.php  -> {ModulAdi}Controller.php
Controllers/Frontend/TemplateController.php -> {ModulAdi}Controller.php
Models/TemplateModel.php                  -> {ModulAdi}Model.php
Entities/Template.php                     -> {ModulAdi}.php
Helpers/template_helper.php               -> {moduladi}_helper.php
Language/*/Template.php                   -> {ModulAdi}.php
Database/Migrations/...CreateTemplates.php -> ...Create{TabloAdi}.php
Database/Seeds/TemplateSeeder.php         -> {ModulAdi}Seeder.php
```

### 3. Namespace ve Class Adlarini Guncelle

Her dosyada:
- `App\Modules\_Template` -> `App\Modules\{ModulAdi}`
- `TemplateController` -> `{ModulAdi}Controller`
- `TemplateModel` -> `{ModulAdi}Model`
- `Template` (Entity) -> `{ModulAdi}`
- `template_` (helper fonksiyonlari) -> `{moduladi}_`

### 4. Route'lari Guncelle

`Config/Routes.php` dosyasinda:
- `templates` -> `{moduladi}` (URL path)
- `admin/templates` -> `admin/{moduladi}`

### 5. Veritabani Alanlarini Guncelle

- `Models/{ModulAdi}Model.php` - `$allowedFields` ve `$validationRules`
- `Entities/{ModulAdi}.php` - `$attributes` ve `$casts`
- `Database/Migrations/...` - tablo alanlari

### 6. View'lari Guncelle

- Form alanlarini kendi modulunuze gore duzenleyin
- Lang key'lerini guncelleyin

### 7. Ana Route Dosyasina Ekle

`app/Config/Routes.php` sonuna ekleyin:

```php
require_once APPPATH . 'Modules/{ModulAdi}/Config/Routes.php';
```

### 8. Migration Calistir

```bash
php spark migrate --all
```

### 9. (Opsiyonel) Seed Calistir

```bash
php spark db:seed "App\\Modules\\{ModulAdi}\\Database\\Seeds\\{ModulAdi}Seeder"
```

## Dosya Yapisi

```
_Template/
├── Config/
│   └── Routes.php              # Modul rotalari
├── Controllers/
│   ├── Admin/
│   │   └── TemplateController.php   # Admin CRUD
│   └── Frontend/
│       └── TemplateController.php   # Frontend listeleme
├── Models/
│   └── TemplateModel.php       # DB islemleri + validation
├── Entities/
│   └── Template.php            # Entity (type casting)
├── Database/
│   ├── Migrations/
│   │   └── ...CreateTemplates.php   # Tablo olusturma
│   └── Seeds/
│       └── TemplateSeeder.php  # Demo veri
├── Views/
│   ├── admin/
│   │   ├── index.php           # Liste
│   │   ├── create.php          # Yeni kayit formu
│   │   ├── edit.php            # Duzenleme formu
│   │   └── show.php            # Detay
│   └── frontend/
│       ├── index.php           # Genel liste
│       └── show.php            # Genel detay
├── Language/
│   ├── de/Template.php         # Almanca
│   ├── en/Template.php         # Ingilizce
│   └── tr/Template.php         # Turkce
├── Helpers/
│   └── template_helper.php     # Yardimci fonksiyonlar
└── README.md                   # Bu dosya
```

## Notlar

- Bu modul **kullanilmak icin degil**, kopyalanmak icin tasarlanmistir
- Route dosyasini ana Routes.php'ye eklemeyin (sadece gercek moduller icin)
- Migration dosyasinin tarih prefixi benzersiz olmalidir
