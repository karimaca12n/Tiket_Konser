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
        $this->konserModel = new KonserModel();
        $this->pemesananModel = new PemesananModel();
    }

    // Gate khusus admin 
    private function auth()
    {
        if (session()->get('role') != 'admin') {
            redirect()->to('/konser')->send();
            exit;
        }
    }

    // DASHBOARD ADMIN
    public function index()
    {
        $this->auth();
        $data['konser'] = $this->konserModel->findAll();
        return view('admin/index', $data);
    }

    // RIWAYAT PENJUALAN
    public function riwayat()
    {
        $this->auth();

        $data['pesanan'] = $this->pemesananModel->getAllWithUserAndKonser();
        $data['total_omzet'] = $this->pemesananModel->getTotalOmzet();
        $data['tiket_per_konser'] = $this->pemesananModel->getTiketPerKonser();

        return view('admin/riwayat', $data);
    }

    // CRUD KONSER 
    public function create()
    {
        $this->auth();
        return view('admin/create');
    }

    public function store()
    {
        $this->auth();

        // Ambil file gambar dari form
        $fileGambar = $this->request->getFile('gambar');

        $namaFile = null;

        // Jika ada file diupload
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            
            // Generate nama random biar tidak bentrok
            $namaFile = $fileGambar->getRandomName();

            // Pindahkan ke public/uploads/gambar
            $fileGambar->move('uploads/gambar', $namaFile);
        }

        $this->konserModel->save([
            'name_konser' => $this->request->getPost('name_konser'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'harga'       => $this->request->getPost('harga'),
            'jumlah_bed'  => $this->request->getPost('jumlah_bed'),
            'gambar'      => $namaFile, // INI YANG BARU
        ]);

        return redirect()->to('/admin')->with('success', 'Konser berhasil ditambahkan!');
}


    public function edit($id)
    {
        $this->auth();
        $data['konser'] = $this->konserModel->find($id);
        return view('admin/edit', $data);
    }

public function update($id)
{
    $this->auth();

    // Ambil data konser lama
    $konserLama = $this->konserModel->find($id);

    // Ambil file gambar dari form
    $fileGambar = $this->request->getFile('gambar');

    // Default pakai gambar lama
    $namaFile = $konserLama['gambar'];

    // Jika admin upload gambar baru
    if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {

        // Generate nama random
        $namaFileBaru = $fileGambar->getRandomName();

        // Pindahkan ke folder public/uploads/gambar
        $fileGambar->move('uploads/gambar', $namaFileBaru);

        // Hapus gambar lama (jika ada)
        if (!empty($konserLama['gambar']) && file_exists('uploads/gambar/' . $konserLama['gambar'])) {
            unlink('uploads/gambar/' . $konserLama['gambar']);
        }

        // Gunakan gambar baru
        $namaFile = $namaFileBaru;
    }

    // Update data ke database
    $this->konserModel->update($id, [
        'name_konser' => $this->request->getPost('name_konser'),
        'lokasi'      => $this->request->getPost('lokasi'),
        'tanggal'     => $this->request->getPost('tanggal'),
        'harga'       => $this->request->getPost('harga'),
        'jumlah_bed'  => $this->request->getPost('jumlah_bed'),
        'gambar'      => $namaFile, // penting!
    ]);

    return redirect()->to('/admin')->with('success', 'Konser berhasil diupdate!');
}

    public function delete($id)
    {
        $this->auth();

        $db = \Config\Database::connect();
        $cek = $db->table('pemesanan')
                ->where('konser_id', $id)
                ->countAllResults();

        if ($cek > 0) {
            return redirect()->to('/admin')
                ->with('error', 'Konser tidak bisa dihapus karena sudah ada pemesanan.');
        }

        $this->konserModel->delete($id);
        return redirect()->to('/admin');
    }
}
