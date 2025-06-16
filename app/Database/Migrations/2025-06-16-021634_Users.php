<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,  // Username harus unik
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,  // Panjang untuk menyimpan hash password
            ],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
