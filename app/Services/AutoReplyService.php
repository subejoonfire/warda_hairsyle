<?php

namespace App\Services;

use App\Models\HairstyleModel;

class AutoReplyService
{
    protected $hairstyleModel;

    public function __construct()
    {
        $this->hairstyleModel = new HairstyleModel();
    }

    public function generateAutoReply($message)
    {
        $message = strtolower(trim($message));
        
        // List hairstyle
        if (strpos($message, 'list') !== false && strpos($message, 'hairstyle') !== false) {
            return $this->getHairstyleList();
        }
        
        // Foto hairstyle
        if (strpos($message, 'foto') !== false || strpos($message, 'gambar') !== false) {
            return $this->getHairstylePhotos();
        }
        
        // Harga hairstyle
        if (strpos($message, 'harga') !== false || strpos($message, 'price') !== false) {
            return $this->getHairstylePrices();
        }
        
        // Booking
        if (strpos($message, 'booking') !== false || strpos($message, 'pesan') !== false || strpos($message, 'order') !== false) {
            return $this->getBookingInfo();
        }
        
        // Jam buka
        if (strpos($message, 'jam') !== false && strpos($message, 'buka') !== false) {
            return $this->getOpeningHours();
        }
        
        // Lokasi
        if (strpos($message, 'lokasi') !== false || strpos($message, 'alamat') !== false || strpos($message, 'dimana') !== false) {
            return $this->getLocation();
        }
        
        // Layanan
        if (strpos($message, 'layanan') !== false || strpos($message, 'service') !== false) {
            return $this->getServices();
        }
        
        // Kontak
        if (strpos($message, 'kontak') !== false || strpos($message, 'hubungi') !== false || strpos($message, 'telepon') !== false) {
            return $this->getContactInfo();
        }
        
        // Menu utama
        if (strpos($message, 'menu') !== false || strpos($message, 'bantuan') !== false || strpos($message, 'help') !== false) {
            return $this->getMainMenu();
        }
        
        // Default response
        return $this->getDefaultResponse();
    }

    private function getHairstyleList()
    {
        $hairstyles = $this->hairstyleModel->getActiveHairstyles();
        
        $response = "💇‍♀️ *Daftar Hairstyle Wardati*\n\n";
        
        foreach ($hairstyles as $hairstyle) {
            $response .= "• *{$hairstyle['name']}*\n";
            $response .= "  💰 Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
            $response .= "  📝 {$hairstyle['description']}\n\n";
        }
        
        $response .= "Untuk melihat foto, ketik: *foto hairstyle*\n";
        $response .= "Untuk booking, ketik: *booking*\n";
        
        return $response;
    }

    private function getHairstylePhotos()
    {
        $hairstyles = $this->hairstyleModel->getActiveHairstyles();
        
        $response = "📸 *Foto Hairstyle Wardati*\n\n";
        
        foreach ($hairstyles as $hairstyle) {
            if (!empty($hairstyle['image'])) {
                $response .= "• *{$hairstyle['name']}*\n";
                $response .= "  🖼️ {$hairstyle['image']}\n\n";
            }
        }
        
        $response .= "Untuk melihat harga, ketik: *harga hairstyle*\n";
        $response .= "Untuk booking, ketik: *booking*\n";
        
        return $response;
    }

    private function getHairstylePrices()
    {
        $hairstyles = $this->hairstyleModel->getActiveHairstyles();
        
        $response = "💰 *Harga Hairstyle Wardati*\n\n";
        
        foreach ($hairstyles as $hairstyle) {
            $response .= "• *{$hairstyle['name']}*\n";
            $response .= "  💰 Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n\n";
        }
        
        $response .= "💡 *Layanan Tambahan:*\n";
        $response .= "• Home Service: +Rp 25.000\n";
        $response .= "• Express Service: +Rp 15.000\n\n";
        
        $response .= "Untuk booking, ketik: *booking*\n";
        
        return $response;
    }

    private function getBookingInfo()
    {
        $response = "📅 *Cara Booking Wardati Hairstyle*\n\n";
        $response .= "1️⃣ *Melalui Website:*\n";
        $response .= "   Kunjungi: wardati-hairstyle.com\n";
        $response .= "   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n";
        
        $response .= "2️⃣ *Melalui WhatsApp:*\n";
        $response .= "   Kirim pesan dengan format:\n";
        $response .= "   *BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]*\n";
        $response .= "   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n";
        
        $response .= "3️⃣ *Melalui Telepon:*\n";
        $response .= "   Hubungi: 0812-3456-7890\n\n";
        
        $response .= "📋 *Informasi yang diperlukan:*\n";
        $response .= "• Nama lengkap\n";
        $response .= "• Nomor WhatsApp\n";
        $response .= "• Alamat (untuk home service)\n";
        $response .= "• Catatan khusus\n\n";
        
        $response .= "Untuk melihat daftar hairstyle, ketik: *list hairstyle*\n";
        
        return $response;
    }

    private function getOpeningHours()
    {
        $response = "🕐 *Jam Buka Wardati Hairstyle*\n\n";
        $response .= "📅 *Senin - Jumat:*\n";
        $response .= "   09:00 - 20:00 WIB\n\n";
        
        $response .= "📅 *Sabtu - Minggu:*\n";
        $response .= "   08:00 - 21:00 WIB\n\n";
        
        $response .= "📅 *Hari Libur Nasional:*\n";
        $response .= "   10:00 - 18:00 WIB\n\n";
        
        $response .= "💡 *Catatan:*\n";
        $response .= "• Booking terakhir 2 jam sebelum tutup\n";
        $response .= "• Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n";
        $response .= "• Untuk booking mendesak, hubungi langsung\n\n";
        
        $response .= "Untuk booking, ketik: *booking*\n";
        
        return $response;
    }

    private function getLocation()
    {
        $response = "📍 *Lokasi Wardati Hairstyle*\n\n";
        $response .= "🏪 *Salon Utama:*\n";
        $response .= "   Jl. Raya Wardati No. 123\n";
        $response .= "   Jakarta Selatan, DKI Jakarta\n";
        $response .= "   📍 Google Maps: bit.ly/wardati-salon\n\n";
        
        $response .= "🚗 *Akses:*\n";
        $response .= "• 5 menit dari Stasiun MRT Blok M\n";
        $response .= "• 10 menit dari Mall Blok M Square\n";
        $response .= "• Tersedia parkir motor & mobil\n\n";
        
        $response .= "🚌 *Transportasi Umum:*\n";
        $response .= "• MRT: Stasiun Blok M\n";
        $response .= "• TransJakarta: Halte Blok M\n";
        $response .= "• Angkot: 02, 05, 08\n\n";
        
        $response .= "🏠 *Home Service:*\n";
        $response .= "   Tersedia untuk area Jakarta Selatan\n";
        $response .= "   Biaya tambahan: Rp 25.000\n\n";
        
        $response .= "Untuk booking, ketik: *booking*\n";
        
        return $response;
    }

    private function getServices()
    {
        $response = "✨ *Layanan Wardati Hairstyle*\n\n";
        $response .= "💇‍♀️ *Layanan Utama:*\n";
        $response .= "• Potong & Styling\n";
        $response .= "• Coloring & Highlight\n";
        $response .= "• Smoothing & Rebonding\n";
        $response .= "• Perm & Curling\n";
        $response .= "• Hair Treatment\n";
        $response .= "• Hair Extension\n\n";
        
        $response .= "🏠 *Home Service:*\n";
        $response .= "• Semua layanan tersedia\n";
        $response .= "• Biaya tambahan: Rp 25.000\n";
        $response .= "• Booking minimal 1 hari sebelumnya\n\n";
        
        $response .= "⚡ *Express Service:*\n";
        $response .= "• Potong & styling cepat\n";
        $response .= "• Biaya tambahan: Rp 15.000\n";
        $response .= "• Waktu: 30-45 menit\n\n";
        
        $response .= "🎁 *Paket Promo:*\n";
        $response .= "• Paket Wedding: Potong + Styling + Makeup\n";
        $response .= "• Paket Family: 3-5 orang\n";
        $response .= "• Paket Student: Potong + Styling\n\n";
        
        $response .= "Untuk melihat harga, ketik: *harga hairstyle*\n";
        
        return $response;
    }

    private function getContactInfo()
    {
        $response = "📞 *Kontak Wardati Hairstyle*\n\n";
        $response .= "📱 *WhatsApp:*\n";
        $response .= "   0812-3456-7890\n";
        $response .= "   (Respon cepat 24/7)\n\n";
        
        $response .= "📞 *Telepon:*\n";
        $response .= "   021-1234-5678\n";
        $response .= "   (Senin-Minggu 09:00-20:00)\n\n";
        
        $response .= "📧 *Email:*\n";
        $response .= "   info@wardati-hairstyle.com\n\n";
        
        $response .= "🌐 *Website:*\n";
        $response .= "   wardati-hairstyle.com\n\n";
        
        $response .= "📱 *Social Media:*\n";
        $response .= "   Instagram: @wardati_hairstyle\n";
        $response .= "   Facebook: Wardati Hairstyle\n";
        $response .= "   TikTok: @wardati_hairstyle\n\n";
        
        $response .= "💬 *Chat Otomatis:*\n";
        $response .= "   Ketik *menu* untuk bantuan\n";
        
        return $response;
    }

    private function getMainMenu()
    {
        $response = "🎯 *Menu Bantuan Wardati Hairstyle*\n\n";
        $response .= "Silakan pilih menu di bawah ini:\n\n";
        
        $response .= "📋 *1. List Hairstyle*\n";
        $response .= "   Ketik: *list hairstyle*\n\n";
        
        $response .= "📸 *2. Foto Hairstyle*\n";
        $response .= "   Ketik: *foto hairstyle*\n\n";
        
        $response .= "💰 *3. Harga Hairstyle*\n";
        $response .= "   Ketik: *harga hairstyle*\n\n";
        
        $response .= "📅 *4. Cara Booking*\n";
        $response .= "   Ketik: *booking*\n\n";
        
        $response .= "🕐 *5. Jam Buka*\n";
        $response .= "   Ketik: *jam buka*\n\n";
        
        $response .= "📍 *6. Lokasi*\n";
        $response .= "   Ketik: *lokasi*\n\n";
        
        $response .= "✨ *7. Layanan*\n";
        $response .= "   Ketik: *layanan*\n\n";
        
        $response .= "📞 *8. Kontak*\n";
        $response .= "   Ketik: *kontak*\n\n";
        
        $response .= "💡 *Tips:*\n";
        $response .= "• Ketik kata kunci untuk respon cepat\n";
        $response .= "• Untuk pertanyaan khusus, admin akan merespon\n";
        
        return $response;
    }

    private function getDefaultResponse()
    {
        $response = "Halo! 👋 Terima kasih telah menghubungi Wardati Hairstyle.\n\n";
        $response .= "Saya adalah asisten otomatis yang siap membantu Anda.\n\n";
        $response .= "Silakan ketik salah satu kata kunci berikut:\n\n";
        $response .= "• *list hairstyle* - Daftar hairstyle\n";
        $response .= "• *foto hairstyle* - Foto hairstyle\n";
        $response .= "• *harga hairstyle* - Harga layanan\n";
        $response .= "• *booking* - Cara booking\n";
        $response .= "• *jam buka* - Jam operasional\n";
        $response .= "• *lokasi* - Lokasi salon\n";
        $response .= "• *layanan* - Jenis layanan\n";
        $response .= "• *kontak* - Informasi kontak\n";
        $response .= "• *menu* - Menu bantuan lengkap\n\n";
        $response .= "Untuk pertanyaan khusus, admin akan merespon dalam waktu singkat.";
        
        return $response;
    }
}