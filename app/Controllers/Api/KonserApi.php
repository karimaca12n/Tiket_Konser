<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class KonserApi extends ResourceController
{
    protected $modelName = 'App\Models\KonserModel';
    protected $format    = 'json';

    // GET: api/konser
    public function index()
    {
        $data = $this->model->findAll();

        return $this->respond([
            'status' => 200,
            'data'   => $data
        ]);
    }

    // GET: api/konser/1
    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound('Data konser tidak ditemukan');
        }

        return $this->respond([
            'status' => 200,
            'data'   => $data
        ]);
    }

    // POST: api/konser
    public function create()
    {
        $rules = [
            'name_konser' => 'required',
            'lokasi'      => 'required',
            'tanggal'     => 'required',
            'harga'       => 'required',
            'jumlah_bed'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaGambar = $file->getRandomName();
            $file->move('uploads/gambar', $namaGambar);
        }

        $this->model->save([
            'name_konser' => $this->request->getVar('name_konser'),
            'lokasi'      => $this->request->getVar('lokasi'),
            'tanggal'     => $this->request->getVar('tanggal'),
            'harga'       => $this->request->getVar('harga'),
            'jumlah_bed'  => $this->request->getVar('jumlah_bed'),
            'gambar'      => $namaGambar
        ]);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Konser berhasil ditambahkan'
        ]);
    }

    // PUT: api/konser/1
    public function update($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound('Data konser tidak ditemukan');
        }

        $file = $this->request->getFile('gambar');
        $namaGambar = $data['gambar']; // pakai gambar lama

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaGambar = $file->getRandomName();
            $file->move('uploads/gambar', $namaGambar);
        }

        $this->model->update($id, [
            'name_konser' => $this->request->getVar('name_konser'),
            'lokasi'      => $this->request->getVar('lokasi'),
            'tanggal'     => $this->request->getVar('tanggal'),
            'harga'       => $this->request->getVar('harga'),
            'jumlah_bed'  => $this->request->getVar('jumlah_bed'),
            'gambar'      => $namaGambar
        ]);

        return $this->respond([
            'status'  => 200,
            'message' => 'Konser berhasil diupdate'
        ]);
    }

    // DELETE: api/konser/1
    public function delete($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound('Data konser tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Konser berhasil dihapus'
        ]);
    }
}
