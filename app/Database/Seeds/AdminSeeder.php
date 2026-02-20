<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'username' => 'admin',
            'email'    => 'admin@konser.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'nama'     => 'Administrator',
            'role'     => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
