<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'section' => 'why_choose_us',
                'title' => 'Kualitas Terbaik',
                'description' => 'Menggunakan alat dan teknik terbaik untuk hasil maksimal',
                'icon' => 'fas fa-star',
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'why_choose_us',
                'title' => 'Tepat Waktu',
                'description' => 'Layanan cepat dan tepat waktu sesuai janji',
                'icon' => 'fas fa-clock',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'why_choose_us',
                'title' => 'Barber Profesional',
                'description' => 'Tim barber berpengalaman dan terlatih',
                'icon' => 'fas fa-user-tie',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'why_choose_us',
                'title' => 'Kepuasan Customer',
                'description' => 'Prioritas utama adalah kepuasan customer',
                'icon' => 'fas fa-heart',
                'order_position' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Cornrow',
                'description' => 'Layanan cukur rambut dengan berbagai style modern dan klasik',
                'icon' => 'fas fa-cut',
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Home Service',
                'description' => 'Layanan cukur rambut di rumah Anda dengan kenyamanan maksimal',
                'icon' => 'fas fa-home',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Boxbraid',
                'description' => 'Konsultasi style rambut sesuai dengan bentuk wajah Anda',
                'icon' => 'fas fa-cut',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('home_content')->insertBatch($data);
    }
}