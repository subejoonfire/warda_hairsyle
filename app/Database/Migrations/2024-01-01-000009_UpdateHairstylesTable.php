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
        // CodeIgniter 4 secara otomatis memberi nama foreign key.
        // Nama default biasanya 'table_name_column_name_foreign' atau 'table_name_fk_column_name'.
        // Untuk memastikan, kita bisa mencoba menghapus dengan nama yang umum atau memeriksa keberadaannya.
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');

        // Update existing records with default values
        $this->db->query("UPDATE hairstyles SET sort_order = id WHERE sort_order IS NULL");
    }

    public function down()
    {
        // Remove foreign key constraint
        // Coba hapus foreign key dengan nama yang mungkin dihasilkan oleh CodeIgniter
        // atau dengan nama yang spesifik jika Anda tahu.
        // Jika Anda tidak yakin dengan nama pastinya, Anda bisa mencoba beberapa kemungkinan
        // atau memeriksa skema database secara manual.
        // Nama foreign key yang dihasilkan CodeIgniter 4 biasanya 'hairstyles_category_id_foreign'
        // atau 'hairstyles_category_id_fk'.
        // Kita akan mencoba nama yang paling umum.

        // Pastikan foreign key ada sebelum mencoba menghapusnya
        $forge = \Config\Database::forge();
        $db = \Config\Database::connect();

        // Dapatkan nama foreign key yang sebenarnya dari skema database
        // Ini adalah pendekatan yang lebih robust
        $tableName = 'hairstyles';
        $foreignKeyName = '';

        $query = $db->query("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '{$tableName}' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME LIKE '%category_id%'");
        $result = $query->getRow();

        if ($result) {
            $foreignKeyName = $result->CONSTRAINT_NAME;
        }

        if (!empty($foreignKeyName)) {
            $this->forge->dropForeignKey($tableName, $foreignKeyName);
        } else {
            // Fallback jika tidak ditemukan nama spesifik, coba nama default CodeIgniter
            // Ini kurang disarankan karena bisa gagal jika nama tidak persis
            try {
                $this->forge->dropForeignKey('hairstyles', 'hairstyles_category_id_foreign');
            } catch (\Exception $e) {
                // Log the error but continue, as the FK might not exist or have a different name
                log_message('warning', 'Could not drop foreign key hairstyles_category_id_foreign: ' . $e->getMessage());
            }
        }

        // Remove added columns
        $this->forge->dropColumn('hairstyles', ['category_id', 'image_url', 'duration_minutes', 'difficulty_level', 'tags', 'sort_order']);
    }
}
