<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGambarToKonser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('konser', [
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'harga' // sesuaikan dengan kolom terakhir kamu
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('konser', 'gambar');
    }
}
