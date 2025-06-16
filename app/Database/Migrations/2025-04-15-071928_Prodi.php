<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdiTableBaru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prodi' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100
            ],
        ]);

        $this->forge->addKey('id_prodi', true);
        $this->forge->createTable('prodi', true);
    }

    public function down()
    {
        $this->forge->dropTable('prodi');
    }
}
