# AI Prompt Library

Bu dosya, Claude Code ve benzeri AI asistanlarla calisirken kullanilacak hazir prompt sablonlarini icerir. Token tasarrufu saglar ve tutarli sonuclar verir.

---

## Modul Islemleri

### Yeni Modul Olustur

```
{ModuleName} modulu olustur.
Alanlar: {field1} ({type1}), {field2} ({type2}), ...
_Template modulunu referans al.
Route'u app/Config/Routes.php'ye ekle.
```

**Ornek:**
```
Blog modulu olustur.
Alanlar: title (string), content (text), author (string), published_at (datetime), is_published (boolean)
_Template modulunu referans al.
Route'u app/Config/Routes.php'ye ekle.
```

### Module Alan Ekle

```
{ModuleName} modulune {field_name} ({type}) alani ekle.
Migration, Model, Entity, View dosyalarini guncelle.
Validation kurali: {rule}
```

**Ornek:**
```
Property modulune property_type (string) alani ekle.
Migration, Model, Entity, View dosyalarini guncelle.
Validation kurali: required|in_list[apartment,house,land,commercial]
```

### Module Iliski Ekle

```
{ModuleName1} ile {ModuleName2} arasinda {relation_type} iliski kur.
Foreign key: {fk_field}
```

**Ornek:**
```
Property ile Category arasinda belongsTo iliski kur.
Foreign key: category_id
```

---

## CRUD Islemleri

### Admin CRUD Sayfasi Ekle

```
{ModuleName} modulune admin {action} sayfasi ekle.
{description}
```

**Ornek:**
```
Property modulune admin bulk delete sayfasi ekle.
Secili kayitlari toplu silme ozelligi.
```

### Frontend Sayfasi Ekle

```
{ModuleName} modulune frontend {page_name} sayfasi ekle.
{description}
Route: /{route_path}
```

---

## Veritabani Islemleri

### Migration Olustur

```
{table_name} tablosu icin migration olustur.
Alanlar:
- {field1}: {type1} {constraints}
- {field2}: {type2} {constraints}
Indexler: {index_fields}
```

### Seeder Olustur

```
{ModuleName} modulu icin seeder olustur.
{count} adet demo veri.
```

---

## Dil Dosyalari

### Ceviri Ekle

```
{ModuleName} modulune {language} cevirisi ekle.
Mevcut TR cevirisini referans al.
```

### Tum Dillere Key Ekle

```
{ModuleName} modulunun tum dil dosyalarina {key_path} key'ini ekle.
TR: {tr_value}
EN: {en_value}
DE: {de_value}
```

---

## Hata Duzeltme

### Bug Fix

```
{file_path}:{line_number} hata veriyor.
Hata mesaji: {error_message}
Beklenen davranis: {expected_behavior}
```

### Validation Hatasi

```
{ModuleName} modulunde {field} alani icin validation calismiyory.
Kural: {rule}
Beklenen: {expected}
Gerceklesen: {actual}
```

---

## Performans

### Sorgu Optimizasyonu

```
{ModuleName}Model'deki {method_name} metodunu optimize et.
Mevcut: {current_behavior}
Hedef: {target_behavior}
```

### Cache Ekle

```
{ModuleName} modulune cache ekle.
Cache suresi: {duration}
Invalidation: {when_to_invalidate}
```

---

## View Islemleri

### Form Alani Ekle

```
{ModuleName} admin formuna {field_name} alani ekle.
Tip: {input_type}
Validation: {client_side_validation}
```

### Tablo Kolonu Ekle

```
{ModuleName} admin listesine {column_name} kolonu ekle.
Gosterilecek deger: {value_expression}
Siralama: {sortable: yes/no}
```

---

## API Islemleri

### REST Endpoint Ekle

```
{ModuleName} modulu icin REST API olustur.
Endpoints:
- GET /{modulename} - liste
- GET /{modulename}/{id} - detay
- POST /{modulename} - olustur
- PUT /{modulename}/{id} - guncelle
- DELETE /{modulename}/{id} - sil
Authentication: {auth_type}
```

---

## Test Islemleri

### Unit Test Ekle

```
{ModuleName}Model icin unit test olustur.
Test edilecek metodlar: {method_list}
```

### Feature Test Ekle

```
{ModuleName} CRUD islemleri icin feature test olustur.
Senaryolar: create, read, update, delete, validation_error
```

---

## Deployment

### Pre-deployment Kontrol

```
Deployment oncesi kontrol yap:
- Tum migration'lar calisir mi?
- Env ayarlari dogru mu?
- Writable izinleri tamam mi?
```

### Post-deployment Test

```
Deployment sonrasi test et:
- Ana sayfa calisiyor mu?
- Login/logout calisiyor mu?
- CRUD islemleri calisiyor mu?
- Hata loglari temiz mi?
```

---

## Hizli Referans

### Sik Kullanilan Tek Satirlik Promptlar

```
# Route ekle
{ModuleName} modulunun route'unu Routes.php'ye ekle.

# Helper fonksiyon ekle
{ModuleName} helper'a {function_name} fonksiyonu ekle: {description}

# Validation kurali ekle
{ModuleName}Model'e {field} icin {rule} validation kurali ekle.

# View partial olustur
{ModuleName} icin {partial_name} partial view olustur.

# Language key ekle
{ModuleName} dil dosyalarina {key} ekle.

# Index ekle
{table_name} tablosuna {column} icin index ekle.
```

---

## Token Tasarrufu Ipuclari

1. **Modul adi kullan**: "Property modulunde..." yerine "Property'de..."
2. **Referans ver**: "Property modulundeki gibi yap" veya "_Template'i baz al"
3. **Tek satirda birden fazla is**: "X ekle ve Y'yi guncelle"
4. **Spesifik ol**: "CRUD ekle" yerine "admin index sayfasi ekle"
5. **Onceki context'i kullan**: "Ayni sekilde Blog icin de yap"

---

## Ornek Workflow

### Yeni Proje Baslangici

```
1. "Blog modulu olustur. Alanlar: title, content, author, published_at, is_featured. _Template baz al."
2. "Route'u ekle ve migration calistir."
3. "3 demo veri ekle."
4. "Admin listesine published_at kolonu ekle, siralama aktif."
```

### Feature Ekleme

```
1. "Property'ye property_type alani ekle (apartment/house/land)."
2. "Admin formunda select box olarak goster."
3. "Frontend listesinde filtreleme ekle."
4. "Dil dosyalarina cevirileri ekle."
```

### Bug Fixing

```
1. "PropertyController:store'da slug uretilmiyor. Duzelt."
2. "Login sonrasi redirect /admin yerine / gidiyor. Duzelt."
```
