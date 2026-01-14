<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * BaseModel
 *
 * Provides common functionality for all models in CK Shared App Core.
 * Implements standard patterns for CRUD, search, filtering, and slug generation.
 *
 * All module models should extend this class instead of CodeIgniter\Model.
 *
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    /**
     * Default sort column.
     *
     * @var string
     */
    protected string $defaultSortColumn = 'created_at';

    /**
     * Default sort direction.
     *
     * @var string
     */
    protected string $defaultSortDirection = 'DESC';

    /**
     * Columns to search in when using search().
     * Override in child classes.
     *
     * @var array<string>
     */
    protected array $searchableColumns = [];

    /**
     * Get all records with optional filtering.
     *
     * @param array $filters Filter conditions [field => value]
     * @param string|null $sortBy Sort column
     * @param string|null $sortDir Sort direction (ASC/DESC)
     * @return array
     */
    public function getAllFiltered(array $filters = [], ?string $sortBy = null, ?string $sortDir = null): array
    {
        $query = $this->builder();

        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                $query->where($field, $value);
            }
        }

        $sortBy ??= $this->defaultSortColumn;
        $sortDir ??= $this->defaultSortDirection;

        return $query->orderBy($sortBy, $sortDir)->get()->getResult($this->returnType);
    }

    /**
     * Get paginated records with optional filtering.
     *
     * @param int $perPage Items per page
     * @param array $filters Filter conditions
     * @return array
     */
    public function getPaginatedFiltered(int $perPage = 12, array $filters = []): array
    {
        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                $this->where($field, $value);
            }
        }

        return $this->orderBy($this->defaultSortColumn, $this->defaultSortDirection)
            ->paginate($perPage);
    }

    /**
     * Search records using multiple columns.
     *
     * @param string $keyword Search keyword
     * @param array|null $columns Columns to search (uses $searchableColumns if null)
     * @return array
     */
    public function search(string $keyword, ?array $columns = null): array
    {
        $columns ??= $this->searchableColumns;

        if (empty($columns)) {
            // Default to allowedFields if no searchable columns defined
            $columns = array_intersect($this->allowedFields, ['title', 'name', 'description', 'content']);
        }

        if (empty($columns)) {
            return [];
        }

        $query = $this->builder();
        $query->groupStart();

        $first = true;
        foreach ($columns as $column) {
            if ($first) {
                $query->like($column, $keyword);
                $first = false;
            } else {
                $query->orLike($column, $keyword);
            }
        }

        $query->groupEnd();

        return $query->orderBy($this->defaultSortColumn, $this->defaultSortDirection)
            ->get()
            ->getResult($this->returnType);
    }

    /**
     * Get records by status.
     *
     * @param string $status Status value
     * @param int|null $limit Result limit
     * @return array
     */
    public function getByStatus(string $status, ?int $limit = null): array
    {
        $query = $this->where('status', $status)
            ->orderBy($this->defaultSortColumn, $this->defaultSortDirection);

        if ($limit) {
            return $query->findAll($limit);
        }

        return $query->findAll();
    }

    /**
     * Get active records (is_active = 1).
     *
     * @param int|null $limit Result limit
     * @return array
     */
    public function getActive(?int $limit = null): array
    {
        $query = $this->where('is_active', 1)
            ->orderBy($this->defaultSortColumn, $this->defaultSortDirection);

        if ($limit) {
            return $query->findAll($limit);
        }

        return $query->findAll();
    }

    /**
     * Find record by slug.
     *
     * @param string $slug URL slug
     * @return object|null
     */
    public function findBySlug(string $slug): ?object
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Generate a unique slug from text.
     *
     * @param string $text Source text (usually title)
     * @param int|null $excludeId Exclude this ID when checking uniqueness
     * @return string Unique slug
     */
    public function generateUniqueSlug(string $text, ?int $excludeId = null): string
    {
        // Convert to lowercase
        $slug = mb_strtolower($text);

        // Replace Turkish/German characters
        $replacements = [
            'ş' => 's', 'ı' => 'i', 'ğ' => 'g', 'ü' => 'u', 'ö' => 'o', 'ç' => 'c',
            'Ş' => 's', 'İ' => 'i', 'Ğ' => 'g', 'Ü' => 'u', 'Ö' => 'o', 'Ç' => 'c',
            'ä' => 'ae', 'ß' => 'ss',
        ];
        $slug = strtr($slug, $replacements);

        // Remove non-alphanumeric characters
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

        // Replace spaces with hyphens
        $slug = preg_replace('/[\s_]+/', '-', $slug);

        // Remove multiple hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens
        $slug = trim($slug, '-');

        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $builder = $this->builder()->where('slug', $slug);

            if ($excludeId !== null) {
                $builder->where($this->primaryKey . ' !=', $excludeId);
            }

            if ($builder->countAllResults() === 0) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Count records with optional filter.
     *
     * @param array $filters Filter conditions
     * @return int
     */
    public function countFiltered(array $filters = []): int
    {
        $query = $this->builder();

        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                $query->where($field, $value);
            }
        }

        return $query->countAllResults();
    }

    /**
     * Check if record exists by field value.
     *
     * @param string $field Field name
     * @param mixed $value Field value
     * @param int|null $excludeId Exclude this ID
     * @return bool
     */
    public function existsByField(string $field, mixed $value, ?int $excludeId = null): bool
    {
        $query = $this->builder()->where($field, $value);

        if ($excludeId !== null) {
            $query->where($this->primaryKey . ' !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }

    /**
     * Get latest records.
     *
     * @param int $limit Number of records
     * @return array
     */
    public function getLatest(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }

    /**
     * Soft toggle a boolean field.
     *
     * @param int $id Record ID
     * @param string $field Boolean field name
     * @return bool Success
     */
    public function toggleField(int $id, string $field): bool
    {
        $record = $this->find($id);

        if ($record === null) {
            return false;
        }

        $currentValue = is_object($record) ? $record->{$field} : $record[$field];
        $newValue = $currentValue ? 0 : 1;

        return $this->update($id, [$field => $newValue]);
    }
}
