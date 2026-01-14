# Release Proseduru

Bu dokuman, CK Shared App Core projesinin release surecini aciklar.

## Neden Release ZIP?

- **Repo'da vendor/ yok** (dogru yaklasim, repo temiz kalir)
- **SSH olmayan hosting'ler** icin `composer install` calistirilamaz
- **Cozum:** vendor/ dahil production-ready ZIP

## Hizli Baslangic

```bash
# Release olustur
php scripts/build-release.php

# veya versiyon belirterek
php scripts/build-release.php 1.2.0
```

Cikti: `releases/ck-shared-app-core-v1.2.0.zip`

---

## Release Sureci (Adim Adim)

### 1. Kod Hazirligi

```bash
# Testleri calistir (varsa)
php spark test

# Tum degisiklikleri commit et
git add .
git commit -m "Release v1.2.0 hazirligi"
```

### 2. Versiyon Guncelle

`composer.json` dosyasinda:
```json
{
    "version": "1.2.0"
}
```

### 3. Release Olustur

```bash
php scripts/build-release.php
```

Bu script:
1. Proje dosyalarini kopyalar
2. `composer install --no-dev` calistirir
3. Gereksiz dosyalari temizler
4. ZIP olusturur

### 4. GitHub'a Yukle

```bash
# Tag olustur
git tag v1.2.0
git push origin v1.2.0

# GitHub Releases sayfasinda:
# 1. "Draft a new release" tikla
# 2. Tag sec: v1.2.0
# 3. ZIP dosyasini yukle
# 4. Release notes yaz
# 5. Publish
```

### 5. Deployment

#### SSH Olan Hosting
```bash
cd ~/public_html
git pull origin main
composer install --no-dev --optimize-autoloader
php spark migrate --all
```

#### SSH Olmayan Hosting (FTP)
1. GitHub Releases'ten ZIP indir
2. FTP ile `public_html/` klasorune extract et
3. `.env` dosyasini olustur
4. Hosting panelinden `php spark migrate --all` calistir
   (veya lokal'de migration yapip SQLite yukle)

---

## Release ZIP Icerigi

```
ck-shared-app-core-v1.2.0/
├── app/                    # Uygulama kodu
├── public/                 # Web root
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── vendor/                 # Composer dependencies (DAHIL)
├── writable/
│   ├── database/.gitkeep
│   ├── cache/.gitkeep
│   ├── logs/.gitkeep
│   └── session/.gitkeep
├── composer.json
├── composer.lock
├── spark
├── .htaccess
├── .env.example
├── README.md
├── DEPLOYMENT.md
├── CLAUDE.md
└── PROMPTS.md
```

## Dahil Edilmeyenler

- `.git/` - Git gecmisi
- `.env` - Gizli ayarlar
- `*.sqlite` - Veritabani dosyalari
- `*.log` - Log dosyalari
- `scripts/` - Build scriptleri
- `tests/` - Test dosyalari
- `releases/` - Onceki release'ler

---

## Versiyon Numaralama

Semantic Versioning (SemVer) kullanin:

- **MAJOR.MINOR.PATCH** (ornek: 1.2.3)
- **MAJOR**: Breaking changes (geriye uyumsuz)
- **MINOR**: Yeni ozellikler (geriye uyumlu)
- **PATCH**: Bug fix'ler

Ornekler:
- `1.0.0` -> `1.0.1` : Bug fix
- `1.0.1` -> `1.1.0` : Yeni modul eklendi
- `1.1.0` -> `2.0.0` : Veritabani yapisi degisti

---

## Checklist

### Release Oncesi
- [ ] Tum testler gecti
- [ ] Kod review yapildi
- [ ] CHANGELOG guncellendi
- [ ] Version numarasi guncellendi
- [ ] Tum degisiklikler commit edildi

### Release Sirasinda
- [ ] `php scripts/build-release.php` calistirildi
- [ ] ZIP boyutu kontrol edildi (~15-20 MB beklenir)
- [ ] ZIP acilip test edildi (lokal)

### Release Sonrasi
- [ ] GitHub tag olusturuldu
- [ ] GitHub Release yayinlandi
- [ ] ZIP yuklendi
- [ ] Release notes yazildi
- [ ] Production'da test edildi

---

## Sorun Giderme

### "Composer install basarisiz"
- Composer global olarak yuklu mu? `composer --version`
- PHP versiyonu 8.1+ mi? `php --version`
- Internet baglantisi var mi?

### "ZIP olusturulamadi"
- PHP zip extension yuklu mu?
- `releases/` klasorune yazma izni var mi?

### "Release cok buyuk"
- `vendor/` normal olarak ~15-20 MB civarindadir
- Gereksiz dosyalar varsa script'i kontrol edin

---

## Script Detaylari

`scripts/build-release.php` su adimlari yapar:

1. Versiyon numarasini al (parametre veya composer.json)
2. Gecici klasor olustur
3. Proje dosyalarini kopyala (exclude listesine gore)
4. `composer install --no-dev --optimize-autoloader`
5. Writable klasorlerini hazirla
6. Gecici dosyalari temizle
7. ZIP olustur
8. Gecici klasoru sil

Customize etmek icin script'i duzenleyebilirsiniz.
