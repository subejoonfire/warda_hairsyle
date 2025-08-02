<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateQuickMessagesTable extends Migration
{
    public function up()
    {
        // Add new columns to quick_messages table
        $this->forge->addColumn('quick_messages', [
            'response_type' => [
                'type' => 'ENUM',
                'constraint' => ['static', 'dynamic', 'template'],
                'default' => 'static',
                'after' => 'description'
            ],
            'response_source' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'response_type'
            ],
            'response_template' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'response_source'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'is_active'
            ]
        ]);

        // Update existing records with default values
        $this->db->query("UPDATE quick_messages SET response_type = 'static', sort_order = id WHERE response_type IS NULL");
    }

    public function down()
    {
        // Remove added columns
        $this->forge->dropColumn('quick_messages', ['response_type', 'response_source', 'response_template', 'sort_order']);
    }
}