<?php
namespace App\Controllers;

use App\Models\KonserModel;
use App\Models\PemesananModel;

class Pemesanan extends BaseController {

    // =======================
    // USER - FORM PESAN
    // =======================
    public function form($id) {
        $konserModel = new KonserModel();
        $data['konser'] = $konserModel->find($id);
        return view('pemesanan/form', $data);
    }

    // =======================
    // USER - SUBMIT PESANAN
    // =======================
    public function submit() {
        $pemesananModel = new PemesananModel();
        $konserModel = new KonserModel();

        $konser_id = $this->request->getPost('konser_id');
        $jumlah = (int)$this->request->getPost('jumlah');

        $konser = $konserModel->find($konser_id);
        $total = $jumlah * $konser['harga'];

        $pemesananModel->insert([
            'user_id' => session()->get('user_id'),
            'konser_id' => $konser_id,
            'jumlah_tiket' => $jumlah,
            'total_harga' => $total,
            'status' => 'pending'
        ]);

        // kurangi stok
        $konserModel->update($konser_id, [
            'jumlah_bed' => $konser['jumlah_bed'] - $jumlah
        ]);

        return redirect()->to('/pesanan-saya');
    }

    // =======================
    // USER - RIWAYAT PESANAN
    // =======================
    public function riwayat() {
        $model = new PemesananModel();
        $data['pesanan'] = $model->getRiwayat(session()->get('user_id'));
        return view('pemesanan/riwayat', $data);
    }

    // =======================
    // USER - HALAMAN PAYMENT
    // =======================
    public function payment($id)
    {
        $model = new PemesananModel();

        $pesanan = $model
            ->select('pemesanan.*, konser.name_konser')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.id', $id)
            ->first();

        // keamanan: hanya pemilik pesanan
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
        $model = new PemesananModel();

        $model->update($id, [
            'status' => 'paid'
        ]);

        return redirect()->to('/pemesanan/tiket/' . $id);
    }

    // =======================
    // USER - TIKET (PDF NANTI)
    // =======================
    public function tiket($id)
    {
        $model = new PemesananModel();

        $pesanan = $model
            ->select('pemesanan.*, konser.name_konser')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.id', $id)
            ->first();

        return view('pemesanan/tiket', [
            'pesanan' => $pesanan
        ]);
    }
}
