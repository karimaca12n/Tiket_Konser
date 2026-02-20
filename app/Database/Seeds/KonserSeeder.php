<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KonserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name_konser' => 'Java Jazz Festival',
                'lokasi'      => 'Jakarta',
                'tanggal'     => '2026-05-10',
                'harga'       => 500000,
                'jumlah_bed'  => 200,
            ],
            [
                'name_konser' => 'We The Fest',
                'lokasi'      => 'Jakarta',
                'tanggal'     => '2026-07-20',
                'harga'       => 650000,
                'jumlah_bed'  => 300,
            ],
            [
                'name_konser' => 'Soundrenaline',
                'lokasi'      => 'Bali',
                'tanggal'     => '2026-08-15',
                'harga'       => 750000,
                'jumlah_bed'  => 400,
            ],
        ];

        $this->db->table('konser')->insertBatch($data);
    }
}
