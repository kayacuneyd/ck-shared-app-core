<?php

namespace App\Modules\_Template\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Template Entity
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Namespace: 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 2. Class: 'Template' -> '{ModuleName}'
 * 3. $attributes: Kendi alanlarinizi ekleyin
 * 4. $casts: Kendi tip donusumlerinizi ekleyin
 */
class Template extends Entity
{
    /**
     * Varsayilan degerler.
     * ONEMLI: Kendi alanlarinizi buraya ekleyin.
     */
    protected $attributes = [
        'id' => null,
        'title' => null,
        'slug' => null,
        'description' => null,
        'status' => 'draft',
        'is_active' => true,
        'sort_order' => 0,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * Tip donusumleri.
     * ONEMLI: Kendi donusumlerinizi buraya ekleyin.
     *
     * Kullanilabilir tipler:
     * - integer, float, boolean, string
     * - array, object, json, json-array
     * - datetime, timestamp
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Slug uret.
     */
    public function generateSlug(): string
    {
        $slug = mb_strtolower($this->attributes['title']);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }

    /**
     * Aktif mi kontrol et.
     */
    public function isActive(): bool
    {
        return (bool) $this->attributes['is_active'];
    }

    /**
     * Durumu kontrol et.
     */
    public function hasStatus(string $status): bool
    {
        return $this->attributes['status'] === $status;
    }

    /**
     * Taslak mi kontrol et.
     */
    public function isDraft(): bool
    {
        return $this->hasStatus('draft');
    }

    /**
     * Yayinda mi kontrol et.
     */
    public function isPublished(): bool
    {
        return $this->hasStatus('active') && $this->isActive();
    }
}
