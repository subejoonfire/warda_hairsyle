<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHairstylesTable extends Migration
{
    public function up()
    {
        // Add new columns to hairstyles table
        $this->forge->addColumn('hairstyles', [
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'category'
            ],
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'image'
            ],
            'duration_minutes' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 60,
                'after' => 'price'
            ],
            'difficulty_level' => [
                'type' => 'ENUM',
                'constraint' => ['easy', 'medium', 'hard'],
                'default' => 'medium',
                'after' => 'duration_minutes'
            ],
            'tags' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'difficulty_level'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'is_active'
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');

        // Update existing records with default values
        $this->db->query("UPDATE hairstyles SET sort_order = id WHERE sort_order IS NULL");
    }

    public function down()
    {
        // Remove foreign key constraint
        $this->forge->dropForeignKey('hairstyles', 'hairstyles_category_id_foreign');
        
        // Remove added columns
        $this->forge->dropColumn('hairstyles', ['category_id', 'image_url', 'duration_minutes', 'difficulty_level', 'tags', 'sort_order']);
    }
}