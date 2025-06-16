<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_admin' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,  // Username harus unik
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,  // Panjang untuk menyimpan hash password
            ],
        ]);

        $this->forge->addKey('id_admin', true); // Primary key
        $this->forge->createTable('admin');
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}
