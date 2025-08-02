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
        'keyword', 'description', 'is_active'
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
        'is_active' => 'required|in_list[0,1]',
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
                'description' => 'Daftar hairstyle yang tersedia',
                'is_active' => true
            ],
            [
                'keyword' => 'harga hairstyle',
                'description' => 'Informasi harga layanan',
                'is_active' => true
            ],
            [
                'keyword' => 'jam buka',
                'description' => 'Jam operasional salon',
                'is_active' => true
            ],
            [
                'keyword' => 'lokasi',
                'description' => 'Lokasi salon dan home service',
                'is_active' => true
            ],
            [
                'keyword' => 'layanan',
                'description' => 'Jenis layanan yang tersedia',
                'is_active' => true
            ],
            [
                'keyword' => 'kontak',
                'description' => 'Informasi kontak lengkap',
                'is_active' => true
            ],
            [
                'keyword' => 'booking',
                'description' => 'Cara melakukan booking',
                'is_active' => true
            ],
            [
                'keyword' => 'menu',
                'description' => 'Menu bantuan lengkap',
                'is_active' => true
            ],
            [
                'keyword' => 'foto hairstyle',
                'description' => 'Link foto hairstyle',
                'is_active' => true
            ]
        ];

        foreach ($defaultMessages as $message) {
            $this->insert($message);
        }
    }
}