<?php

namespace App\Modules\Property\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Property Entity
 *
 * Represents a real estate property listing with typed properties
 * and automatic date casting.
 */
class Property extends Entity
{
    /**
     * Define which fields can be set via mass assignment.
     *
     * @var array<string>
     */
    protected $attributes = [
        'id' => null,
        'title' => null,
        'slug' => null,
        'description' => null,
        'price' => null,
        'bedrooms' => null,
        'bathrooms' => null,
        'area_sqm' => null,
        'address' => null,
        'city' => null,
        'zip_code' => null,
        'status' => 'available',
        'featured' => false,
        'images' => '[]',
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * Define how certain fields should be cast when accessed.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'float',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'area_sqm' => 'float',
        'featured' => 'boolean',
        'images' => 'json-array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Fields that are dates.
     *
     * @var array<string>
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Generate a URL-friendly slug from the title.
     *
     * @return string
     */
    public function generateSlug(): string
    {
        $slug = mb_strtolower($this->attributes['title']);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }

    /**
     * Get the first image or a placeholder.
     *
     * @return string
     */
    public function getMainImage(): string
    {
        $images = $this->images;
        if (!empty($images) && isset($images[0])) {
            return $images[0];
        }

        return '/assets/images/property-placeholder.jpg';
    }

    /**
     * Check if the property is available.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->attributes['status'] === 'available';
    }

    /**
     * Check if the property is featured.
     *
     * @return bool
     */
    public function isFeatured(): bool
    {
        return (bool) $this->attributes['featured'];
    }
}
