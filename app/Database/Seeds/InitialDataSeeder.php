<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $this->db->table('users')->insert([
            'name' => 'Admin Wardati Hairstyle',
            'whatsapp' => '6281234567890',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'is_verified' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Create sample hairstyles
        $hairstyles = [
            [
                'name' => 'Pompadour Classic',
                'description' => 'Gaya rambut klasik dengan volume tinggi di bagian depan',
                'price' => 75000,
                'category' => 'classic',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Undercut Modern',
                'description' => 'Gaya rambut modern dengan bagian samping yang dipotong pendek',
                'price' => 85000,
                'category' => 'modern',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fade Style',
                'description' => 'Gaya rambut dengan gradasi dari pendek ke panjang',
                'price' => 90000,
                'category' => 'fade',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Quiff Style',
                'description' => 'Gaya rambut dengan bagian depan yang diangkat dan disisir ke belakang',
                'price' => 80000,
                'category' => 'classic',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Buzz Cut',
                'description' => 'Potongan rambut pendek dan rapi untuk tampilan bersih',
                'price' => 60000,
                'category' => 'short',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Side Part',
                'description' => 'Gaya rambut dengan belahan samping yang elegan',
                'price' => 70000,
                'category' => 'classic',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('hairstyles')->insertBatch($hairstyles);

        // Create default quick messages (only keywords and descriptions)
        $quickMessages = [
            [
                'keyword' => 'list hairstyle',
                'description' => 'Daftar hairstyle yang tersedia',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'harga hairstyle',
                'description' => 'Informasi harga layanan',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'jam buka',
                'description' => 'Jam operasional salon',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'lokasi',
                'description' => 'Lokasi salon dan home service',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'layanan',
                'description' => 'Jenis layanan yang tersedia',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'kontak',
                'description' => 'Informasi kontak lengkap',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'booking',
                'description' => 'Cara melakukan booking',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'menu',
                'description' => 'Menu bantuan lengkap',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'foto hairstyle',
                'description' => 'Link foto hairstyle',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('quick_messages')->insertBatch($quickMessages);
    }
}