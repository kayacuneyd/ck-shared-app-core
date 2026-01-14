<?php

namespace App\Modules\Property\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * PropertySeeder
 *
 * Seeds the properties table with sample real estate listings
 * for testing and demonstration purposes.
 */
class PropertySeeder extends Seeder
{
    public function run()
    {
        $properties = [
            [
                'title' => 'Moderne Stadtwohnung in Stuttgart',
                'slug' => 'moderne-stadtwohnung-stuttgart',
                'description' => 'Stilvolle 3-Zimmer-Wohnung im Herzen von Stuttgart. Hochwertige Ausstattung mit Einbauküche, Parkett und Balkon. Perfekte Anbindung an öffentliche Verkehrsmittel.',
                'price' => 385000.00,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area_sqm' => 85.50,
                'address' => 'Königstraße 45',
                'city' => 'Stuttgart',
                'zip_code' => '70173',
                'status' => 'available',
                'featured' => 1,
                'images' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Familienhaus mit Garten in Tübingen',
                'slug' => 'familienhaus-garten-tuebingen',
                'description' => 'Geräumiges Einfamilienhaus mit großem Garten in ruhiger Wohnlage. 5 Zimmer, 2 Bäder, Garage und Keller. Ideal für Familien.',
                'price' => 625000.00,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'area_sqm' => 165.00,
                'address' => 'Am Sonnenhang 12',
                'city' => 'Tübingen',
                'zip_code' => '72076',
                'status' => 'available',
                'featured' => 1,
                'images' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Penthouse mit Dachterrasse',
                'slug' => 'penthouse-dachterrasse',
                'description' => 'Exklusives Penthouse mit 80m² Dachterrasse und atemberaubendem Blick über die Stadt. Luxuriöse Ausstattung, Fußbodenheizung, Smart Home.',
                'price' => 890000.00,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area_sqm' => 145.00,
                'address' => 'Panoramaweg 8',
                'city' => 'Stuttgart',
                'zip_code' => '70190',
                'status' => 'available',
                'featured' => 1,
                'images' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Gemütliche Altbauwohnung',
                'slug' => 'gemuetliche-altbauwohnung',
                'description' => 'Charmante Altbauwohnung mit hohen Decken und Stuck. 2 Zimmer, renoviertes Bad, ruhige Hinterhoflage mit Blick ins Grüne.',
                'price' => 245000.00,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'area_sqm' => 62.00,
                'address' => 'Heustraße 23',
                'city' => 'Stuttgart',
                'zip_code' => '70180',
                'status' => 'available',
                'featured' => 0,
                'images' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Neubau-Reihenhaus in Esslingen',
                'slug' => 'neubau-reihenhaus-esslingen',
                'description' => 'Modernes Reihenhaus aus 2024. Energieeffizient (KfW 40), mit Wärmepumpe und Photovoltaik. 4 Zimmer auf 3 Etagen.',
                'price' => 520000.00,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area_sqm' => 130.00,
                'address' => 'Neckarstraße 88',
                'city' => 'Esslingen',
                'zip_code' => '73728',
                'status' => 'reserved',
                'featured' => 0,
                'images' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Luxusvilla am Bodensee',
                'slug' => 'luxusvilla-bodensee',
                'description' => 'Repräsentative Villa mit direktem Seezugang. 8 Zimmer, Pool, Wellnessbereich, eigener Bootsanleger. Einmaliges Anwesen.',
                'price' => 2450000.00,
                'bedrooms' => 6,
                'bathrooms' => 4,
                'area_sqm' => 420.00,
                'address' => 'Seepromenade 1',
                'city' => 'Konstanz',
                'zip_code' => '78462',
                'status' => 'available',
                'featured' => 1,
                'images' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($properties as $property) {
            $this->db->table('properties')->insert($property);
        }
    }
}
