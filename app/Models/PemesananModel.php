<?php
namespace App\Models;
use CodeIgniter\Model;

class PemesananModel extends Model {

    protected $table = 'pemesanan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'konser_id',
        'jumlah_tiket',
        'total_harga',
        'status'
    ];

    // Riwayat milik user (yang sudah ada)
    public function getRiwayat($user_id) {
        return $this->select('
                pemesanan.*,
                konser.name_konser,
                konser.lokasi,
                konser.tanggal
            ')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.user_id', $user_id)
            ->findAll();
    }

    // ===== UNTUK ADMIN =====
    public function getAllWithUserAndKonser()
    {
        return $this->db->table('pemesanan')
            ->select('pemesanan.*, users.username, konser.name_konser')
            ->join('users', 'users.id = pemesanan.user_id')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->orderBy('pemesanan.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Statistik omzet
    public function getTotalOmzet()
    {
        return $this->selectSum('total_harga')->first()['total_harga'];
    }

    // Statistik tiket per konser
    public function getTiketPerKonser()
    {
        return $this->db->table('pemesanan')
            ->select('konser.name_konser, SUM(pemesanan.jumlah_tiket) as total_tiket')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->groupBy('konser.id')
            ->get()
            ->getResultArray();
    }
}
