-- Setup script untuk database Wardati Hairstyle
-- Jalankan script ini di MySQL untuk membuat database

-- Buat database utama
CREATE DATABASE IF NOT EXISTS wardati_hairstyle_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Buat database untuk testing
CREATE DATABASE IF NOT EXISTS wardati_hairstyle_test 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Gunakan database utama
USE wardati_hairstyle_db;

-- Tampilkan informasi database
SELECT 'Database wardati_hairstyle_db berhasil dibuat!' AS status;
SHOW DATABASES LIKE 'wardati_hairstyle%';