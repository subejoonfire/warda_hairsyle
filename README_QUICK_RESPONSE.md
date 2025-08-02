# Sistem Quick Response Wardati Hairstyle

## Overview
Sistem quick response yang terintegrasi dengan database memungkinkan admin untuk mengelola response otomatis yang akan diberikan kepada customer saat mereka mengirim pesan dengan kata kunci tertentu.

## Fitur Utama

### 1. Quick Messages dengan Database
- **Static Response**: Response teks tetap yang bisa diedit admin
- **Dynamic Response**: Response yang diambil dari data database (seperti daftar hairstyle, harga)
- **Admin Management**: Admin dapat menambah, edit, dan hapus quick messages
- **Real-time Preview**: Admin dapat melihat preview response sebelum menyimpan

### 2. Tipe Response

#### Static Response
- Response teks tetap yang disimpan di database
- Admin dapat mengedit content response
- Contoh: jam buka, lokasi, kontak, layanan, booking, menu

#### Dynamic Response
- Response yang diambil dari data database secara real-time
- Otomatis terupdate ketika data berubah
- Contoh: list hairstyle, harga hairstyle

### 3. Quick Messages yang Tersedia

| ID | Keyword | Tipe | Deskripsi |
|----|---------|------|-----------|
| 1 | list hairstyle | Dynamic | Daftar hairstyle dari database |
| 2 | harga hairstyle | Dynamic | Harga hairstyle dari database |
| 3 | jam buka | Static | Jam operasional salon |
| 4 | lokasi | Static | Lokasi salon dan home service |
| 5 | layanan | Static | Jenis layanan yang tersedia |
| 6 | kontak | Static | Informasi kontak lengkap |
| 7 | booking | Static | Cara melakukan booking |
| 8 | menu | Static | Menu bantuan lengkap |
| 9 | foto hairstyle | Static | Link foto hairstyle |

## Struktur Database

### Tabel: quick_messages
```sql
CREATE TABLE quick_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    keyword VARCHAR(100) UNIQUE,
    description VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME,
    updated_at DATETIME
);
```

### Tabel: quick_message_responses
```sql
CREATE TABLE quick_message_responses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quick_message_id INT,
    response_type ENUM('static', 'dynamic'),
    response_content TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (quick_message_id) REFERENCES quick_messages(id)
);
```

## Cara Penggunaan

### Untuk Customer
1. Buka halaman chat di `/chat`
2. Klik tombol quick message yang tersedia
3. Sistem akan otomatis mengirim pesan dan memberikan response

### Untuk Admin
1. Login sebagai admin
2. Akses menu "Quick Messages" di navigation
3. Kelola quick messages:
   - **Tambah**: Klik "Tambah Quick Message"
   - **Edit**: Klik tombol edit pada quick message
   - **Hapus**: Klik tombol hapus pada quick message
   - **Toggle Status**: Aktifkan/nonaktifkan quick message
   - **Preview**: Lihat preview response sebelum menyimpan

## File yang Dibuat/Dimodifikasi

### Migration
- `app/Database/Migrations/2024-01-01-000006_CreateQuickMessageResponsesTable.php`

### Models
- `app/Models/QuickMessageResponseModel.php`

### Controllers
- `app/Controllers/Admin/QuickMessageController.php`
- `app/Controllers/Home.php` (dimodifikasi)

### Views
- `app/Views/admin/quick_messages/index.php`
- `app/Views/admin/quick_messages/create.php`
- `app/Views/admin/quick_messages/edit.php`
- `app/Views/customer/chat.php` (dimodifikasi)

### Routes
- `app/Config/Routes.php` (ditambahkan routes admin)

### Layout
- `app/Views/layout/main.php` (ditambahkan menu quick messages)

## Setup Database

Jalankan SQL berikut untuk setup database:

```sql
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

-- Insert default quick messages
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
(5, 'static', 'Layanan Wardati Hairstyle\n\nPotong Rambut:\n- Potong Pria (Semua Gaya)\n- Potong Wanita (Semua Gaya)\n- Potong Anak-anak\n- Potong Rambut Panjang\n\nStyling & Makeup:\n- Styling Rambut\n- Makeup Natural\n- Makeup Glamour\n- Makeup Wedding\n\nPerawatan Rambut:\n- Hair Treatment\n- Hair Coloring\n- Hair Smoothing\n- Hair Rebonding\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking', 1, NOW(), NOW()),
(6, 'static', 'Kontak Wardati Hairstyle\n\nWhatsApp:\n0812-3456-7890\n\nTelepon:\n021-1234-5678\n\nEmail:\ninfo@wardati-hairstyle.com\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nWebsite:\nwardati-hairstyle.com\n\nUntuk booking, ketik: booking\nUntuk melihat lokasi, ketik: lokasi', 1, NOW(), NOW()),
(7, 'static', 'Cara Booking Wardati Hairstyle\n\n1. Melalui Website:\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2. Melalui WhatsApp:\n   Kirim pesan dengan format:\n   BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]\n   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n3. Melalui Telepon:\n   Hubungi: 0812-3456-7890\n\nInformasi yang diperlukan:\n- Nama lengkap\n- Nomor WhatsApp\n- Alamat (untuk home service)\n- Catatan khusus\n\nUntuk melihat daftar hairstyle, ketik: list hairstyle', 1, NOW(), NOW()),
(8, 'static', 'Menu Bantuan Wardati Hairstyle\n\nInformasi Layanan:\n- list hairstyle - Daftar hairstyle\n- harga hairstyle - Harga layanan\n- foto hairstyle - Galeri foto\n- layanan - Jenis layanan\n\nInformasi Booking:\n- booking - Cara booking\n- jam buka - Jam operasional\n- lokasi - Lokasi salon\n\nKontak & Support:\n- kontak - Informasi kontak\n- menu - Menu bantuan ini\n\nTips:\n- Ketik kata kunci yang diinginkan\n- Admin akan merespon dalam waktu singkat\n- Untuk pertanyaan khusus, admin akan membantu\n\nUntuk booking, ketik: booking', 1, NOW(), NOW()),
(9, 'static', 'Foto Hairstyle Wardati\n\nGaleri Foto:\n- Pompadour Classic: wardati.com/pompadour\n- Undercut Modern: wardati.com/undercut\n- Fade Style: wardati.com/fade\n- Quiff Style: wardati.com/quiff\n- Buzz Cut: wardati.com/buzz\n- Side Part: wardati.com/sidepart\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking', 1, NOW(), NOW());
```

## Keunggulan Sistem

1. **Fleksibilitas**: Admin dapat mengubah response tanpa perlu coding
2. **Real-time**: Dynamic response selalu terupdate dengan data terbaru
3. **User-friendly**: Interface yang mudah digunakan untuk admin
4. **AJAX**: Quick messages menggunakan AJAX untuk pengalaman yang lebih baik
5. **Database-driven**: Semua data tersimpan di database
6. **Scalable**: Mudah menambah quick messages baru

## Catatan Penting

- Quick messages dengan tipe "dynamic" akan mengambil data dari database secara real-time
- Quick messages dengan tipe "static" dapat diedit oleh admin melalui interface
- Semua quick messages dapat diaktifkan/nonaktifkan oleh admin
- Response akan otomatis dikirim sebagai admin message di chat