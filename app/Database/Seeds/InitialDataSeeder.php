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

        // Create default quick messages
        $quickMessages = [
            [
                'keyword' => 'list hairstyle',
                'response' => "💇‍♀️ *Daftar Hairstyle Wardati*\n\n• *Pompadour Classic* - Rp 75.000\n• *Undercut Modern* - Rp 85.000\n• *Fade Style* - Rp 90.000\n• *Quiff Style* - Rp 80.000\n• *Buzz Cut* - Rp 60.000\n• *Side Part* - Rp 70.000\n\nUntuk melihat foto, ketik: *foto hairstyle*\nUntuk booking, ketik: *booking*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'harga hairstyle',
                'response' => "💰 *Harga Hairstyle Wardati*\n\n• Pompadour Classic: Rp 75.000\n• Undercut Modern: Rp 85.000\n• Fade Style: Rp 90.000\n• Quiff Style: Rp 80.000\n• Buzz Cut: Rp 60.000\n• Side Part: Rp 70.000\n\n💡 *Layanan Tambahan:*\n• Home Service: +Rp 25.000\n• Express Service: +Rp 15.000\n\nUntuk booking, ketik: *booking*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'jam buka',
                'response' => "🕐 *Jam Buka Wardati Hairstyle*\n\n📅 *Senin - Jumat:*\n   09:00 - 20:00 WITA\n\n📅 *Sabtu - Minggu:*\n   08:00 - 21:00 WITA\n\n📅 *Hari Libur Nasional:*\n   10:00 - 18:00 WITA\n\n💡 *Catatan:*\n• Booking terakhir 2 jam sebelum tutup\n• Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n\nUntuk booking, ketik: *booking*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'lokasi',
                'response' => "📍 *Lokasi Wardati Hairstyle*\n\n🏪 *Salon Utama:*\n   Jl. Raya Wardati No. 123\n   Makassar, Sulawesi Selatan\n   📍 Google Maps: bit.ly/wardati-salon\n\n🚗 *Akses:*\n• 5 menit dari Mall Panakkukang\n• 10 menit dari Mall GTC\n• Tersedia parkir motor & mobil\n\n🏠 *Home Service:*\n   Tersedia untuk area Makassar\n   Biaya tambahan: Rp 25.000\n\nUntuk booking, ketik: *booking*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'layanan',
                'response' => "✨ *Layanan Wardati Hairstyle*\n\n💇‍♀️ *Layanan Utama:*\n• Potong & Styling\n• Coloring & Highlight\n• Smoothing & Rebonding\n• Perm & Curling\n• Hair Treatment\n• Hair Extension\n\n🏠 *Home Service:*\n• Semua layanan tersedia\n• Biaya tambahan: Rp 25.000\n• Booking minimal 1 hari sebelumnya\n\n⚡ *Express Service:*\n• Potong & styling cepat\n• Biaya tambahan: Rp 15.000\n• Waktu: 30-45 menit\n\nUntuk melihat harga, ketik: *harga hairstyle*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'kontak',
                'response' => "📞 *Kontak Wardati Hairstyle*\n\n📱 *WhatsApp:*\n   0812-3456-7890\n   (Respon cepat 24/7)\n\n📞 *Telepon:*\n   0411-1234-5678\n   (Senin-Minggu 09:00-20:00)\n\n📧 *Email:*\n   info@wardati-hairstyle.com\n\n🌐 *Website:*\n   wardati-hairstyle.com\n\n📱 *Social Media:*\n   Instagram: @wardati_hairstyle\n   Facebook: Wardati Hairstyle\n   TikTok: @wardati_hairstyle\n\n💬 *Chat Otomatis:*\n   Ketik *menu* untuk bantuan",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'booking',
                'response' => "📅 *Cara Booking Wardati Hairstyle*\n\n1️⃣ *Melalui Website:*\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2️⃣ *Melalui WhatsApp:*\n   Kirim pesan dengan format:\n   *BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]*\n   Contoh: BOOKING Pompadour Classic 25/12/2024 14:00 salon\n\n3️⃣ *Melalui Telepon:*\n   Hubungi: 0812-3456-7890\n\nUntuk melihat daftar hairstyle, ketik: *list hairstyle*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'menu',
                'response' => "🎯 *Menu Bantuan Wardati Hairstyle*\n\nSilakan pilih menu di bawah ini:\n\n📋 *1. List Hairstyle*\n   Ketik: *list hairstyle*\n\n📸 *2. Foto Hairstyle*\n   Ketik: *foto hairstyle*\n\n💰 *3. Harga Hairstyle*\n   Ketik: *harga hairstyle*\n\n📅 *4. Cara Booking*\n   Ketik: *booking*\n\n🕐 *5. Jam Buka*\n   Ketik: *jam buka*\n\n📍 *6. Lokasi*\n   Ketik: *lokasi*\n\n✨ *7. Layanan*\n   Ketik: *layanan*\n\n📞 *8. Kontak*\n   Ketik: *kontak*\n\n💡 *Tips:*\n• Ketik kata kunci untuk respon cepat\n• Untuk pertanyaan khusus, admin akan merespon",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'keyword' => 'foto hairstyle',
                'response' => "📸 *Foto Hairstyle Wardati*\n\n• Pompadour Classic: wardati.com/pompadour\n• Undercut Modern: wardati.com/undercut\n• Fade Style: wardati.com/fade\n• Quiff Style: wardati.com/quiff\n• Buzz Cut: wardati.com/buzz\n• Side Part: wardati.com/sidepart\n\nUntuk melihat harga, ketik: *harga hairstyle*\nUntuk booking, ketik: *booking*",
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('quick_messages')->insertBatch($quickMessages);
    }
}