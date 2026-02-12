<?php

namespace App\Models;

use CodeIgniter\Model;

class KonserModel extends Model
{
    protected $table = 'konser';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name_konser',
        'lokasi',
        'tanggal',
        'harga',
        'jumlah_bed'
    ];
}
