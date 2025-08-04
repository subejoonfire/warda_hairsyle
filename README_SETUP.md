# Setup Fitur Konten Dinamis - Warda Hairstyle

## 🚀 Cara Menjalankan Setup

### 1. Via Command Line (Recommended)
```bash
php setup.php
```

### 2. Via Browser
Akses: `http://your-domain.com/setup.php`

## ✨ Fitur yang Akan Diinstall

### 1. **Konten Dinamis Halaman Utama**
- Section "Mengapa Memilih Warda_hairstyle?" menjadi dinamis
- Section "Layanan Kami" menjadi dinamis
- Admin dapat mengubah teks dan icon

### 2. **Konten Dinamis Footer**
- Semua teks di footer dapat diubah admin
- Icon dapat diganti-ganti
- Struktur footer tetap rapi dan responsive

### 3. **Upload Foto untuk Layanan Khusus**
- Customer wajib upload foto rambut untuk layanan **Boxbraid** dan **Cornrow**
- Preview foto sebelum upload
- Validasi file (JPG, PNG, GIF, max 5MB)

### 4. **Sistem Harga Dinamis**
- Harga untuk Boxbraid dan Cornrow menunggu konfirmasi admin
- Admin melihat foto customer sebelum menentukan harga final
- Notifikasi "Harga Menunggu Konfirmasi" di form booking

### 5. **Panel Admin Content Management**
- Menu baru di admin panel untuk mengelola konten
- CRUD lengkap untuk konten halaman utama dan footer
- Interface yang user-friendly dengan preview icon

## 📋 Yang Akan Dibuat Setup Script

### Database Tables:
- `home_content` - Menyimpan konten dinamis halaman utama
- `footer_content` - Menyimpan konten dinamis footer
- Menambah kolom di `bookings`: `customer_photo`, `price_confirmed`, `price_status`

### Directories:
- `writable/uploads/customer_photos/` - Untuk menyimpan foto customer

### Sample Data:
- Data default untuk section "Why Choose Us" (4 items)
- Data default untuk section "Services" (3 items)  
- Data default untuk footer (about, services, contact)

## 🎯 Menu Admin Baru

Setelah setup, admin akan mendapat menu baru:

### Content Management
- **Home Content** (`/admin/home-content`)
  - Kelola konten "Why Choose Us"
  - Kelola konten "Services"
  - Edit teks, icon, dan urutan

- **Footer Content** (`/admin/footer-content`)
  - Kelola konten About
  - Kelola konten Services list
  - Kelola konten Contact info

- **Price Confirmation** (`/admin/price-confirmation`)
  - Lihat booking yang menunggu konfirmasi harga
  - Melihat foto rambut customer
  - Approve/reject harga

## 💰 Struktur Harga Baru

| Layanan | Biaya Tambahan | Status Harga |
|---------|----------------|--------------|
| Salon | Rp 0 | Langsung konfirm |
| Home Service | +Rp 25.000 | Langsung konfirm |
| Cornrow | +Rp 15.000 | **Menunggu konfirmasi admin** |
| Boxbraid | +Rp 20.000 | **Menunggu konfirmasi admin** |

## 🔧 Troubleshooting

### Error "Table doesn't exist"
Pastikan menjalankan `setup.php` terlebih dahulu.

### Error upload foto
Pastikan direktori `writable/uploads/customer_photos/` memiliki permission 755.

### Footer tidak muncul dinamis
Pastikan data footer sudah terisi melalui setup script.

## 📱 Flow Customer Booking Baru

1. Customer pilih hairstyle
2. Customer pilih service type
3. **Jika pilih Boxbraid/Cornrow:**
   - Muncul form upload foto (wajib)
   - Notifikasi "Harga menunggu konfirmasi"
4. Customer isi detail lain dan submit
5. **Admin menerima notifikasi:**
   - Lihat foto customer
   - Tentukan harga final
   - Approve/reject booking

## 🎨 Customization Icon

Admin dapat menggunakan icon FontAwesome:
- `fas fa-star` - Bintang
- `fas fa-clock` - Jam
- `fas fa-user-tie` - Profesional
- `fas fa-heart` - Hati
- `fas fa-cut` - Gunting
- `fas fa-home` - Rumah
- `fab fa-whatsapp` - WhatsApp
- Dan ribuan icon lainnya

## ✅ Verifikasi Setup Berhasil

Setelah menjalankan setup, cek:

1. **Database:** Tabel `home_content` dan `footer_content` ada
2. **Admin Panel:** Menu "Content Management" muncul
3. **Halaman Utama:** Konten "Why Choose Us" tampil dinamis
4. **Footer:** Konten footer tampil dinamis
5. **Booking:** Form upload foto muncul untuk Boxbraid/Cornrow
6. **Upload Directory:** Folder `writable/uploads/customer_photos/` ada

---

🎉 **Setup selesai! Aplikasi Warda Hairstyle siap dengan fitur konten dinamis!**