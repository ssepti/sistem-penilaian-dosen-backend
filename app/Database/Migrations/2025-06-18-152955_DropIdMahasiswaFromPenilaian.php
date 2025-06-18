<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropIdMahasiswaFromPenilaian extends Migration
{
    public function up()
    {
        // Hapus foreign key dulu sebelum hapus kolom
        $this->db->query('ALTER TABLE penilaian DROP FOREIGN KEY fk_id_mhs');
        $this->forge->dropColumn('penilaian', 'id_mhs');
    }

    public function down()
    {
        // Balikkan kalau mau undo: tambahkan lagi kolom dan constraint
        $this->forge->addColumn('penilaian', [
            'id_mhs' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->db->query('ALTER TABLE penilaian ADD CONSTRAINT fk_id_mhs FOREIGN KEY (id_mhs) REFERENCES mahasiswa(id_mhs)');
    }
}
