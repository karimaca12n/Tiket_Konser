<?php
namespace App\Controllers;

use App\Models\KonserModel;
use App\Models\PemesananModel;

class Pemesanan extends BaseController {

    // =======================
    // USER - FORM PESAN
    // =======================
    public function form($id) {

        // CEK LOGIN (GUEST TIDAK BOLEH PESAN)
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu untuk memesan tiket');
        }

        $konserModel = new KonserModel();
        $data['konser'] = $konserModel->find($id);

        // jika konser tidak ditemukan
        if (!$data['konser']) {
            return redirect()->to('/konser');
        }

        return view('pemesanan/form', $data);
    }

    // =======================
    // USER - SUBMIT PESANAN
    // =======================
    public function submit() {

        // CEK LOGIN
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $pemesananModel = new PemesananModel();
        $konserModel = new KonserModel();

        $konser_id = $this->request->getPost('konser_id');
        $jumlah = (int)$this->request->getPost('jumlah');

        $konser = $konserModel->find($konser_id);

        // validasi konser
        if (!$konser) {
            return redirect()->to('/konser');
        }

        $total = $jumlah * $konser['harga'];

        $pemesananModel->insert([
            'user_id'      => session()->get('user_id'),
            'konser_id'    => $konser_id,
            'jumlah_tiket' => $jumlah,
            'total_harga'  => $total,
            'status'       => 'pending'
        ]);

        // kurangi stok (sesuai field kamu: jumlah_bed)
        $konserModel->update($konser_id, [
            'jumlah_bed' => $konser['jumlah_bed'] - $jumlah
        ]);

        return redirect()->to('/pesanan-saya');
    }

    // =======================
    // USER - RIWAYAT PESANAN (PER AKUN)
    // =======================
    public function riwayat() {

        // HARUS LOGIN
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();
        $data['pesanan'] = $model->getRiwayat(session()->get('user_id'));

        return view('pemesanan/riwayat', $data);
    }

    // =======================
    // USER - HALAMAN PAYMENT
    // =======================
    public function payment($id)
    {
        // HARUS LOGIN
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();

        $pesanan = $model
            ->select('pemesanan.*, konser.name_konser')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.id', $id)
            ->first();

        // jika pesanan tidak ada
        if (!$pesanan) {
            return redirect()->to('/pesanan-saya');
        }

        // keamanan: hanya pemilik pesanan yang bisa akses
        if ($pesanan['user_id'] != session()->get('user_id')) {
            return redirect()->to('/pesanan-saya');
        }

        return view('pemesanan/payment', [
            'pesanan' => $pesanan
        ]);
    }

    // =======================
    // USER - PROSES PAYMENT
    // =======================
    public function process($id)
    {
        // HARUS LOGIN
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();

        $pesanan = $model->find($id);

        // validasi pesanan
        if (!$pesanan) {
            return redirect()->to('/pesanan-saya');
        }

        // keamanan: hanya pemilik pesanan
        if ($pesanan['user_id'] != session()->get('user_id')) {
            return redirect()->to('/pesanan-saya');
        }

        $model->update($id, [
            'status' => 'paid'
        ]);

        return redirect()->to('/pemesanan/tiket/' . $id);
    }

    // =======================
    // USER - TIKET
    // =======================
    public function tiket($id)
    {
        // HARUS LOGIN
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();

        $pesanan = $model
            ->select('pemesanan.*, konser.name_konser')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.id', $id)
            ->first();

        // jika tidak ada
        if (!$pesanan) {
            return redirect()->to('/pesanan-saya');
        }

        // keamanan: hanya pemilik tiket
        if ($pesanan['user_id'] != session()->get('user_id')) {
            return redirect()->to('/pesanan-saya');
        }

        return view('pemesanan/tiket', [
            'pesanan' => $pesanan
        ]);
    }
}
