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
        'keyword', 'description', 'response_type', 'response_source', 
        'response_template', 'is_active', 'sort_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'keyword' => 'required|min_length[2]|max_length[100]',
        'description' => 'max_length[255]',
        'response_type' => 'required|in_list[static,dynamic,template]',
        'response_source' => 'permit_empty|max_length[100]',
        'response_template' => 'permit_empty',
        'is_active' => 'required|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'keyword' => [
            'required' => 'Kata kunci harus diisi',
            'min_length' => 'Kata kunci minimal 2 karakter',
            'max_length' => 'Kata kunci maksimal 100 karakter',
        ],
        'description' => [
            'max_length' => 'Deskripsi maksimal 255 karakter',
        ],
        'response_type' => [
            'required' => 'Tipe response harus diisi',
            'in_list' => 'Tipe response harus static, dynamic, atau template',
        ],
        'response_source' => [
            'max_length' => 'Source response maksimal 100 karakter',
        ],
        'is_active' => [
            'required' => 'Status aktif harus diisi',
            'in_list' => 'Status aktif harus 0 atau 1',
        ],
        'sort_order' => [
            'integer' => 'Sort order harus berupa angka',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveQuickMessages()
    {
        return $this->where('is_active', true)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('keyword', 'ASC')
                   ->findAll();
    }

    public function getAllQuickMessages()
    {
        return $this->orderBy('sort_order', 'ASC')
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

    public function getResponseSources()
    {
        return [
            'hairstyles' => 'Daftar Hairstyle',
            'hairstyle_prices' => 'Harga Hairstyle',
            'categories' => 'Kategori Hairstyle',
            'custom' => 'Custom Response',
        ];
    }

    public function generateResponse($quickMessage)
    {
        switch ($quickMessage['response_type']) {
            case 'static':
                return $quickMessage['response_template'];
                
            case 'dynamic':
                return $this->generateDynamicResponse($quickMessage['response_source']);
                
            case 'template':
                return $this->generateTemplateResponse($quickMessage['response_template'], $quickMessage['response_source']);
                
            default:
                return 'Response tidak tersedia';
        }
    }

    private function generateDynamicResponse($source)
    {
        switch ($source) {
            case 'hairstyles':
                return $this->generateHairstyleList();
                
            case 'hairstyle_prices':
                return $this->generateHairstylePrices();
                
            case 'categories':
                return $this->generateCategories();
                
            default:
                return 'Data tidak tersedia';
        }
    }

    private function generateTemplateResponse($template, $source)
    {
        $data = $this->getDataFromSource($source);
        return $this->parseTemplate($template, $data);
    }

    private function getDataFromSource($source)
    {
        switch ($source) {
            case 'hairstyles':
                $hairstyleModel = new \App\Models\HairstyleModel();
                return $hairstyleModel->getActiveHairstyles();
                
            case 'hairstyle_prices':
                $hairstyleModel = new \App\Models\HairstyleModel();
                return $hairstyleModel->getActiveHairstyles();
                
            case 'categories':
                $hairstyleModel = new \App\Models\HairstyleModel();
                return $hairstyleModel->getCategories();
                
            default:
                return [];
        }
    }

    private function parseTemplate($template, $data)
    {
        // Replace placeholders with actual data
        $response = $template;
        
        if (strpos($response, '{hairstyle_list}') !== false) {
            $hairstyleList = '';
            foreach ($data as $hairstyle) {
                $hairstyleList .= "- {$hairstyle['name']} - Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
            }
            $response = str_replace('{hairstyle_list}', $hairstyleList, $response);
        }
        
        if (strpos($response, '{price_list}') !== false) {
            $priceList = '';
            foreach ($data as $hairstyle) {
                $priceList .= "- {$hairstyle['name']}: Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
            }
            $response = str_replace('{price_list}', $priceList, $response);
        }
        
        if (strpos($response, '{category_list}') !== false) {
            $categoryList = '';
            foreach ($data as $category) {
                $categoryList .= "- {$category['name']}\n";
            }
            $response = str_replace('{category_list}', $categoryList, $response);
        }
        
        return $response;
    }

    private function generateHairstyleList()
    {
        $hairstyleModel = new \App\Models\HairstyleModel();
        $hairstyles = $hairstyleModel->getActiveHairstyles();
        
        $response = "Daftar Hairstyle Wardati\n\n";
        
        if (empty($hairstyles)) {
            $response .= "Tidak ada hairstyle yang tersedia saat ini\n\n";
        } else {
            $response .= "Hairstyle Tersedia:\n";
            foreach ($hairstyles as $hairstyle) {
                $response .= "- {$hairstyle['name']} - Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
                if (!empty($hairstyle['description'])) {
                    $response .= "  {$hairstyle['description']}\n";
                }
                $response .= "\n";
            }
        }
        
        $response .= "Untuk melihat foto, ketik: foto hairstyle\n";
        $response .= "Untuk melihat harga, ketik: harga hairstyle\n";
        $response .= "Untuk booking, ketik: booking";
        
        return $response;
    }

    private function generateHairstylePrices()
    {
        $hairstyleModel = new \App\Models\HairstyleModel();
        $hairstyles = $hairstyleModel->getActiveHairstyles();
        
        $response = "Harga Hairstyle Wardati\n\n";
        
        if (empty($hairstyles)) {
            $response .= "Tidak ada hairstyle yang tersedia saat ini\n\n";
        } else {
            $response .= "Layanan Utama:\n";
            foreach ($hairstyles as $hairstyle) {
                $response .= "- {$hairstyle['name']}: Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
            }
            $response .= "\n";
        }
        
        $response .= "Untuk booking, ketik: booking\n";
        $response .= "Untuk melihat daftar lengkap, ketik: list hairstyle";
        
        return $response;
    }

    private function generateCategories()
    {
        $hairstyleModel = new \App\Models\HairstyleModel();
        $categories = $hairstyleModel->getCategories();
        
        $response = "Kategori Hairstyle Wardati\n\n";
        
        if (empty($categories)) {
            $response .= "Tidak ada kategori yang tersedia saat ini\n\n";
        } else {
            $response .= "Kategori Tersedia:\n";
            foreach ($categories as $category) {
                $response .= "- {$category['name']}\n";
            }
            $response .= "\n";
        }
        
        $response .= "Untuk melihat daftar hairstyle, ketik: list hairstyle\n";
        $response .= "Untuk booking, ketik: booking";
        
        return $response;
    }

    public function insertDefaultQuickMessages()
    {
        $defaultMessages = [
            [
                'keyword' => 'list hairstyle',
                'description' => 'Daftar hairstyle yang tersedia',
                'response_type' => 'dynamic',
                'response_source' => 'hairstyles',
                'response_template' => null,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'keyword' => 'harga hairstyle',
                'description' => 'Informasi harga layanan',
                'response_type' => 'dynamic',
                'response_source' => 'hairstyle_prices',
                'response_template' => null,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'keyword' => 'jam buka',
                'description' => 'Jam operasional salon',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Jam Buka Wardati Hairstyle\n\nSenin - Jumat:\n09:00 - 20:00 WIB\n\nSabtu - Minggu:\n08:00 - 21:00 WIB\n\nHari Libur Nasional:\n10:00 - 18:00 WIB\n\nCatatan:\n- Booking terakhir 2 jam sebelum tutup\n- Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n- Untuk booking mendesak, hubungi langsung\n\nUntuk booking, ketik: booking",
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'keyword' => 'lokasi',
                'description' => 'Lokasi salon dan home service',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Lokasi Wardati Hairstyle\n\nSalon Utama:\nJl. Raya Wardati No. 123\nJakarta Selatan, DKI Jakarta\nGoogle Maps: bit.ly/wardati-salon\n\nAkses:\n- 5 menit dari Stasiun MRT Blok M\n- 10 menit dari Mall Blok M Square\n- Tersedia parkir motor & mobil\n\nTransportasi Umum:\n- MRT: Stasiun Blok M\n- TransJakarta: Halte Blok M\n- Angkot: 02, 05, 08\n\nHome Service:\nTersedia untuk area Jakarta Selatan\nBiaya tambahan: Rp 25.000\n\nUntuk booking, ketik: booking",
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'keyword' => 'layanan',
                'description' => 'Jenis layanan yang tersedia',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Layanan Wardati Hairstyle\n\nPotong Rambut:\n- Potong Pria (Semua Gaya)\n- Potong Wanita (Semua Gaya)\n- Potong Anak-anak\n- Potong Rambut Panjang\n\nStyling & Makeup:\n- Styling Rambut\n- Makeup Natural\n- Makeup Glamour\n- Makeup Wedding\n\nPerawatan Rambut:\n- Hair Treatment\n- Hair Coloring\n- Hair Smoothing\n- Hair Rebonding\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking",
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'keyword' => 'kontak',
                'description' => 'Informasi kontak lengkap',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Kontak Wardati Hairstyle\n\nWhatsApp:\n0812-3456-7890\n\nTelepon:\n021-1234-5678\n\nEmail:\ninfo@wardati-hairstyle.com\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nWebsite:\nwardati-hairstyle.com\n\nUntuk booking, ketik: booking\nUntuk melihat lokasi, ketik: lokasi",
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'keyword' => 'booking',
                'description' => 'Cara melakukan booking',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Cara Booking Wardati Hairstyle\n\n1. Melalui Website:\n   Kunjungi: wardati-hairstyle.com\n   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n2. Melalui WhatsApp:\n   Kirim pesan dengan format:\n   BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]\n   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n3. Melalui Telepon:\n   Hubungi: 0812-3456-7890\n\nInformasi yang diperlukan:\n- Nama lengkap\n- Nomor WhatsApp\n- Alamat (untuk home service)\n- Catatan khusus\n\nUntuk melihat daftar hairstyle, ketik: list hairstyle",
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'keyword' => 'menu',
                'description' => 'Menu bantuan lengkap',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Menu Bantuan Wardati Hairstyle\n\nInformasi Layanan:\n- list hairstyle - Daftar hairstyle\n- harga hairstyle - Harga layanan\n- foto hairstyle - Galeri foto\n- layanan - Jenis layanan\n\nInformasi Booking:\n- booking - Cara booking\n- jam buka - Jam operasional\n- lokasi - Lokasi salon\n\nKontak & Support:\n- kontak - Informasi kontak\n- menu - Menu bantuan ini\n\nTips:\n- Ketik kata kunci yang diinginkan\n- Admin akan merespon dalam waktu singkat\n- Untuk pertanyaan khusus, admin akan membantu\n\nUntuk booking, ketik: booking",
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'keyword' => 'foto hairstyle',
                'description' => 'Link foto hairstyle',
                'response_type' => 'static',
                'response_source' => null,
                'response_template' => "Foto Hairstyle Wardati\n\nGaleri Foto:\n- Pompadour Classic: wardati.com/pompadour\n- Undercut Modern: wardati.com/undercut\n- Fade Style: wardati.com/fade\n- Quiff Style: wardati.com/quiff\n- Buzz Cut: wardati.com/buzz\n- Side Part: wardati.com/sidepart\n\nSocial Media:\n- Instagram: @wardati_hairstyle\n- Facebook: Wardati Hairstyle\n- TikTok: @wardati_hairstyle\n\nUntuk melihat harga, ketik: harga hairstyle\nUntuk booking, ketik: booking",
                'is_active' => true,
                'sort_order' => 9
            ]
        ];

        foreach ($defaultMessages as $message) {
            $this->insert($message);
        }
    }
}