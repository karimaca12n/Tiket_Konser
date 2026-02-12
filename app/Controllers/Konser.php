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
}
