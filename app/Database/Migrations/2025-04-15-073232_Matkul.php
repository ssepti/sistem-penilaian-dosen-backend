<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMataKuliahTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_matkul' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_matkul' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_prodi' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'sks' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint' => 1,
            ],
        ]);

        $this->forge->addKey('id_matkul', true); // Primary key
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mata_kuliah');
    }

    public function down()
    {
        $this->forge->dropTable('mata_kuliah');
    }
}
