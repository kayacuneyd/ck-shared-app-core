<?php

namespace App\Modules\_Template\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * TemplateSeeder
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Namespace: 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 2. Class: 'TemplateSeeder' -> '{ModuleName}Seeder'
 * 3. Tablo: 'templates' -> '{tablename}'
 * 4. Demo veri: Kendi demo verilerinizi ekleyin
 *
 * Calistirma: php spark db:seed "App\\Modules\\{ModuleName}\\Database\\Seeds\\{ModuleName}Seeder"
 */
class TemplateSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Ornek Kayit 1',
                'slug' => 'ornek-kayit-1',
                'description' => 'Bu bir ornek kayittir. Gercek verilerle degistirin.',
                'status' => 'active',
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Ornek Kayit 2',
                'slug' => 'ornek-kayit-2',
                'description' => 'Bu ikinci ornek kayittir.',
                'status' => 'active',
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Taslak Kayit',
                'slug' => 'taslak-kayit',
                'description' => 'Bu taslak durumunda bir kayittir.',
                'status' => 'draft',
                'is_active' => 0,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('templates')->insertBatch($data);

        echo "TemplateSeeder: " . count($data) . " kayit eklendi.\n";
    }
}
