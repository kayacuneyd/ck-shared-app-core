# Shared Hosting Deployment Kilavuzu

Bu kilavuz, CK Shared App Core projesini shared hosting ortamina deploy etmek icin adim adim talimatlari icerir.

---

## On Kosullar

### Hosting Gereksinimleri
- PHP 8.1+ (tercihen 8.2 veya 8.3)
- SQLite3 extension (varsayilan veritabani icin)
- intl extension (CodeIgniter 4 icin zorunlu)
- mod_rewrite aktif (Apache)
- Composer erisilebilir (SSH ile) veya lokal vendor yukleme

### Kontrol Edilecekler
Hosting panelinizden (cPanel, Plesk, vb.) asagidakileri kontrol edin:
1. PHP versiyonu 8.1+ mi?
2. SQLite3 ve intl extension'lari aktif mi?
3. SSH erisimi var mi? (opsiyonel ama kolaylastirici)

---

## Deployment Adimlari

### Adim 1: Dosyalari Yukle

#### Secenek A: Git ile (SSH erisimi varsa - ONERILEN)
```bash
cd ~/public_html
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git .
```

#### Secenek B: FTP/SFTP ile
1. Projeyi lokalinizde hazirlayin
2. `vendor/` ve `writable/database/` HARIC tum dosyalari yukleyin
3. Dosya sayisi fazlaysa, zip'leyip yükleyin ve hosting'de extract edin

#### Secenek C: Lokal Build + FTP
```bash
# Lokalinizde
composer install --no-dev --optimize-autoloader
# Sonra tum klasoru (vendor dahil) FTP ile yukleyin
```

---

### Adim 2: Composer Install

#### SSH ile (en iyi yontem)
```bash
cd ~/public_html
composer install --no-dev --optimize-autoloader
```

#### SSH yoksa
1. Lokal makinenizde `composer install --no-dev --optimize-autoloader` calistirin
2. Olusan `vendor/` klasorunu FTP ile yukleyin

---

### Adim 3: Writable Klasor Izinleri

```bash
# SSH ile
chmod -R 755 writable/
mkdir -p writable/database writable/cache writable/logs writable/session

# Eger SQLite kullaniyorsaniz, database klasoru yazilabilir olmali
chmod 775 writable/database/
```

#### FTP ile
Hosting panelinizden (cPanel > File Manager) writable klasorune 755 izni verin.

---

### Adim 4: Environment Dosyasi Olustur

`.env` dosyasi olusturun (proje kokunde):

```ini
# Production ayarlari
CI_ENVIRONMENT = production

# Site URL'i (SONUNDA / OLMALI)
app.baseURL = 'https://your-domain.com/'

# Guvenlik (opsiyonel ama onerilen)
# encryption.key = 'HEX-KEY-BURAYA'  # php spark key:generate ile uretilir

# Session ayarlari (opsiyonel)
# session.driver = 'FileHandler'
# session.savePath = 'writable/session'
```

---

### Adim 5: Database Migration

#### SSH ile
```bash
cd ~/public_html
php spark migrate --all
```

#### SSH yoksa
1. Lokal makinenizde migration'lari calistirin
2. Olusan `writable/database/app.sqlite` dosyasini FTP ile yukleyin

#### Demo Veri (Opsiyonel)
```bash
# Admin kullanicisi olustur
php spark db:seed AdminSeeder

# Property demo verileri
php spark db:seed "App\\Modules\\Property\\Database\\Seeds\\PropertySeeder"
```

---

### Adim 6: .htaccess Kontrolu

Proje kokunde `.htaccess` dosyasinin oldugunu kontrol edin:

```apache
# public/ klasorune yonlendir
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

`public/.htaccess` dosyasinda:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

---

## Deployment Checklist

Asagidaki kontrol listesini kullanin:

### Pre-Deployment
- [ ] PHP versiyonu kontrol edildi (8.1+)
- [ ] SQLite3 ve intl extension aktif
- [ ] mod_rewrite aktif
- [ ] Lokal testler basarili

### Deployment
- [ ] Dosyalar yuklendi
- [ ] `composer install --no-dev --optimize-autoloader` calistirildi
- [ ] `writable/` izinleri ayarlandi (755)
- [ ] `.env` dosyasi olusturuldu
- [ ] `php spark migrate --all` calistirildi
- [ ] `.htaccess` dosyalari kontrol edildi

### Post-Deployment
- [ ] Ana sayfa calisiyor: `https://domain.com/`
- [ ] Properties sayfasi calisiyor: `https://domain.com/properties`
- [ ] Login sayfasi calisiyor: `https://domain.com/login`
- [ ] Admin paneli calisiyor: `https://domain.com/admin`
- [ ] CRUD islemleri test edildi
- [ ] Hata loglari kontrol edildi: `writable/logs/`

---

## Hata Giderme

### 500 Internal Server Error
1. `.htaccess` dosyalarini kontrol edin
2. `writable/logs/` klasorundeki log dosyalarini inceleyin
3. PHP versiyonunu kontrol edin

### 404 Not Found (tum sayfalarda)
1. mod_rewrite aktif mi kontrol edin
2. `.htaccess` dosyalarinin yuklendiginden emin olun
3. `AllowOverride All` ayarini kontrol edin

### Database Hatasi
1. `writable/database/` klasor izinlerini kontrol edin (775)
2. SQLite3 extension'in aktif oldugunu kontrol edin
3. Migration'larin calistigindan emin olun

### Blank Page (Bos Sayfa)
1. PHP hata raporlamasini acin (gecici olarak)
2. `.env` dosyasinda `CI_ENVIRONMENT = development` yapin
3. `writable/logs/` kontrol edin

---

## Guncelleme Adimlari

Projeyi guncellemek icin:

```bash
# SSH ile
cd ~/public_html
git pull origin main
composer install --no-dev --optimize-autoloader
php spark migrate --all

# Cache temizle
php spark cache:clear
```

---

## Guvenlik Onerileri

1. **`.env` dosyasini koruyun** - Web'den erisilemez olmali
2. **`writable/` klasorunu koruyun** - .htaccess ile erisimi engelleyin
3. **HTTPS kullanin** - Let's Encrypt ile ucretsiz SSL
4. **Guclu sifre** - Admin sifresi en az 12 karakter
5. **Duzenli yedek** - SQLite dosyasini duzenli yedekleyin

---

## Yedekleme

### Manuel Yedek
```bash
# SSH ile
cp writable/database/app.sqlite writable/database/backup_$(date +%Y%m%d).sqlite
```

### Otomatik Yedek (cron)
```bash
# crontab -e ile ekleyin (her gun gece 2'de)
0 2 * * * cp ~/public_html/writable/database/app.sqlite ~/backups/app_$(date +\%Y\%m\%d).sqlite
```

---

## Dosya Yapisi (Shared Hosting)

```
public_html/
├── .htaccess              <- Root rewrite (public/'a yonlendirir)
├── .env                   <- Environment ayarlari (gitignore'da)
├── app/                   <- Uygulama kodu
├── composer.json
├── composer.lock
├── public/
│   ├── .htaccess          <- URL rewriting
│   ├── index.php          <- Entry point
│   └── assets/            <- CSS, JS, images
├── spark                  <- CLI tool
├── vendor/                <- Composer dependencies
└── writable/
    ├── database/
    │   └── app.sqlite     <- SQLite veritabani
    ├── cache/
    ├── logs/
    └── session/
```
