<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'admin_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'sender_type' => [
                'type' => 'ENUM',
                'constraint' => ['customer', 'admin'],
                'default' => 'customer',
            ],
            'is_read' => [
                'type' => 'BOOLEAN',
                'default' => false,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('admin_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('chats');
    }

    public function down()
    {
        $this->forge->dropTable('chats');
    }
}