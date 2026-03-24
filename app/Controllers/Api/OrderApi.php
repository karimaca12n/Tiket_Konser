<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PemesananModel; // Pastikan Anda sudah punya Model untuk tabel pemesanan

class OrderApi extends ResourceController
{
    protected $format = 'json';

    // POST /api/orders (Tambah Pesanan Baru)
    public function create()
    {
        $model = new \App\Models\PemesananModel(); // Sesuaikan nama model Anda

        $data = [
            'user_id'      => $this->request->getVar('user_id'),
            'konser_id'    => $this->request->getVar('konser_id'),
            'jumlah_tiket' => $this->request->getVar('jumlah_tiket'),
            'total_harga'  => $this->request->getVar('total_harga'),
            'status'       => 'pending',
        ];

        if ($model->insert($data)) {
            return $this->respondCreated(['status' => 201, 'message' => 'Pesanan berhasil dibuat']);
        }

        return $this->fail('Gagal membuat pesanan');
    }

    // GET /api/orders (Semua Pesanan - Untuk Admin)
    public function index()
    {
        $db = \Config\Database::connect();
        // Join dengan tabel konser agar admin bisa lihat nama konsernya
        $builder = $db->table('pemesanan');
        $builder->select('pemesanan.*, konser.name_konser, users.nama as nama_user');
        $builder->join('konser', 'konser.id = pemesanan.konser_id');
        $builder->join('users', 'users.id = pemesanan.user_id');
        $query = $builder->get();

        return $this->respond($query->getResult());
    }

    // GET /api/orders/user/1 (Pesanan per User)
    public function userOrders($userId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemesanan');
        $builder->select('pemesanan.*, konser.name_konser, konser.gambar, konser.lokasi, konser.tanggal');
        $builder->join('konser', 'konser.id = pemesanan.konser_id');
        $builder->where('pemesanan.user_id', $userId);
        $query = $builder->get();

        return $this->respond($query->getResult());
    }

    // PATCH /api/orders/1 (Update Status: Approve/Reject)
    public function update($id = null)
    {
        $model = new \App\Models\PemesananModel();
        $status = $this->request->getVar('status');

        if ($model->update($id, ['status' => $status])) {
            return $this->respond(['message' => 'Status pesanan diperbarui']);
        }

        return $this->fail('Gagal memperbarui status');
    }
}