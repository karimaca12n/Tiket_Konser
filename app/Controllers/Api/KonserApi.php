<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\KonserModel;

class KonserApi extends ResourceController
{
    protected $modelName = 'App\Models\KonserModel';
    protected $format    = 'json';

    // ============================================================
    // GET ALL KONSER (Untuk Home & Admin List)
    // ============================================================
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }

    // ============================================================
    // GET DETAIL KONSER
    // ============================================================
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Data konser tidak ditemukan');
        }
        return $this->respond($data);
    }

    // ============================================================
    // ADD KONSER (POST) - Sinkron dengan Admin::store
    // ============================================================
    public function create()
    {
        $fileGambar = $this->request->getFile('gambar');
        $namaFile   = null;

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaFile = $fileGambar->getRandomName();
            $fileGambar->move('uploads/gambar', $namaFile);
        }

        $data = [
            'name_konser' => $this->request->getVar('name_konser'),
            'lokasi'      => $this->request->getVar('lokasi'),
            'tanggal'     => $this->request->getVar('tanggal'),
            'harga'       => $this->request->getVar('harga'),
            'jumlah_bed'  => $this->request->getVar('jumlah_bed') ?? 0,
            'gambar'      => $namaFile,
            'description' => $this->request->getVar('description'), // MENANGKAP DESKRIPSI
        ];

        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Konser berhasil ditambahkan melalui API'
            ]);
        }

        return $this->fail('Gagal menambahkan konser melalui API');
    }

    // ============================================================
    // UPDATE KONSER (POST dengan _method=PUT) - Sinkron dengan Admin::update
    // ============================================================
    public function update($id = null)
    {
        $konserLama = $this->model->find($id);
        if (!$konserLama) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaFile   = $konserLama['gambar'];

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaBaru = $fileGambar->getRandomName();
            $fileGambar->move('uploads/gambar', $namaBaru);

            // Hapus gambar lama jika ada
            if ($konserLama['gambar'] && file_exists('uploads/gambar/' . $konserLama['gambar'])) {
                unlink('uploads/gambar/' . $konserLama['gambar']);
            }

            $namaFile = $namaBaru;
        }

        $data = [
            'name_konser' => $this->request->getVar('name_konser'),
            'lokasi'      => $this->request->getVar('lokasi'),
            'tanggal'     => $this->request->getVar('tanggal'),
            'harga'       => $this->request->getVar('harga'),
            'jumlah_bed'  => $this->request->getVar('jumlah_bed') ?? 0,
            'gambar'      => $namaFile,
            'description' => $this->request->getVar('description'), // MENANGKAP DESKRIPSI
        ];

        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Konser berhasil diupdate melalui API'
            ]);
        }

        return $this->fail('Gagal update konser melalui API');
    }

    // ============================================================
    // DELETE KONSER - Sinkron dengan Admin::delete
    // ============================================================
    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        // Hapus file gambar
        if ($data['gambar'] && file_exists('uploads/gambar/' . $data['gambar'])) {
            unlink('uploads/gambar/' . $data['gambar']);
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Konser berhasil dihapus']);
        }

        return $this->fail('Gagal menghapus konser');
    }
}