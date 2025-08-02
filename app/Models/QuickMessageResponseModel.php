<?php

namespace App\Models;

use CodeIgniter\Model;

class QuickMessageResponseModel extends Model
{
    protected $table = 'quick_message_responses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'quick_message_id', 'response_type', 'response_content', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'quick_message_id' => 'required|integer',
        'response_type' => 'required|in_list[static,dynamic]',
        'response_content' => 'permit_empty',
        'is_active' => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'quick_message_id' => [
            'required' => 'ID quick message harus diisi',
            'integer' => 'ID quick message harus berupa angka',
        ],
        'response_type' => [
            'required' => 'Tipe response harus diisi',
            'in_list' => 'Tipe response harus static atau dynamic',
        ],
        'is_active' => [
            'required' => 'Status aktif harus diisi',
            'in_list' => 'Status aktif harus 0 atau 1',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getResponseByQuickMessageId($quickMessageId)
    {
        return $this->where('quick_message_id', $quickMessageId)
                   ->where('is_active', true)
                   ->first();
    }

    public function getActiveResponses()
    {
        return $this->where('is_active', true)
                   ->findAll();
    }

    public function insertDefaultResponses()
    {
        $defaultResponses = [
            [
                'quick_message_id' => 1, // list hairstyle
                'response_type' => 'dynamic',
                'response_content' => null,
                'is_active' => true
            ],
            [
                'quick_message_id' => 2, // harga hairstyle
                'response_type' => 'dynamic',
                'response_content' => null,
                'is_active' => true
            ],
            [
                'quick_message_id' => 3, // jam buka
                'response_type' => 'static',
                'response_content' => "Jam Buka Wardati Hairstyle\n\nSenin - Jumat:\n09:00 - 20:00 WIB\n\nSabtu - Minggu:\n08:00 - 21:00 WIB\n\nHari Libur Nasional:\n10:00 - 18:00 WIB\n\nCatatan:\n- Booking terakhir 2 jam sebelum tutup\n- Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n- Untuk booking mendesak, hubungi langsung\n\nUntuk booking, ketik: booking",
                'is_active' => true
            ],
            [
                'quick_message_id' => 4, // lokasi
                'response_type' => 'static',
                'response_content' => "Lokasi Wardati Hairstyle\n\nSalon Utama:\nJl. Raya Wardati No. 123\nJakarta Selatan, DKI Jakarta\nGoogle Maps: bit.ly/wardati-salon\n\nAkses:\n- 5 menit dari Stasiun MRT Blok M\n- 10 menit dari Mall Blok M Square\n- Tersedia parkir motor & mobil\n\nTransportasi Umum:\n- MRT: Stasiun Blok M\n- TransJakarta: Halte Blok M\n- Angkot: 02, 05, 08\n\nHome Service:\nTersedia untuk area Jakarta Selatan\nBiaya tambahan: Rp 25.000\n\nUntuk booking, ketik: booking",
                'is_active' => true
            ],
            [
                'quick_message_id' => 5, // layanan
                'response_type' => 'static',
                'response_content' => "Layanan Wardati Hairstyle\n\nPotong Rambut:\n- Potong Pria (Semua Gaya)\n- Potong Wanita (Semua Gaya)\n- Potong Anak-anak\n- Potong Rambut Panjang\n\nStyling & Makeup:\n- Styling Rambut\n- Makeup Natural\n- Makeup Glamour\n- Makeup Wedding\n\nPerawatan Rambut:\n- Hair Treatment\n- Hair Coloring\n- Hair Smoothing\n- Hair Rebonding\n\nLayanan Tambahan:\n- Home Service\n- Express Service\n- Wedding Package\n- Family Package\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking",
                'is_active' => true
            ],
            [
                'quick_message_id' => 6, // kontak
                'response_type' => 'static',
                'response_content' => "Kontak Wardati Hairstyle\n\nWhatsApp:\n0812-3456-7890\n\nTelepon:\n021-1234-5678\n\nEmail:\ninfo@wardati-hairstyle.com\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nWebsite:\nwardati-hairstyle.com\n\nUntuk booking, ketik: booking\nUntuk melihat lokasi, ketik: lokasi",
                'is_active' => true
            ],
            [
                'quick_message_id' => 7, // booking
                'response_type' => 'static',
                'response_content' => "Cara Booking Wardati Hairstyle\n\n1. Melalui Website:\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2. Melalui WhatsApp:\n   Kirim pesan dengan format:\n   BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]\n   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n3. Melalui Telepon:\n   Hubungi: 0812-3456-7890\n\nInformasi yang diperlukan:\n- Nama lengkap\n- Nomor WhatsApp\n- Alamat (untuk home service)\n- Catatan khusus\n\nUntuk melihat daftar hairstyle, ketik: list hairstyle",
                'is_active' => true
            ],
            [
                'quick_message_id' => 8, // menu
                'response_type' => 'static',
                'response_content' => "Menu Bantuan Wardati Hairstyle\n\nInformasi Layanan:\n- list hairstyle - Daftar hairstyle\n- harga hairstyle - Harga layanan\n- foto hairstyle - Galeri foto\n- layanan - Jenis layanan\n\nInformasi Booking:\n- booking - Cara booking\n- jam buka - Jam operasional\n- lokasi - Lokasi salon\n\nKontak & Support:\n- kontak - Informasi kontak\n- menu - Menu bantuan ini\n\nTips:\n- Ketik kata kunci yang diinginkan\n- Admin akan merespon dalam waktu singkat\n- Untuk pertanyaan khusus, admin akan membantu\n\nUntuk booking, ketik: booking",
                'is_active' => true
            ],
            [
                'quick_message_id' => 9, // foto hairstyle
                'response_type' => 'static',
                'response_content' => "Foto Hairstyle Wardati\n\nGaleri Foto:\n- Pompadour Classic: wardati.com/pompadour\n- Undercut Modern: wardati.com/undercut\n- Fade Style: wardati.com/fade\n- Quiff Style: wardati.com/quiff\n- Buzz Cut: wardati.com/buzz\n- Side Part: wardati.com/sidepart\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking",
                'is_active' => true
            ]
        ];

        foreach ($defaultResponses as $response) {
            $this->insert($response);
        }
    }
}