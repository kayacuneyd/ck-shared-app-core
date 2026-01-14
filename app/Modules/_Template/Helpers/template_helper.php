<?php

/**
 * Template Helper Functions
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Dosya adi: template_helper.php -> {modulename}_helper.php
 * 2. Fonksiyon onekleri: template_ -> {modulename}_
 * 3. Route'lar: /templates -> /{modulename}
 */

if (!function_exists('template_url')) {
    /**
     * Kayit icin frontend URL olustur.
     *
     * @param object|string $itemOrSlug Entity nesnesi veya slug string
     * @return string
     */
    function template_url($itemOrSlug): string
    {
        $slug = is_object($itemOrSlug) ? $itemOrSlug->slug : $itemOrSlug;
        return site_url('templates/' . $slug);
    }
}

if (!function_exists('template_admin_url')) {
    /**
     * Kayit icin admin URL olustur.
     *
     * @param int|null $id Kayit ID'si
     * @param string $action Aksiyon (edit, delete, vb.)
     * @return string
     */
    function template_admin_url(?int $id = null, string $action = ''): string
    {
        $url = 'admin/templates';

        if ($id !== null) {
            $url .= '/' . $id;
        }

        if ($action !== '') {
            $url .= '/' . $action;
        }

        return site_url($url);
    }
}

if (!function_exists('template_status_badge')) {
    /**
     * Durum icin Bootstrap badge olustur.
     *
     * @param string $status Durum degeri
     * @return string HTML badge
     */
    function template_status_badge(string $status): string
    {
        $badges = [
            'active' => '<span class="badge bg-success">Aktif</span>',
            'inactive' => '<span class="badge bg-secondary">Pasif</span>',
            'draft' => '<span class="badge bg-warning text-dark">Taslak</span>',
        ];

        return $badges[$status] ?? '<span class="badge bg-secondary">' . esc($status) . '</span>';
    }
}

if (!function_exists('template_active_badge')) {
    /**
     * Aktif/Pasif durumu icin badge.
     *
     * @param bool $isActive
     * @return string HTML badge
     */
    function template_active_badge(bool $isActive): string
    {
        if ($isActive) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-secondary">Pasif</span>';
    }
}

if (!function_exists('template_truncate')) {
    /**
     * Metni belirli uzunlukta kes.
     *
     * @param string $text Metin
     * @param int $length Maksimum uzunluk
     * @param string $suffix Sonuna eklenecek metin
     * @return string
     */
    function template_truncate(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return mb_substr($text, 0, $length) . $suffix;
    }
}

if (!function_exists('template_format_date')) {
    /**
     * Tarihi formatla.
     *
     * @param mixed $date Tarih (string, DateTime, veya Time nesnesi)
     * @param string $format Tarih formati
     * @return string
     */
    function template_format_date($date, string $format = 'd.m.Y H:i'): string
    {
        if (empty($date)) {
            return '-';
        }

        if (is_object($date) && method_exists($date, 'format')) {
            return $date->format($format);
        }

        return date($format, strtotime($date));
    }
}
