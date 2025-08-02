# 🪒 Wardati Hairstyle Website

Website Wardati Hairstyle lengkap dengan sistem booking, chat, dan integrasi WhatsApp menggunakan CodeIgniter 4 dan Tailwind CSS.

## ✨ Fitur Utama

### 🏠 Landing Page
- Showcase hairstyles dengan gambar dan harga
- Kategori hairstyle (Classic, Modern, Fade, Short)
- Informasi layanan dan keunggulan
- Call-to-action untuk registrasi

### 👤 Sistem Autentikasi
- Registrasi dengan verifikasi WhatsApp via Fonnte
- Login menggunakan nomor WhatsApp
- Verifikasi kode 6 digit melalui WhatsApp
- Role-based access (Customer & Admin)

### 🎯 Customer Dashboard
- Riwayat booking dengan status
- Statistik penggunaan layanan
- Quick actions untuk booking dan chat
- Profile management

### 📅 Sistem Booking
- Pilihan hairstyle dengan preview
- Pemilihan tanggal dan waktu
- Opsi layanan (Salon atau Home Service)
- Kalkulasi harga otomatis
- Notifikasi WhatsApp untuk konfirmasi

### 💬 Chat System
- Real-time chat dengan admin
- Quick messages untuk pertanyaan umum
- Notifikasi WhatsApp untuk admin
- Auto-refresh setiap 5 detik

### 👨‍💼 Admin Panel
- Dashboard dengan statistik lengkap
- Manajemen hairstyles (CRUD)
- Kelola booking dengan status updates
- Chat management dengan customer
- Notifikasi WhatsApp otomatis

### 📱 Integrasi WhatsApp
- Verifikasi akun via WhatsApp
- Notifikasi booking baru
- Update status booking
- Chat notifications
- Menggunakan API Fonnte

## 🛠️ Teknologi yang Digunakan

- **Backend**: CodeIgniter 4
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **WhatsApp API**: Fonnte
- **Icons**: Font Awesome
- **JavaScript**: Vanilla JS

## 📋 Persyaratan Sistem

- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Composer
- Web server (Apache/Nginx)
- Akun Fonnte untuk WhatsApp API

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd wardati-hairstyle-website
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database MySQL:
```env
# Database Configuration
database.default.hostname = localhost
database.default.database = wardati_hairstyle
database.default.username = root
database.default.password = your_mysql_password

# Fonnte WhatsApp API
fonnte.api_key = "YOUR_FONNTE_API_KEY"
fonnte.base_url = "https://api.fonnte.com/send"
fonnte.device_id = "YOUR_DEVICE_ID"
```



### 5. Setup Upload Directory
```bash
mkdir -p public/uploads/hairstyles
chmod 755 public/uploads/hairstyles
```

### 6. Jalankan Server
```bash
php spark serve
```

Website akan berjalan di `http://localhost:8080`

## 🔧 Konfigurasi Fonnte

1. Daftar akun di [Fonnte](https://fonnte.com)
2. Dapatkan API Key dan Device ID
3. Update file `.env` dengan kredensial Fonnte
4. Pastikan device Fonnte sudah terhubung

## 👤 Akun Default

### Admin
- **WhatsApp**: 6281234567890
- **Password**: admin123

### Customer
- Daftar melalui halaman registrasi
- Verifikasi via WhatsApp

## 📁 Struktur Database

### Tables
- `users` - Data customer dan admin
- `hairstyles` - Katalog hairstyle
- `bookings` - Data booking customer
- `chats` - Riwayat chat customer-admin
- `quick_messages` - Pesan cepat untuk chat

## 🎨 Customization

### Styling
- Edit file `app/Views/layout/main.php` untuk mengubah tema
- Gunakan Tailwind CSS classes untuk styling
- Warna utama: Primary (#1f2937), Accent (#f59e0b)

### Hairstyles
- Tambah hairstyle melalui admin panel
- Upload gambar ke `public/uploads/hairstyles/`
- Kategori: classic, modern, fade, short

### WhatsApp Messages
- Edit template pesan di `app/Services/WhatsAppService.php`
- Customize format pesan sesuai kebutuhan

## 🔒 Security Features

- Password hashing dengan bcrypt
- Session management
- CSRF protection
- Input validation
- Role-based access control
- WhatsApp verification

## 📱 Responsive Design

Website sudah responsive untuk:
- Desktop (1024px+)
- Tablet (768px - 1023px)
- Mobile (< 768px)

## 🚨 Troubleshooting

### Error Database Connection
- Pastikan MySQL server berjalan
- Cek kredensial database di file `.env`
- Pastikan database `wardati_hairstyle` sudah dibuat
- Jalankan `php setup_database.php` untuk setup database
- Pastikan user MySQL memiliki akses ke database



### Error WhatsApp API
- Cek kredensial Fonnte di `.env`
- Pastikan API key Fonnte valid
- Cek balance Fonnte account

### Error Upload Image
- Pastikan folder `public/uploads/hairstyles/` ada
- Cek permission folder (755)
- Pastikan file size tidak melebihi limit

## 📞 Support

Untuk bantuan dan pertanyaan:
- Email: support@wardatihairstyle.com
- WhatsApp: +62 812-3456-7890

## 📚 Dokumentasi Tambahan

- [Troubleshooting](README.md#-troubleshooting) - Solusi masalah umum

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- CodeIgniter 4 Framework
- Tailwind CSS
- Fonnte WhatsApp API
- Font Awesome Icons

---

**Happy Coding! 🚀**
