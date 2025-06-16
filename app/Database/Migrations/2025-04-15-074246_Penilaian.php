<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenilaianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penilaian' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_prodi' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'id_dosen' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'sks' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint' => 1,
            ],
            'aspek_nilai' => [
                'type'       => 'ENUM',
                'constraint' => ['1', '2', '3', '4', '5'],
                'default'    => '1', // Default value jika tidak diisi
            ],
            'saran' => [
                'type'       => 'TEXT',
                'null'       => true, // Kolom saran bisa kosong
            ],
        ]);

        $this->forge->addKey('id_penilaian', true); // Primary key
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_dosen', 'dosen', 'id_dosen', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('penilaian');
    }
}
