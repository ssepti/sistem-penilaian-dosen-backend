<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdMatkulToPenilaian extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian', [
            'id_matkul' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true, // ubah ke false kalau wajib
            ],
        ]);

        // Foreign key ke tabel mata_kuliah
        $this->db->query('ALTER TABLE penilaian ADD CONSTRAINT fk_id_matkul FOREIGN KEY (id_matkul) REFERENCES mata_kuliah(id_matkul)');
    }

    public function down()
    {
        // Hapus foreign key dulu, baru kolomnya
        $this->db->query('ALTER TABLE penilaian DROP FOREIGN KEY fk_id_matkul');
        $this->forge->dropColumn('penilaian', 'id_matkul');
    }
}
