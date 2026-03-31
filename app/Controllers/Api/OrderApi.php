<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class OrderApi extends ResourceController
{
    protected $modelName = 'App\Models\PemesananModel';
    protected $format    = 'json';

    // GET /api/orders (Semua Pesanan - Untuk Admin)
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemesanan');
        $builder->select('pemesanan.*, konser.name_konser, users.nama as nama_user');
        $builder->join('konser', 'konser.id = pemesanan.konser_id');
        $builder->join('users', 'users.id = pemesanan.user_id');
        $builder->orderBy('pemesanan.id', 'DESC');
        
        return $this->respond($builder->get()->getResult());
    }

    // GET /api/orders/user/ID (Pesanan per User)
    public function userOrders($userId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemesanan');
        $builder->select('pemesanan.*, konser.name_konser, konser.gambar, konser.lokasi, konser.tanggal');
        $builder->join('konser', 'konser.id = pemesanan.konser_id');
        $builder->where('pemesanan.user_id', $userId);
        $builder->orderBy('pemesanan.id', 'DESC');

        return $this->respond($builder->get()->getResult());
    }

    // GET /api/orders/cetak/ID (Detail Tiket)
    public function cetak($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemesanan');
        $builder->select('pemesanan.*, konser.name_konser, konser.lokasi, konser.tanggal, users.nama as nama_user');
        $builder->join('konser', 'konser.id = pemesanan.konser_id');
        $builder->join('users', 'users.id = pemesanan.user_id');
        $builder->where('pemesanan.id', $id);
        
        $data = $builder->get()->getRow();

        if (!$data) {
            return $this->failNotFound('Pesanan tidak ditemukan');
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Tiket berhasil dicetak',
            'data'    => [
                'nama_user'    => $data->nama_user,
                'name_konser'  => $data->name_konser,
                'lokasi'       => $data->lokasi,
                'tanggal'      => $data->tanggal,
                'jumlah_tiket' => $data->jumlah_tiket,
                'total_harga'  => $data->total_harga
            ]
        ]);
    }

public function downloadTicket($id = null)
{
    // Menggunakan Query Builder langsung di Controller agar pasti ter-join
    $db = \Config\Database::connect();
    $builder = $db->table('pemesanan');
    
    // Pilih (select) kolom yang dibutuhkan, pastikan users.nama ikut terpanggil
    $builder->select('pemesanan.*, konser.name_konser, konser.lokasi, konser.tanggal, users.nama');
    $builder->join('konser', 'konser.id = pemesanan.konser_id');
    $builder->join('users', 'users.id = pemesanan.user_id');
    $builder->where('pemesanan.id', $id);
    
    // Gunakan getRowArray() karena file Tiket_Pdf.php memanggil data sebagai array ($p['nama'])
    $pesanan = $builder->get()->getRowArray();

    // Validasi pesanan
    if (!$pesanan || $pesanan['status'] !== 'approved') {
        return "Tiket tidak ditemukan atau belum di-approve.";
    }

    // PANGGIL VIEW PDF
    $html = view('pemesanan/Tiket_Pdf', ['p' => $pesanan]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Kirim sebagai PDF ke browser
    return $this->response->setHeader('Content-Type', 'application/pdf')
                          ->setBody($dompdf->output())
                          ->send();
}

    // POST /api/orders (Tambah Pesanan Baru)
    public function create()
    {
        $data = [
            'user_id'      => $this->request->getVar('user_id'),
            'konser_id'    => $this->request->getVar('konser_id'),
            'jumlah_tiket' => $this->request->getVar('jumlah_tiket'),
            'total_harga'  => $this->request->getVar('total_harga'),
            'status'       => 'pending',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Pesanan berhasil dibuat']);
        }
        return $this->fail('Gagal membuat pesanan');
    }

    // PATCH /api/orders/ID (Update Status)
    public function update($id = null)
    {
        $status = $this->request->getVar('status');
        if ($this->model->update($id, ['status' => $status])) {
            return $this->respond(['message' => 'Status updated']);
        }
        return $this->fail('Update failed');
    }
}