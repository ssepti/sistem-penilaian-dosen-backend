<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdMahasiswaToPenilaian extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian', [
            'id_mhs' => [
                'type'       => 'INT',
                'unsigned'   => true, // HARUS cocok dengan mahasiswa.id_mhs
                'null'       => true, // Bisa disesuaikan dengan kebutuhan
            ],
        ]);

        // Tambahkan foreign key dengan nama constraint unik
        $this->db->query('ALTER TABLE penilaian ADD CONSTRAINT fk_id_mhs FOREIGN KEY (id_mhs) REFERENCES mahasiswa(id_mhs)');
    }

    public function down()
    {
        // Hapus foreign key sebelum drop kolom
        $this->db->query('ALTER TABLE penilaian DROP FOREIGN KEY fk_id_mhs');
        $this->forge->dropColumn('penilaian', 'id_mhs');
    }
}
