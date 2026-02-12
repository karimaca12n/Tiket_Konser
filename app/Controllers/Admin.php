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

        $this->konserModel->save([
            'name_konser' => $this->request->getPost('name_konser'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'harga'       => $this->request->getPost('harga'),
            'jumlah_bed'  => $this->request->getPost('jumlah_bed'),
        ]);

        return redirect()->to('/admin');
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

        $this->konserModel->update($id, [
            'name_konser' => $this->request->getPost('name_konser'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'harga'       => $this->request->getPost('harga'),
            'jumlah_bed'  => $this->request->getPost('jumlah_bed'),
        ]);

        return redirect()->to('/admin');
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
