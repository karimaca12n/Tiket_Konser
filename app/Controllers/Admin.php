<?php

namespace App\Controllers;

use App\Models\KonserModel;
use App\Models\PemesananModel;

class Admin extends BaseController
{
    protected $konserModel;
    protected $pemesananModel;

    public function __construct()
    {
        $this->konserModel     = new KonserModel();
        $this->pemesananModel = new PemesananModel();
    }

    // =======================
    // GATE ADMIN
    // =======================
    private function auth()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/konser')->send();
            exit;
        }
    }

    // =======================
    // DASHBOARD
    // =======================
    public function index()
    {
        $this->auth();

        return view('admin/index', [
            'konser' => $this->konserModel->findAll()
        ]);
    }

    // =======================
    // RIWAYAT PENJUALAN
    // =======================
    public function riwayat()
    {
        $this->auth();

        return view('admin/riwayat', [
            'pesanan'          => $this->pemesananModel->getAllWithUserAndKonser(),
            'total_omzet'      => $this->pemesananModel->getTotalOmzet(),
            'tiket_per_konser' => $this->pemesananModel->getTiketPerKonser(),
        ]);
    }

    // =======================
    // CREATE KONSER
    // =======================
    public function create()
    {
        $this->auth();
        return view('admin/create');
    }

    public function store()
    {
        $this->auth();

        $fileGambar = $this->request->getFile('gambar');
        $namaFile   = null;

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaFile = $fileGambar->getRandomName();
            $fileGambar->move('uploads/gambar', $namaFile);
        }

        $this->konserModel->save([
            'name_konser' => $this->request->getPost('name_konser'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'harga'       => $this->request->getPost('harga'),
            'jumlah_bed'  => $this->request->getPost('jumlah_bed'),
            'gambar'      => $namaFile,
        ]);

        return redirect()->to('/admin')
            ->with('success', 'Konser berhasil ditambahkan');
    }

    // =======================
    // EDIT KONSER
    // =======================
    public function edit($id)
    {
        $this->auth();

        return view('admin/edit', [
            'konser' => $this->konserModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->auth();

        $konserLama = $this->konserModel->find($id);
        $fileGambar = $this->request->getFile('gambar');
        $namaFile   = $konserLama['gambar'];

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaBaru = $fileGambar->getRandomName();
            $fileGambar->move('uploads/gambar', $namaBaru);

            if ($konserLama['gambar'] && file_exists('uploads/gambar/' . $konserLama['gambar'])) {
                unlink('uploads/gambar/' . $konserLama['gambar']);
            }

            $namaFile = $namaBaru;
        }

        $this->konserModel->update($id, [
            'name_konser' => $this->request->getPost('name_konser'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'harga'       => $this->request->getPost('harga'),
            'jumlah_bed'  => $this->request->getPost('jumlah_bed'),
            'gambar'      => $namaFile,
        ]);

        return redirect()->to('/admin')
            ->with('success', 'Konser berhasil diupdate');
    }

    // =======================
    // DELETE KONSER
    // =======================
    public function delete($id)
    {
        $this->auth();

        $db  = \Config\Database::connect();
        $cek = $db->table('pemesanan')
                  ->where('konser_id', $id)
                  ->countAllResults();

        if ($cek > 0) {
            return redirect()->to('/admin')
                ->with('error', 'Konser tidak bisa dihapus karena sudah ada pemesanan');
        }

        $this->konserModel->delete($id);

        return redirect()->to('/admin')
            ->with('success', 'Konser berhasil dihapus');
    }

    // =======================
    // APPROVE PESANAN
    // =======================
    public function approve($id)
    {
        $this->auth();

        $pesanan = $this->pemesananModel->find($id);

        if (!$pesanan) {
            return redirect()->to('/admin/riwayat')
                ->with('error', 'Pesanan tidak ditemukan');
        }

        // hanya boleh approve jika status PAID
        if ($pesanan['status'] !== 'paid') {
            return redirect()->to('/admin/riwayat')
                ->with('error', 'Pesanan tidak bisa di-approve');
        }

        $this->pemesananModel->update($id, [
            'status'      => 'approved',
            'approved_at' => date('Y-m-d H:i:s'),
            'approved_by' => session()->get('user_id')
        ]);

        return redirect()->to('/admin/riwayat')
            ->with('success', 'Pesanan berhasil di-approve');
    }

    // =======================
    // REJECT PESANAN
    // =======================
    public function reject($id)
    {
        $this->auth();

        $pesanan = $this->pemesananModel->find($id);

        if (!$pesanan) {
            return redirect()->to('/admin/riwayat')
                ->with('error', 'Pesanan tidak ditemukan');
        }

        // hanya boleh reject jika PAID
        if ($pesanan['status'] !== 'paid') {
            return redirect()->to('/admin/riwayat')
                ->with('error', 'Pesanan tidak bisa ditolak');
        }

        $this->pemesananModel->update($id, [
            'status' => 'pending'
        ]);

        return redirect()->to('/admin/riwayat')
            ->with('success', 'Pesanan berhasil ditolak');
    }
}