-- Create quick_message_responses table
CREATE TABLE IF NOT EXISTS `quick_message_responses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `quick_message_id` int(11) unsigned NOT NULL,
  `response_type` enum('static','dynamic') NOT NULL DEFAULT 'static',
  `response_content` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quick_message_id` (`quick_message_id`),
  CONSTRAINT `quick_message_responses_ibfk_1` FOREIGN KEY (`quick_message_id`) REFERENCES `quick_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default quick messages if they don't exist
INSERT IGNORE INTO `quick_messages` (`id`, `keyword`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'list hairstyle', 'Daftar hairstyle yang tersedia', 1, NOW(), NOW()),
(2, 'harga hairstyle', 'Informasi harga layanan', 1, NOW(), NOW()),
(3, 'jam buka', 'Jam operasional salon', 1, NOW(), NOW()),
(4, 'lokasi', 'Lokasi salon dan home service', 1, NOW(), NOW()),
(5, 'layanan', 'Jenis layanan yang tersedia', 1, NOW(), NOW()),
(6, 'kontak', 'Informasi kontak lengkap', 1, NOW(), NOW()),
(7, 'booking', 'Cara melakukan booking', 1, NOW(), NOW()),
(8, 'menu', 'Menu bantuan lengkap', 1, NOW(), NOW()),
(9, 'foto hairstyle', 'Link foto hairstyle', 1, NOW(), NOW());

-- Insert default responses
INSERT IGNORE INTO `quick_message_responses` (`quick_message_id`, `response_type`, `response_content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'dynamic', NULL, 1, NOW(), NOW()),
(2, 'dynamic', NULL, 1, NOW(), NOW()),
(3, 'static', 'Jam Buka Wardati Hairstyle\n\nSenin - Jumat:\n09:00 - 20:00 WIB\n\nSabtu - Minggu:\n08:00 - 21:00 WIB\n\nHari Libur Nasional:\n10:00 - 18:00 WIB\n\nCatatan:\n- Booking terakhir 2 jam sebelum tutup\n- Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n- Untuk booking mendesak, hubungi langsung\n\nUntuk booking, ketik: booking', 1, NOW(), NOW()),
(4, 'static', 'Lokasi Wardati Hairstyle\n\nSalon Utama:\nJl. Raya Wardati No. 123\nJakarta Selatan, DKI Jakarta\nGoogle Maps: bit.ly/wardati-salon\n\nAkses:\n- 5 menit dari Stasiun MRT Blok M\n- 10 menit dari Mall Blok M Square\n- Tersedia parkir motor & mobil\n\nTransportasi Umum:\n- MRT: Stasiun Blok M\n- TransJakarta: Halte Blok M\n- Angkot: 02, 05, 08\n\nHome Service:\nTersedia untuk area Jakarta Selatan\nBiaya tambahan: Rp 25.000\n\nUntuk booking, ketik: booking', 1, NOW(), NOW()),
(5, 'static', 'Layanan Wardati Hairstyle\n\nPotong Rambut:\n- Potong Pria (Semua Gaya)\n- Potong Wanita (Semua Gaya)\n- Potong Anak-anak\n- Potong Rambut Panjang\n\nStyling & Makeup:\n- Styling Rambut\n- Makeup Natural\n- Makeup Glamour\n- Makeup Wedding\n\nPerawatan Rambut:\n- Hair Treatment\n- Hair Coloring\n- Hair Smoothing\n- Hair Rebonding\n\nLayanan Tambahan:\n- Home Service\n- Express Service\n- Wedding Package\n- Family Package\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking', 1, NOW(), NOW()),
(6, 'static', 'Kontak Wardati Hairstyle\n\nWhatsApp:\n0812-3456-7890\n\nTelepon:\n021-1234-5678\n\nEmail:\ninfo@wardati-hairstyle.com\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nWebsite:\nwardati-hairstyle.com\n\nUntuk booking, ketik: booking\nUntuk melihat lokasi, ketik: lokasi', 1, NOW(), NOW()),
(7, 'static', 'Cara Booking Wardati Hairstyle\n\n1. Melalui Website:\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2. Melalui WhatsApp:\n   Kirim pesan dengan format:\n   BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]\n   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n3. Melalui Telepon:\n   Hubungi: 0812-3456-7890\n\nInformasi yang diperlukan:\n- Nama lengkap\n- Nomor WhatsApp\n- Alamat (untuk home service)\n- Catatan khusus\n\nUntuk melihat daftar hairstyle, ketik: list hairstyle', 1, NOW(), NOW()),
(8, 'static', 'Menu Bantuan Wardati Hairstyle\n\nInformasi Layanan:\n- list hairstyle - Daftar hairstyle\n- harga hairstyle - Harga layanan\n- foto hairstyle - Galeri foto\n- layanan - Jenis layanan\n\nInformasi Booking:\n- booking - Cara booking\n- jam buka - Jam operasional\n- lokasi - Lokasi salon\n\nKontak & Support:\n- kontak - Informasi kontak\n- menu - Menu bantuan ini\n\nTips:\n- Ketik kata kunci yang diinginkan\n- Admin akan merespon dalam waktu singkat\n- Untuk pertanyaan khusus, admin akan membantu\n\nUntuk booking, ketik: booking', 1, NOW(), NOW()),
(9, 'static', 'Foto Hairstyle Wardati\n\nGaleri Foto:\n- Pompadour Classic: wardati.com/pompadour\n- Undercut Modern: wardati.com/undercut\n- Fade Style: wardati.com/fade\n- Quiff Style: wardati.com/quiff\n- Buzz Cut: wardati.com/buzz\n- Side Part: wardati.com/sidepart\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking', 1, NOW(), NOW());