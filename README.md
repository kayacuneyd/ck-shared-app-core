# CK Shared App Core

**CK Shared App Core**, shared hosting ortamlarinda calisacak sekilde tasarlanmis,
CodeIgniter 4 + Bootstrap 5 + SQLite tabanli, moduler ve urunlesebilir bir web uygulama altyapisidir.

## Ozellikler

- **Shared Hosting Uyumlu** - Node.js, Redis, Queue worker gerektirmez
- **Moduler Yapi** - Bagimsiz moduller ekleyip cikarabilirsiniz
- **SQLite First** - Varsayilan olarak SQLite, MySQL opsiyonel
- **Coklu Dil** - Almanca, Ingilizce, Turkce destegi
- **AI-Friendly** - CLAUDE.md ve PROMPTS.md ile token-efficient gelistirme
- **Admin Paneli** - Bootstrap 5 tabanli responsive admin arayuzu

## Hizli Baslangic

### Gereksinimler

- PHP 8.1+ (intl extension)
- SQLite3 extension
- Composer
- Apache (mod_rewrite)

### Kurulum

```bash
# Projeyi klonla
git clone https://github.com/YOUR_USERNAME/ck-shared-app-core.git
cd ck-shared-app-core

# Bagimliliklari yukle
composer install

# Environment dosyasini olustur
cp .env.example .env

# Writable izinlerini ayarla (Linux/Mac)
chmod -R 755 writable/

# Migration'lari calistir
php spark migrate --all

# Demo veri yukle (opsiyonel)
php spark db:seed AdminSeeder
php spark db:seed "App\\Modules\\Property\\Database\\Seeds\\PropertySeeder"

# Development server baslat
php spark serve
```

Tarayicida: `http://localhost:8080`

## Proje Yapisi

```
ck-shared-app-core/
├── app/
│   ├── Config/           # Framework ayarlari
│   ├── Controllers/      # MVC Controller'lar
│   ├── Models/           # Veritabani modelleri
│   ├── Views/            # Sablon dosyalari
│   ├── Modules/          # Moduler yapi
│   │   ├── Property/     # Ornek modul (Emlak)
│   │   └── _Template/    # Yeni modul sablonu
│   ├── Database/         # Migration ve Seed'ler
│   ├── Filters/          # Middleware'ler
│   └── Language/         # Ceviri dosyalari
├── public/               # Web root
├── writable/             # Yazilabilir dosyalar
├── CLAUDE.md             # AI asistan rehberi
├── PROMPTS.md            # Hazir prompt sablonlari
├── DEPLOYMENT.md         # Deployment kilavuzu
└── README.md             # Bu dosya
```

## Kullanim

### Yeni Modul Olusturma

1. `app/Modules/_Template/` klasorunu kopyalayin
2. Dosya ve class isimlerini degistirin
3. Route'u `app/Config/Routes.php`'ye ekleyin
4. Migration calistirin

Detaylar icin: `app/Modules/_Template/README.md`

### AI ile Gelistirme

Bu proje AI asistanlarla (Claude Code, vb.) verimli calisacak sekilde tasarlanmistir.

- **CLAUDE.md** - Projeyi AI'a tanitir, token tasarrufu saglar
- **PROMPTS.md** - Hazir prompt sablonlari

Ornek prompt:
```
Blog modulu olustur.
Alanlar: title, content, author, published_at, is_featured
_Template modulunu referans al.
```

## Dokumantasyon

| Dosya | Aciklama |
|-------|----------|
| [CLAUDE.md](CLAUDE.md) | AI asistan icin proje rehberi |
| [PROMPTS.md](PROMPTS.md) | Hazir prompt sablonlari |
| [DEPLOYMENT.md](DEPLOYMENT.md) | Shared hosting deployment kilavuzu |

## Temel Prensipler

- No Node.js
- No Redis
- No Queue / Worker
- Request-response mimarisi
- SQLite first

## Kimler Icin?

- Freelancer gelistiriciler
- Kucuk/orta olcekli projeler
- Emlak, hukuk, danismanlik gibi kurumsal siteler
- Shared hosting kullananlar

## Kimler Icin Degil?

- High traffic SaaS
- Real-time uygulamalar
- Microservice mimarisi

## Teknolojiler

| Kategori | Teknoloji |
|----------|-----------|
| Framework | CodeIgniter 4.4+ |
| PHP | 8.1+ |
| Database | SQLite (varsayilan), MySQL (opsiyonel) |
| Frontend | Bootstrap 5 |
| Icons | Bootstrap Icons |

## Lisans

MIT License

## Katki

Pull request'ler memnuniyetle karsilanir. Buyuk degisiklikler icin once issue acin.
