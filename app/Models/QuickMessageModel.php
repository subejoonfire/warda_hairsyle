<?php

namespace App\Models;

use CodeIgniter\Model;

class QuickMessageModel extends Model
{
    protected $table = 'quick_messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'keyword', 'response', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'keyword' => 'required|min_length[2]|max_length[100]',
        'response' => 'required|min_length[5]',
        'is_active' => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'keyword' => [
            'required' => 'Kata kunci harus diisi',
            'min_length' => 'Kata kunci minimal 2 karakter',
            'max_length' => 'Kata kunci maksimal 100 karakter',
        ],
        'response' => [
            'required' => 'Respon harus diisi',
            'min_length' => 'Respon minimal 5 karakter',
        ],
        'is_active' => [
            'required' => 'Status aktif harus diisi',
            'in_list' => 'Status aktif harus 0 atau 1',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveQuickMessages()
    {
        return $this->where('is_active', true)
                   ->orderBy('keyword', 'ASC')
                   ->findAll();
    }

    public function findQuickMessage($message)
    {
        $message = strtolower(trim($message));
        
        $quickMessages = $this->getActiveQuickMessages();
        
        foreach ($quickMessages as $quickMessage) {
            $keyword = strtolower(trim($quickMessage['keyword']));
            
            // Check if message contains keyword
            if (strpos($message, $keyword) !== false) {
                return $quickMessage;
            }
        }
        
        return null;
    }

    public function insertDefaultQuickMessages()
    {
        $defaultMessages = [
            [
                'keyword' => 'list hairstyle',
                'response' => "💇‍♀️ *Daftar Hairstyle Wardati*\n\n• Bob Cut - Rp 150.000\n• Pixie Cut - Rp 180.000\n• Long Hair - Rp 200.000\n• Short Hair - Rp 120.000\n\nUntuk melihat foto, ketik: *foto hairstyle*\nUntuk booking, ketik: *booking*",
                'is_active' => true
            ],
            [
                'keyword' => 'foto hairstyle',
                'response' => "📸 *Foto Hairstyle Wardati*\n\n• Bob Cut: wardati.com/bob-cut\n• Pixie Cut: wardati.com/pixie-cut\n• Long Hair: wardati.com/long-hair\n• Short Hair: wardati.com/short-hair\n\nUntuk melihat harga, ketik: *harga hairstyle*\nUntuk booking, ketik: *booking*",
                'is_active' => true
            ],
            [
                'keyword' => 'harga hairstyle',
                'response' => "💰 *Harga Hairstyle Wardati*\n\n• Bob Cut: Rp 150.000\n• Pixie Cut: Rp 180.000\n• Long Hair: Rp 200.000\n• Short Hair: Rp 120.000\n\n💡 *Layanan Tambahan:*\n• Home Service: +Rp 25.000\n• Express Service: +Rp 15.000\n\nUntuk booking, ketik: *booking*",
                'is_active' => true
            ],
            [
                'keyword' => 'booking',
                'response' => "📅 *Cara Booking Wardati Hairstyle*\n\n1️⃣ *Melalui Website:*\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2️⃣ *Melalui WhatsApp:*\n   Kirim pesan dengan format:\n   *BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]*\n   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n3️⃣ *Melalui Telepon:*\n   Hubungi: 0812-3456-7890\n\nUntuk melihat daftar hairstyle, ketik: *list hairstyle*",
                'is_active' => true
            ],
            [
                'keyword' => 'jam buka',
                'response' => "🕐 *Jam Buka Wardati Hairstyle*\n\n📅 *Senin - Jumat:*\n   09:00 - 20:00 WITA\n\n📅 *Sabtu - Minggu:*\n   08:00 - 21:00 WITA\n\n📅 *Hari Libur Nasional:*\n   10:00 - 18:00 WITA\n\n💡 *Catatan:*\n• Booking terakhir 2 jam sebelum tutup\n• Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n\nUntuk booking, ketik: *booking*",
                'is_active' => true
            ],
            [
                'keyword' => 'lokasi',
                'response' => "📍 *Lokasi Wardati Hairstyle*\n\n🏪 *Salon Utama:*\n   Jl. Raya Wardati No. 123\n   Makassar, Sulawesi Selatan\n   📍 Google Maps: bit.ly/wardati-salon\n\n🚗 *Akses:*\n• 5 menit dari Mall Panakkukang\n• 10 menit dari Mall GTC\n• Tersedia parkir motor & mobil\n\n🏠 *Home Service:*\n   Tersedia untuk area Makassar\n   Biaya tambahan: Rp 25.000\n\nUntuk booking, ketik: *booking*",
                'is_active' => true
            ],
            [
                'keyword' => 'layanan',
                'response' => "✨ *Layanan Wardati Hairstyle*\n\n💇‍♀️ *Layanan Utama:*\n• Potong & Styling\n• Coloring & Highlight\n• Smoothing & Rebonding\n• Perm & Curling\n• Hair Treatment\n• Hair Extension\n\n🏠 *Home Service:*\n• Semua layanan tersedia\n• Biaya tambahan: Rp 25.000\n• Booking minimal 1 hari sebelumnya\n\n⚡ *Express Service:*\n• Potong & styling cepat\n• Biaya tambahan: Rp 15.000\n• Waktu: 30-45 menit\n\nUntuk melihat harga, ketik: *harga hairstyle*",
                'is_active' => true
            ],
            [
                'keyword' => 'kontak',
                'response' => "📞 *Kontak Wardati Hairstyle*\n\n📱 *WhatsApp:*\n   0812-3456-7890\n   (Respon cepat 24/7)\n\n📞 *Telepon:*\n   0411-1234-5678\n   (Senin-Minggu 09:00-20:00)\n\n📧 *Email:*\n   info@wardati-hairstyle.com\n\n🌐 *Website:*\n   wardati-hairstyle.com\n\n📱 *Social Media:*\n   Instagram: @wardati_hairstyle\n   Facebook: Wardati Hairstyle\n   TikTok: @wardati_hairstyle\n\n💬 *Chat Otomatis:*\n   Ketik *menu* untuk bantuan",
                'is_active' => true
            ],
            [
                'keyword' => 'menu',
                'response' => "🎯 *Menu Bantuan Wardati Hairstyle*\n\nSilakan pilih menu di bawah ini:\n\n📋 *1. List Hairstyle*\n   Ketik: *list hairstyle*\n\n📸 *2. Foto Hairstyle*\n   Ketik: *foto hairstyle*\n\n💰 *3. Harga Hairstyle*\n   Ketik: *harga hairstyle*\n\n📅 *4. Cara Booking*\n   Ketik: *booking*\n\n🕐 *5. Jam Buka*\n   Ketik: *jam buka*\n\n📍 *6. Lokasi*\n   Ketik: *lokasi*\n\n✨ *7. Layanan*\n   Ketik: *layanan*\n\n📞 *8. Kontak*\n   Ketik: *kontak*\n\n💡 *Tips:*\n• Ketik kata kunci untuk respon cepat\n• Untuk pertanyaan khusus, admin akan merespon",
                'is_active' => true
            ]
        ];

        foreach ($defaultMessages as $message) {
            $this->insert($message);
        }
    }
}