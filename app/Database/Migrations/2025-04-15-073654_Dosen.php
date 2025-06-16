<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDosenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dosen' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_dosen' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nidn' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,  // Nidn sebaiknya unik
            ],
            'id_prodi' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'id_matkul' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id_dosen', true); // Primary key
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_matkul', 'mata_kuliah', 'id_matkul', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dosen');
    }

    public function down()
    {
        $this->forge->dropTable('dosen');
    }
}
