-- Setup Quick Response System Database (New Version)
-- Wardati Hairstyle

-- Update quick_messages table with new columns
ALTER TABLE `quick_messages` 
ADD COLUMN `response_type` ENUM('static', 'dynamic', 'template') NOT NULL DEFAULT 'static' AFTER `description`,
ADD COLUMN `response_source` VARCHAR(100) NULL AFTER `response_type`,
ADD COLUMN `response_template` TEXT NULL AFTER `response_source`,
ADD COLUMN `sort_order` INT(11) NOT NULL DEFAULT 0 AFTER `is_active`;

-- Update existing records with default values
UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `sort_order` = `id` 
WHERE `response_type` IS NULL;

-- Update existing quick messages with proper configuration
UPDATE `quick_messages` SET 
    `response_type` = 'dynamic',
    `response_source` = 'hairstyles',
    `response_template` = NULL,
    `sort_order` = 1
WHERE `keyword` = 'list hairstyle';

UPDATE `quick_messages` SET 
    `response_type` = 'dynamic',
    `response_source` = 'hairstyle_prices',
    `response_template` = NULL,
    `sort_order` = 2
WHERE `keyword` = 'harga hairstyle';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Jam Buka Wardati Hairstyle\n\nSenin - Jumat:\n09:00 - 20:00 WIB\n\nSabtu - Minggu:\n08:00 - 21:00 WIB\n\nHari Libur Nasional:\n10:00 - 18:00 WIB\n\nCatatan:\n- Booking terakhir 2 jam sebelum tutup\n- Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n- Untuk booking mendesak, hubungi langsung\n\nUntuk booking, ketik: booking',
    `sort_order` = 3
WHERE `keyword` = 'jam buka';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Lokasi Wardati Hairstyle\n\nSalon Utama:\nJl. Raya Wardati No. 123\nJakarta Selatan, DKI Jakarta\nGoogle Maps: bit.ly/wardati-salon\n\nAkses:\n- 5 menit dari Stasiun MRT Blok M\n- 10 menit dari Mall Blok M Square\n- Tersedia parkir motor & mobil\n\nTransportasi Umum:\n- MRT: Stasiun Blok M\n- TransJakarta: Halte Blok M\n- Angkot: 02, 05, 08\n\nHome Service:\nTersedia untuk area Jakarta Selatan\nBiaya tambahan: Rp 25.000\n\nUntuk booking, ketik: booking',
    `sort_order` = 4
WHERE `keyword` = 'lokasi';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Layanan Wardati Hairstyle\n\nPotong Rambut:\n- Potong Pria (Semua Gaya)\n- Potong Wanita (Semua Gaya)\n- Potong Anak-anak\n- Potong Rambut Panjang\n\nStyling & Makeup:\n- Styling Rambut\n- Makeup Natural\n- Makeup Glamour\n- Makeup Wedding\n\nPerawatan Rambut:\n- Hair Treatment\n- Hair Coloring\n- Hair Smoothing\n- Hair Rebonding\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking',
    `sort_order` = 5
WHERE `keyword` = 'layanan';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Kontak Wardati Hairstyle\n\nWhatsApp:\n0812-3456-7890\n\nTelepon:\n021-1234-5678\n\nEmail:\ninfo@wardati-hairstyle.com\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nWebsite:\nwardati-hairstyle.com\n\nUntuk booking, ketik: booking\nUntuk melihat lokasi, ketik: lokasi',
    `sort_order` = 6
WHERE `keyword` = 'kontak';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Cara Booking Wardati Hairstyle\n\n1. Melalui Website:\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2. Melalui WhatsApp:\n   Kirim pesan dengan format:\n   BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]\n   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n3. Melalui Telepon:\n   Hubungi: 0812-3456-7890\n\nInformasi yang diperlukan:\n- Nama lengkap\n- Nomor WhatsApp\n- Alamat (untuk home service)\n- Catatan khusus\n\nUntuk melihat daftar hairstyle, ketik: list hairstyle',
    `sort_order` = 7
WHERE `keyword` = 'booking';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Menu Bantuan Wardati Hairstyle\n\nInformasi Layanan:\n- list hairstyle - Daftar hairstyle\n- harga hairstyle - Harga layanan\n- foto hairstyle - Galeri foto\n- layanan - Jenis layanan\n\nInformasi Booking:\n- booking - Cara booking\n- jam buka - Jam operasional\n- lokasi - Lokasi salon\n\nKontak & Support:\n- kontak - Informasi kontak\n- menu - Menu bantuan ini\n\nTips:\n- Ketik kata kunci yang diinginkan\n- Admin akan merespon dalam waktu singkat\n- Untuk pertanyaan khusus, admin akan membantu\n\nUntuk booking, ketik: booking',
    `sort_order` = 8
WHERE `keyword` = 'menu';

UPDATE `quick_messages` SET 
    `response_type` = 'static',
    `response_source` = NULL,
    `response_template` = 'Foto Hairstyle Wardati\n\nGaleri Foto:\n- Pompadour Classic: wardati.com/pompadour\n- Undercut Modern: wardati.com/undercut\n- Fade Style: wardati.com/fade\n- Quiff Style: wardati.com/quiff\n- Buzz Cut: wardati.com/buzz\n- Side Part: wardati.com/sidepart\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking',
    `sort_order` = 9
WHERE `keyword` = 'foto hairstyle';

-- Verify setup
SELECT 'Quick Response System Setup Complete!' as status;
SELECT COUNT(*) as total_quick_messages FROM quick_messages;
SELECT keyword, response_type, response_source, sort_order FROM quick_messages ORDER BY sort_order;