<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePenilaianTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Diisi', 'Sudah Diisi'],
                'default'    => 'Belum Diisi',
                'null'       => false,
                'after'      => 'saran', // optional: biar posisinya setelah kolom 'saran'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penilaian', 'status');
    }
}
