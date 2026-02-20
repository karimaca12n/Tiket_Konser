<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username'   => 'user1',
                'email'      => 'user1@gmail.com',
                'password'   => password_hash('123456', PASSWORD_DEFAULT),
                'nama'       => 'User Satu',
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'user2',
                'email'      => 'user2@gmail.com',
                'password'   => password_hash('123456', PASSWORD_DEFAULT),
                'nama'       => 'User Dua',
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
