<?php
namespace App\Controllers;

use App\Models\KonserModel;
use App\Models\PemesananModel;
use Dompdf\Dompdf;

class Pemesanan extends BaseController {

    // =======================
    // USER - FORM PESAN
    // =======================
    public function form($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $konserModel = new KonserModel();
        $konser = $konserModel->find($id);

        if (!$konser) {
            return redirect()->to('/konser');
        }

        return view('pemesanan/form', ['konser' => $konser]);
    }

    // =======================
    // USER - SUBMIT PESANAN
    // =======================
    public function submit()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $pemesananModel = new PemesananModel();
        $konserModel = new KonserModel();

        $konser_id = $this->request->getPost('konser_id');
        $jumlah    = (int)$this->request->getPost('jumlah');

        $konser = $konserModel->find($konser_id);
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

        // kurangi stok
        $konserModel->update($konser_id, [
            'jumlah_bed' => $konser['jumlah_bed'] - $jumlah
        ]);

        return redirect()->to('/pesanan-saya');
    }

    // =======================
    // USER - RIWAYAT PESANAN
    // =======================
    public function riwayat()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();
        $pesanan = $model->getRiwayat(session()->get('user_id'));

        return view('pemesanan/riwayat', ['pesanan' => $pesanan]);
    }

    // =======================
    // USER - HALAMAN PAYMENT
    // =======================
    public function payment($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();
        $pesanan = $model
            ->select('pemesanan.*, konser.name_konser')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.id', $id)
            ->first();

        if (!$pesanan || $pesanan['user_id'] != session()->get('user_id')) {
            return redirect()->to('/pesanan-saya');
        }

        return view('pemesanan/payment', ['pesanan' => $pesanan]);
    }

    // =======================
    // USER - PROSES PAYMENT
    // =======================
    public function process($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();
        $pesanan = $model->find($id);

        if (!$pesanan || $pesanan['user_id'] != session()->get('user_id')) {
            return redirect()->to('/pesanan-saya');
        }

        // hanya bisa bayar jika masih pending
        if ($pesanan['status'] !== 'pending') {
            return redirect()->to('/pesanan-saya');
        }

        $model->update($id, [
            'status' => 'paid'
        ]);

        return redirect()->to('/pemesanan/tiket/' . $id);
    }

    // =======================
    // USER - HALAMAN TIKET
    // =======================
    public function tiket($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();
        $pesanan = $model
            ->select('pemesanan.*, konser.name_konser')
            ->join('konser', 'konser.id = pemesanan.konser_id')
            ->where('pemesanan.id', $id)
            ->first();

        if (!$pesanan || $pesanan['user_id'] != session()->get('user_id')) {
            return redirect()->to('/pesanan-saya');
        }

        // hanya block kalau masih pending
        if ($pesanan['status'] === 'pending') {
            return redirect()->to('/pesanan-saya')
                ->with('error', 'Pesanan belum dibayar');
        }

        return view('pemesanan/tiket', ['pesanan' => $pesanan]);
    }

    // =======================
    // USER - CETAK TIKET PDF
    // =======================
    public function cetak($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new PemesananModel();
        $pesanan = $model->getDetailWithKonser($id);

        if (!$pesanan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // HARUS approved
        if ($pesanan['status'] !== 'approved') {
            return redirect()->back()
                ->with('error', 'Tiket belum di-approve admin');
        }

        $html = view('pemesanan/Tiket_Pdf', ['p' => $pesanan]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('tiket-'.$pesanan['id'].'.pdf', ['Attachment' => true]);
    }

    // =======================
    // API - CEK STATUS
    // =======================
    public function api_status($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized'], 401);
        }

        $model = new PemesananModel();
        $pesanan = $model->find($id);

        if (!$pesanan || $pesanan['user_id'] != session()->get('user_id')) {
            return $this->response->setJSON(['error' => 'Forbidden'], 403);
        }

        return $this->response->setJSON([
            'status' => $pesanan['status']
        ]);
    }
}