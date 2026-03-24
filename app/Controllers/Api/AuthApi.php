<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class AuthApi extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        // 1. Ambil data yang dikirim oleh Flutter
        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // 2. Hubungkan ke database
        $db      = \Config\Database::connect();
        $builder = $db->table('users');

        // 3. Cari user berdasarkan email
        $user = $builder->where('email', $email)->get()->getRow();

        // 4. Cek apakah user ditemukan
        if ($user) {
            // 5. Verifikasi password (mencocokkan password input dengan hash di DB)
            if (password_verify($password, $user->password)) {
                
                // LOGIN BERHASIL
                return $this->respond([
                    'status' => 200,
                    'message' => 'Login berhasil',
                    'id'    => $user->id,
                    'name'  => $user->nama,   // Mengambil kolom 'nama' dari DB
                    'email' => $user->email,
                    'role'  => $user->role,   // Mengambil 'admin' atau 'user' dari DB
                    'token' => 'token_' . bin2hex(random_bytes(16)) // Simulasi token
                ], 200);
            }
        }

        // 6. Jika gagal (user tidak ada atau password salah)
        return $this->failUnauthorized('Email atau Password salah');
    }

    public function register()
    {
        // 1. Hubungkan ke database
        $db = \Config\Database::connect();
        $builder = $db->table('users');

        // 2. Ambil data dari request Flutter
        $data = [
            'nama'       => $this->request->getVar('nama'),
            'username'   => $this->request->getVar('username'),
            'email'      => $this->request->getVar('email'),
            // Hash password agar aman
            'password'   => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'       => $this->request->getVar('role') ?? 'user',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // 3. Eksekusi simpan ke database
        if ($builder->insert($data)) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'User registered successfully',
                'data'    => [
                    'nama'  => $data['nama'],
                    'email' => $data['email']
                ]
            ]);
        } else {
            return $this->fail('Gagal melakukan registrasi ke database');
        }
    }

    // Endpoint tambahan untuk admin agar bisa melihat semua user
    public function allUsers()
{
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('id, nama as name, email, role'); // Samakan nama field agar Flutter tidak bingung
        return $this->respond($builder->get()->getResult());
    }
}