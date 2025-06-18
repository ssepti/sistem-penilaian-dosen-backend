<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToDosen extends Migration
{
    public function up()
    {
        // 1. Tambahkan kolom email ke tabel dosen
        $this->forge->addColumn('dosen', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'nama_dosen' // atau sesuaikan dengan struktur tabel kamu
            ]
        ]);

        // 2. Tambahkan foreign key ke tabel users.email
        $this->forge->addForeignKey('email', 'users', 'email', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        // Hapus foreign key dulu baru kolom
        $this->forge->dropForeignKey('dosen', 'dosen_email_foreign');
        $this->forge->dropColumn('dosen', 'email');
    }
}
