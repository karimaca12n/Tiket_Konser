<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class AuthApi extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $user    = $builder->where('email', $email)->get()->getRow();

        if ($user && password_verify($password, $user->password)) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Login berhasil',
                'id'      => $user->id,
                'name'    => $user->nama,   
                'email'   => $user->email,
                'role'    => $user->role,
                'avatar'  => $user->avatar, // Tambahkan avatar di sini
                'token'   => 'token_' . bin2hex(random_bytes(16))
            ], 200);
        }

        return $this->failUnauthorized('Email atau Password salah');
    }

    public function register()
    {
        $db = \Config\Database::connect();
        $data = [
            'nama'       => $this->request->getVar('nama'),
            'username'   => $this->request->getVar('username'),
            'email'      => $this->request->getVar('email'),
            'password'   => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'       => $this->request->getVar('role') ?? 'user',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($db->table('users')->insert($data)) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'User registered successfully'
            ]);
        }
        return $this->fail('Gagal melakukan registrasi');
    }

    // FUNGSI UPDATE PROFILE (Wajib untuk fitur Edit Profile Flutter)
    public function update($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', $id)->get()->getRow();

        if (!$user) return $this->failNotFound('User tidak ditemukan');

        $fileAvatar = $this->request->getFile('avatar');
        $namaFile = $user->avatar;

        if ($fileAvatar && $fileAvatar->isValid() && !$fileAvatar->hasMoved()) {
            $namaFile = $fileAvatar->getRandomName();
            $fileAvatar->move('uploads/profile', $namaFile);
            
            // Hapus foto lama jika ada
            if ($user->avatar && file_exists('uploads/profile/' . $user->avatar)) {
                unlink('uploads/profile/' . $user->avatar);
            }
        }

        $data = [
            'nama'   => $this->request->getVar('nama'),
            'avatar' => $namaFile
        ];

        if ($builder->where('id', $id)->update($data)) {
            $updatedUser = $builder->where('id', $id)->get()->getRow();
            return $this->respond([
                'status' => 200,
                'message' => 'Profile updated',
                'user' => [
                    'id'    => $updatedUser->id,
                    'name'  => $updatedUser->nama,
                    'email' => $updatedUser->email,
                    'role'  => $updatedUser->role,
                    'avatar' => $updatedUser->avatar
                ]
            ]);
        }
        return $this->fail('Update failed');
    }

    public function allUsers()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('id, nama as name, email, role, avatar'); 
        return $this->respond($builder->get()->getResult());
    }
}