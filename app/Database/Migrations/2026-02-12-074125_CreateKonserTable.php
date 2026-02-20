<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKonserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name_konser' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'jumlah_bed' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('konser');
    }


    public function down()
    {
        //
    }
}
