<?php

namespace App\Modules\_Template\Models;

use CodeIgniter\Model;
use App\Modules\_Template\Entities\Template;

/**
 * TemplateModel
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Namespace: 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 2. Class: 'TemplateModel' -> '{ModuleName}Model'
 * 3. $table: 'templates' -> '{tablename}'
 * 4. $returnType: Template::class -> {ModuleName}::class
 * 5. $allowedFields: Kendi alanlarinizi ekleyin
 * 6. $validationRules: Kendi kurallarinizi ekleyin
 */
class TemplateModel extends Model
{
    protected $table = 'templates';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Template::class;
    protected $useSoftDeletes = false;

    /**
     * Toplu atamaya izin verilen alanlar.
     * ONEMLI: Kendi alanlarinizi buraya ekleyin.
     */
    protected $allowedFields = [
        'title',
        'slug',
        'description',
        'status',
        'is_active',
        'sort_order',
        // Kendi alanlarinizi ekleyin...
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    /**
     * Validation kurallari.
     * ONEMLI: Kendi kurallarinizi buraya ekleyin.
     */
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|min_length[10]',
        'status' => 'required|in_list[active,inactive,draft]',
        'is_active' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Baslik zorunludur.',
            'min_length' => 'Baslik en az 3 karakter olmalidir.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Slug'a gore kayit bul.
     */
    public function findBySlug(string $slug): ?Template
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Aktif kayitlari getir.
     */
    public function getActive(): array
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Duruma gore kayitlari getir.
     */
    public function getByStatus(string $status): array
    {
        return $this->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Sayfalamali liste.
     */
    public function getPaginated(int $perPage = 12): array
    {
        return $this->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Arama yap.
     */
    public function search(string $keyword): array
    {
        return $this->like('title', $keyword)
            ->orLike('description', $keyword)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Benzersiz slug uret.
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
