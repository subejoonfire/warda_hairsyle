<?php

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'wardati_hairstyle';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL successfully\n";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");
    echo "Database '$database' created or already exists\n";
    
    // Use the database
    $pdo->exec("USE `$database`");
    
    // Create quick_message_responses table
    $sql = "CREATE TABLE IF NOT EXISTS `quick_message_responses` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `quick_message_id` int(11) unsigned NOT NULL,
        `response_text` text NOT NULL,
        `is_active` tinyint(1) DEFAULT 1,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `quick_message_id` (`quick_message_id`),
        CONSTRAINT `quick_message_responses_ibfk_1` FOREIGN KEY (`quick_message_id`) REFERENCES `quick_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    $pdo->exec($sql);
    echo "Table 'quick_message_responses' created successfully\n";
    
    // Insert quick message responses
    $responses = [
        [
            'quick_message_id' => 1,
            'response_text' => "Daftar Hairstyle Wardati\n\n" .
                             "Hairstyle Tersedia:\n" .
                             "- Pompadour Classic - Rp 75.000\n" .
                             "  Gaya rambut klasik dengan volume tinggi di bagian depan\n\n" .
                             "- Undercut Modern - Rp 85.000\n" .
                             "  Gaya rambut modern dengan bagian samping yang dipotong pendek\n\n" .
                             "- Fade Style - Rp 90.000\n" .
                             "  Gaya rambut dengan gradasi dari pendek ke panjang\n\n" .
                             "- Quiff Style - Rp 80.000\n" .
                             "  Gaya rambut dengan bagian depan yang diangkat dan disisir ke belakang\n\n" .
                             "- Buzz Cut - Rp 60.000\n" .
                             "  Potongan rambut pendek dan rapi untuk tampilan bersih\n\n" .
                             "- Side Part - Rp 70.000\n" .
                             "  Gaya rambut dengan belahan samping yang elegan\n\n" .
                             "Untuk melihat foto, ketik: foto hairstyle\n" .
                             "Untuk melihat harga, ketik: harga hairstyle\n" .
                             "Untuk booking, ketik: booking",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 2,
            'response_text' => "Harga Hairstyle Wardati\n\n" .
                             "Layanan Utama:\n" .
                             "- Pompadour Classic: Rp 75.000\n" .
                             "- Undercut Modern: Rp 85.000\n" .
                             "- Fade Style: Rp 90.000\n" .
                             "- Quiff Style: Rp 80.000\n" .
                             "- Buzz Cut: Rp 60.000\n" .
                             "- Side Part: Rp 70.000\n\n" .
                             "Layanan Tambahan:\n" .
                             "- Home Service: +Rp 25.000\n" .
                             "- Express Service: +Rp 15.000\n" .
                             "- Hair Treatment: +Rp 30.000\n" .
                             "- Coloring: +Rp 50.000\n\n" .
                             "Paket Promo:\n" .
                             "- Paket Wedding: Potong + Styling + Makeup\n" .
                             "- Paket Family: 3-5 orang (Diskon 20%)\n" .
                             "- Paket Student: Potong + Styling (Diskon 15%)\n\n" .
                             "Untuk booking, ketik: booking\n" .
                             "Untuk melihat daftar lengkap, ketik: list hairstyle",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 3,
            'response_text' => "Jam Buka Wardati Hairstyle\n\n" .
                             "Senin - Jumat:\n" .
                             "09:00 - 20:00 WIB\n\n" .
                             "Sabtu - Minggu:\n" .
                             "08:00 - 21:00 WIB\n\n" .
                             "Hari Libur Nasional:\n" .
                             "10:00 - 18:00 WIB\n\n" .
                             "Catatan:\n" .
                             "- Booking terakhir 2 jam sebelum tutup\n" .
                             "- Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n" .
                             "- Untuk booking mendesak, hubungi langsung\n\n" .
                             "Untuk booking, ketik: booking",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 4,
            'response_text' => "Lokasi Wardati Hairstyle\n\n" .
                             "Salon Utama:\n" .
                             "Jl. Raya Wardati No. 123\n" .
                             "Jakarta Selatan, DKI Jakarta\n" .
                             "Google Maps: bit.ly/wardati-salon\n\n" .
                             "Akses:\n" .
                             "- 5 menit dari Stasiun MRT Blok M\n" .
                             "- 10 menit dari Mall Blok M Square\n" .
                             "- Tersedia parkir motor & mobil\n\n" .
                             "Transportasi Umum:\n" .
                             "- MRT: Stasiun Blok M\n" .
                             "- TransJakarta: Halte Blok M\n" .
                             "- Angkot: 02, 05, 08\n\n" .
                             "Home Service:\n" .
                             "Tersedia untuk area Jakarta Selatan\n" .
                             "Biaya tambahan: Rp 25.000\n\n" .
                             "Untuk booking, ketik: booking",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 5,
            'response_text' => "Layanan Wardati Hairstyle\n\n" .
                             "Potong Rambut:\n" .
                             "- Potong Pria (Semua Gaya)\n" .
                             "- Potong Wanita (Semua Gaya)\n" .
                             "- Potong Anak-anak\n" .
                             "- Potong Rambut Panjang\n\n" .
                             "Styling & Makeup:\n" .
                             "- Styling Rambut\n" .
                             "- Makeup Natural\n" .
                             "- Makeup Glamour\n" .
                             "- Makeup Wedding\n\n" .
                             "Perawatan Rambut:\n" .
                             "- Hair Treatment\n" .
                             "- Hair Coloring\n" .
                             "- Hair Smoothing\n" .
                             "- Hair Rebonding\n\n" .
                             "Layanan Tambahan:\n" .
                             "- Home Service\n" .
                             "- Express Service\n" .
                             "- Wedding Package\n" .
                             "- Family Package\n\n" .
                             "Untuk melihat harga, ketik: harga hairstyle\n" .
                             "Untuk booking, ketik: booking",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 6,
            'response_text' => "Kontak Wardati Hairstyle\n\n" .
                             "WhatsApp:\n" .
                             "0812-3456-7890\n\n" .
                             "Telepon:\n" .
                             "021-1234-5678\n\n" .
                             "Email:\n" .
                             "info@wardati-hairstyle.com\n\n" .
                             "Social Media:\n" .
                             "- Instagram: @wardati_hairstyle\n" .
                             "- Facebook: Wardati Hairstyle\n" .
                             "- TikTok: @wardati_hairstyle\n\n" .
                             "Website:\n" .
                             "wardati-hairstyle.com\n\n" .
                             "Untuk booking, ketik: booking\n" .
                             "Untuk melihat lokasi, ketik: lokasi",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 7,
            'response_text' => "Cara Booking Wardati Hairstyle\n\n" .
                             "1. Melalui Website:\n" .
                             "   Kunjungi: wardati-hairstyle.com\n" .
                             "   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n" .
                             "2. Melalui WhatsApp:\n" .
                             "   Kirim pesan dengan format:\n" .
                             "   BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]\n" .
                             "   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n" .
                             "3. Melalui Telepon:\n" .
                             "   Hubungi: 0812-3456-7890\n\n" .
                             "Informasi yang diperlukan:\n" .
                             "- Nama lengkap\n" .
                             "- Nomor WhatsApp\n" .
                             "- Alamat (untuk home service)\n" .
                             "- Catatan khusus\n\n" .
                             "Untuk melihat daftar hairstyle, ketik: list hairstyle",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'quick_message_id' => 8,
            'response_text' => "Menu Bantuan Wardati Hairstyle\n\n" .
                             "Informasi Layanan:\n" .
                             "- list hairstyle - Daftar hairstyle\n" .
                             "- harga hairstyle - Harga layanan\n" .
                             "- foto hairstyle - Galeri foto\n" .
                             "- layanan - Jenis layanan\n\n" .
                             "Informasi Booking:\n" .
                             "- booking - Cara booking\n" .
                             "- jam buka - Jam operasional\n" .
                             "- lokasi - Lokasi salon\n\n" .
                             "Kontak & Support:\n" .
                             "- kontak - Informasi kontak\n" .
                             "- menu - Menu bantuan ini\n\n" .
                             "Tips:\n" .
                             "- Ketik kata kunci yang diinginkan\n" .
                             "- Admin akan merespon dalam waktu singkat\n" .
                             "- Untuk pertanyaan khusus, admin akan membantu\n\n" .
                             "Untuk booking, ketik: booking",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
    ];
    
    // Clear existing responses
    $pdo->exec("DELETE FROM quick_message_responses");
    
    // Insert responses
    $stmt = $pdo->prepare("INSERT INTO quick_message_responses (quick_message_id, response_text, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($responses as $response) {
        $stmt->execute([
            $response['quick_message_id'],
            $response['response_text'],
            $response['is_active'],
            $response['created_at'],
            $response['updated_at']
        ]);
    }
    
    echo "Quick message responses inserted successfully\n";
    echo "Total responses inserted: " . count($responses) . "\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}