<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToMahasiswa extends Migration
{
    public function up()
    {
        // 1. Tambahkan kolom email ke tabel mahasiswa
        $this->forge->addColumn('mahasiswa', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // boleh null untuk awal-awal
                'after'      => 'nama_mhs' // opsional, biar posisinya rapi
            ]
        ]);

        // 2. Tambahkan foreign key ke tabel users.email
        $this->forge->addForeignKey('email', 'users', 'email', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        // Hapus foreign key dulu baru kolom
        $this->forge->dropForeignKey('mahasiswa', 'mahasiswa_email_foreign');
        $this->forge->dropColumn('mahasiswa', 'email');
    }
}
