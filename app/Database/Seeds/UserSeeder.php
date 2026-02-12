<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@tiketkonser.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'nama'       => 'Administrator',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'user',
                'email'      => 'user@tiketkonser.com',
                'password'   => password_hash('user123', PASSWORD_DEFAULT),
                'nama'       => 'User Demo',
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
