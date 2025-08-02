<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'description', 'is_active', 'sort_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'description' => 'max_length[255]',
        'is_active' => 'required|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama kategori harus diisi',
            'min_length' => 'Nama kategori minimal 2 karakter',
            'max_length' => 'Nama kategori maksimal 100 karakter',
        ],
        'description' => [
            'max_length' => 'Deskripsi maksimal 255 karakter',
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

    public function getAllCategories()
    {
        return $this->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getActiveCategories()
    {
        return $this->where('is_active', true)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function insertDefaultCategories()
    {
        $defaultCategories = [
            [
                'name' => 'Potong Rambut Pria',
                'description' => 'Berbagai gaya potong rambut untuk pria',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Potong Rambut Wanita',
                'description' => 'Berbagai gaya potong rambut untuk wanita',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Styling',
                'description' => 'Layanan styling rambut',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Perawatan Rambut',
                'description' => 'Layanan perawatan dan treatment rambut',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Makeup',
                'description' => 'Layanan makeup dan riasan',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Hair Coloring',
                'description' => 'Layanan pewarnaan rambut',
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($defaultCategories as $category) {
            $this->insert($category);
        }
    }
}