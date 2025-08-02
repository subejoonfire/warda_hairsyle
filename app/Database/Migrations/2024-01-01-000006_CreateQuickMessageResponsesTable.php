<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuickMessageResponsesTable extends Migration
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
            'quick_message_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'response_text' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('quick_message_id', 'quick_messages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quick_message_responses');
    }

    public function down()
    {
        $this->forge->dropTable('quick_message_responses');
    }
}