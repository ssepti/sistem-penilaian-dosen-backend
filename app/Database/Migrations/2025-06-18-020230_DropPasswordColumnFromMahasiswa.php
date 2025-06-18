<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropPasswordColumnFromMahasiswa extends Migration
{
    public function up()
    {
        // Drop kolom password
        $this->forge->dropColumn('mahasiswa', 'password');
    }

    public function down()
    {
        // Kalau mau rollback, tambahkan kembali kolom password
        $this->forge->addColumn('mahasiswa', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // atau false tergantung kebutuhan
            ],
        ]);
    }
}
