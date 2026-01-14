<?php

namespace App\Modules\_Template\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * CreateTemplates Migration
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Namespace: 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 2. Class: 'CreateTemplates' -> 'Create{TableName}'
 * 3. Tablo adi: 'templates' -> '{tablename}'
 * 4. Alanlar: Kendi alanlarinizi ekleyin/cikartin
 * 5. Dosya adi: Tarih ve tablo adini guncelleyin
 */
class CreateTemplates extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // Primary Key
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            // Temel alanlar
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Durum alanlari
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'draft',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'sort_order' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],

            // Zaman damgalari
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Indexler
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->addKey('status');
        $this->forge->addKey('is_active');

        $this->forge->createTable('templates');
    }

    public function down()
    {
        $this->forge->dropTable('templates');
    }
}
