<?php

namespace App\Modules\Property\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Creates the `properties` table.
 *
 * This migration creates the properties table for storing
 * real estate listings. All field types are SQLite-compatible.
 */
class CreateProperties extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
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
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0,
            ],
            'bedrooms' => [
                'type' => 'INTEGER',
                'constraint' => 3,
                'default' => 0,
                'null' => true,
            ],
            'bathrooms' => [
                'type' => 'INTEGER',
                'constraint' => 3,
                'default' => 0,
                'null' => true,
            ],
            'area_sqm' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'available',
            ],
            'featured' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'images' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => '[]',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->addKey('status');
        $this->forge->addKey('city');
        $this->forge->createTable('properties');
    }

    public function down()
    {
        $this->forge->dropTable('properties');
    }
}
