<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemesananTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'konser_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jumlah_tiket' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'total_harga' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid', 'approved', 'cancelled'],
                'default' => 'pending',
            ],
            'approved_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,                
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('konser_id', 'konser', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pemesanan');
    }


    public function down()
    {
        $this->forge->dropTable('pemesanan');
    }
}
