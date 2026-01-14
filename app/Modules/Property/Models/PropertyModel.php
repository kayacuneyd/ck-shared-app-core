<?php

namespace App\Modules\Property\Models;

use CodeIgniter\Model;
use App\Modules\Property\Entities\Property;

/**
 * PropertyModel
 *
 * Provides database operations for the properties table.
 * Uses SQLite-compatible queries and includes validation rules.
 */
class PropertyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';

    /**
     * The primary key for the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Whether auto-incrementing is enabled.
     *
     * @var bool
     */
    protected $useAutoIncrement = true;

    /**
     * The return type for results.
     *
     * @var string
     */
    protected $returnType = Property::class;

    /**
     * Whether soft deletes are enabled.
     *
     * @var bool
     */
    protected $useSoftDeletes = false;

    /**
     * Fields that are allowed to be set via mass assignment.
     *
     * @var array<string>
     */
    protected $allowedFields = [
        'title',
        'slug',
        'description',
        'price',
        'bedrooms',
        'bathrooms',
        'area_sqm',
        'address',
        'city',
        'zip_code',
        'status',
        'featured',
        'images',
    ];

    /**
     * Whether timestamps are automatically managed.
     *
     * @var bool
     */
    protected $useTimestamps = true;

    /**
     * The column for created_at timestamp.
     *
     * @var string
     */
    protected $createdField = 'created_at';

    /**
     * The column for updated_at timestamp.
     *
     * @var string
     */
    protected $updatedField = 'updated_at';

    /**
     * Date format for timestamps (SQLite compatible).
     *
     * @var string
     */
    protected $dateFormat = 'datetime';

    /**
     * Validation rules for property data.
     *
     * @var array<string, string>
     */
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[10]',
        'price' => 'required|numeric|greater_than[0]',
        'bedrooms' => 'permit_empty|integer|greater_than_equal_to[0]',
        'bathrooms' => 'permit_empty|integer|greater_than_equal_to[0]',
        'area_sqm' => 'permit_empty|numeric|greater_than[0]',
        'address' => 'required|max_length[255]',
        'city' => 'required|max_length[100]',
        'zip_code' => 'required|max_length[20]',
        'status' => 'required|in_list[available,sold,reserved]',
        'featured' => 'permit_empty|in_list[0,1]',
    ];

    /**
     * Validation error messages.
     *
     * @var array<string, array<string, string>>
     */
    protected $validationMessages = [
        'title' => [
            'required' => 'Property title is required.',
            'min_length' => 'Title must be at least 3 characters.',
        ],
        'price' => [
            'required' => 'Price is required.',
            'greater_than' => 'Price must be greater than 0.',
        ],
    ];

    /**
     * Whether validation should be skipped.
     *
     * @var bool
     */
    protected $skipValidation = false;

    /**
     * Find a property by its slug.
     *
     * @param string $slug
     * @return Property|null
     */
    public function findBySlug(string $slug): ?Property
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Get all active (available) properties.
     *
     * @return array
     */
    public function getAvailable(): array
    {
        return $this->where('status', 'available')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get featured properties.
     *
     * @param int $limit
     * @return array
     */
    public function getFeatured(int $limit = 6): array
    {
        return $this->where('featured', 1)
            ->where('status', 'available')
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    /**
     * Get properties with pagination.
     *
     * @param int $perPage
     * @return array
     */
    public function getPaginated(int $perPage = 12): array
    {
        return $this->where('status', 'available')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Search properties by keyword.
     *
     * @param string $keyword
     * @return array
     */
    public function search(string $keyword): array
    {
        return $this->like('title', $keyword)
            ->orLike('description', $keyword)
            ->orLike('city', $keyword)
            ->orLike('address', $keyword)
            ->where('status', 'available')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Generate a unique slug for a property.
     *
     * @param string $title
     * @param int|null $excludeId Exclude this ID when checking uniqueness
     * @return string
     */
    public function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = mb_strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $builder = $this->builder()->where('slug', $slug);
            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId);
            }
            if ($builder->countAllResults() === 0) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
