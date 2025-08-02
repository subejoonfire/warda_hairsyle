<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['customer', 'admin'],
                'default' => 'customer',
            ],
            'is_verified' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'verification_code' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => true,
            ],
            'verification_expires' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'profile_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('whatsapp', 'unique_whatsapp');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}