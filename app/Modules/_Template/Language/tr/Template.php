<?php

/**
 * Template Language - Turkish
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Dosya yolu: Language/tr/Template.php -> Language/tr/{ModuleName}.php
 * 2. Metinleri kendi modulunuze gore guncelleyin
 */

return [
    // Admin
    'admin' => [
        'title' => 'Kayitlar',
        'create' => 'Yeni Kayit',
        'edit' => 'Kayit Duzenle',
        'show' => 'Kayit Detayi',
        'delete' => 'Kayit Sil',
        'list' => 'Kayit Listesi',
    ],

    // Frontend
    'frontend' => [
        'title' => 'Tum Kayitlar',
        'show' => 'Kayit Detayi',
        'related' => 'Ilgili Kayitlar',
        'no_items' => 'Henuz kayit bulunmuyor.',
    ],

    // Form alanlari
    'fields' => [
        'title' => 'Baslik',
        'slug' => 'URL Slug',
        'description' => 'Aciklama',
        'status' => 'Durum',
        'is_active' => 'Aktif',
        'sort_order' => 'Siralama',
        'created_at' => 'Olusturulma Tarihi',
        'updated_at' => 'Guncelleme Tarihi',
    ],

    // Durum degerleri
    'status_values' => [
        'active' => 'Aktif',
        'inactive' => 'Pasif',
        'draft' => 'Taslak',
    ],

    // Butonlar
    'buttons' => [
        'create' => 'Yeni Ekle',
        'save' => 'Kaydet',
        'update' => 'Guncelle',
        'delete' => 'Sil',
        'cancel' => 'Iptal',
        'back' => 'Geri',
        'edit' => 'Duzenle',
        'view' => 'Goruntule',
    ],

    // Mesajlar
    'messages' => [
        'created' => 'Kayit basariyla olusturuldu.',
        'updated' => 'Kayit basariyla guncellendi.',
        'deleted' => 'Kayit basariyla silindi.',
        'not_found' => 'Kayit bulunamadi.',
        'delete_confirm' => 'Bu kaydi silmek istediginizden emin misiniz?',
    ],

    // Validation hatalari
    'validation' => [
        'title_required' => 'Baslik alani zorunludur.',
        'title_min_length' => 'Baslik en az 3 karakter olmalidir.',
    ],
];
