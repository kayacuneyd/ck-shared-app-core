<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * AdminSeeder
 *
 * Seeds the database with an initial administrative user.
 * The default password should be changed immediately after deployment.
 */
class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email'      => 'admin@example.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'name'       => 'Administrator',
            'role'       => 'admin',
            'is_active'  => true,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($data);
    }
}
