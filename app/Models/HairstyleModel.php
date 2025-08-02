<?php

namespace App\Models;

use CodeIgniter\Model;

class HairstyleModel extends Model
{
    protected $table = 'hairstyles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'description', 'price', 'image', 'category', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'price' => 'required|numeric|greater_than[0]',
        'category' => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama hairstyle harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 255 karakter',
        ],
        'price' => [
            'required' => 'Harga harus diisi',
            'numeric' => 'Harga harus berupa angka',
            'greater_than' => 'Harga harus lebih dari 0',
        ],
        'category' => [
            'required' => 'Kategori harus diisi',
            'max_length' => 'Kategori maksimal 100 karakter',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveHairstyles()
    {
        return $this->where('is_active', true)->findAll();
    }

    public function getByCategory($category)
    {
        return $this->where('category', $category)
                   ->where('is_active', true)
                   ->findAll();
    }

    public function searchHairstyles($keyword)
    {
        return $this->like('name', $keyword)
                   ->orLike('description', $keyword)
                   ->where('is_active', true)
                   ->findAll();
    }

    public function getCategories()
    {
        return $this->distinct()
                   ->select('category')
                   ->where('is_active', true)
                   ->findAll();
    }
}