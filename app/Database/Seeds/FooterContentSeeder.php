<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FooterContentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'section' => 'about',
                'title' => 'Warda_hairstyle',
                'content' => 'Layanan cukur rambut terbaik dengan kualitas profesional dan harga terjangkau.',
                'icon' => null,
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Layanan',
                'content' => '',
                'icon' => null,
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => null,
                'content' => 'Cukur Rambut',
                'icon' => 'fas fa-cut',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => null,
                'content' => 'Home Service',
                'icon' => 'fas fa-home',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => null,
                'content' => 'Konsultasi Style',
                'icon' => 'fas fa-comments',
                'order_position' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => 'Kontak',
                'content' => '',
                'icon' => null,
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => null,
                'content' => '+62 812-3456-7890',
                'icon' => 'fab fa-whatsapp',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => null,
                'content' => 'Jl. Contoh No. 123',
                'icon' => 'fas fa-map-marker-alt',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => null,
                'content' => '08:00 - 20:00',
                'icon' => 'fas fa-clock',
                'order_position' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('footer_content')->insertBatch($data);
    }
}