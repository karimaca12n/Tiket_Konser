<?php
namespace App\Controllers;
use App\Models\KonserModel;

class Konser extends BaseController {
    public function index() {
        $model = new KonserModel();
        $data['konser'] = $model->findAll();
        return view('konser/index',$data);
    }

    public function detail($id) {
        $model = new KonserModel();
        $data['konser'] = $model->find($id);
        return view('konser/detail',$data);
    }

    public function image($filename)
{
    $path = FCPATH . 'uploads/gambar/' . $filename;

    if (!file_exists($path)) {
        return $this->response->setStatusCode(404);
    }

    return $this->response
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type')
        ->setContentType(mime_content_type($path))
        ->setBody(file_get_contents($path));
}
}
