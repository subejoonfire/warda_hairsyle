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
        'name', 'description', 'price', 'category_id', 'image_url', 'is_active', 
        'duration_minutes', 'difficulty_level', 'tags', 'sort_order'
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
        'category_id' => 'permit_empty|integer',
        'duration_minutes' => 'permit_empty|integer|greater_than[0]',
        'difficulty_level' => 'permit_empty|in_list[easy,medium,hard]',
        'tags' => 'permit_empty|max_length[500]',
        'sort_order' => 'permit_empty|integer',
        'is_active' => 'required|in_list[0,1]',
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
        'category_id' => [
            'integer' => 'Kategori harus berupa angka',
        ],
        'duration_minutes' => [
            'integer' => 'Durasi harus berupa angka',
            'greater_than' => 'Durasi harus lebih dari 0',
        ],
        'difficulty_level' => [
            'in_list' => 'Level kesulitan harus easy, medium, atau hard',
        ],
        'tags' => [
            'max_length' => 'Tags maksimal 500 karakter',
        ],
        'sort_order' => [
            'integer' => 'Sort order harus berupa angka',
        ],
        'is_active' => [
            'required' => 'Status aktif harus diisi',
            'in_list' => 'Status aktif harus 0 atau 1',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveHairstyles()
    {
        return $this->where('is_active', true)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getAllHairstyles()
    {
        return $this->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                   ->where('is_active', true)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function searchHairstyles($keyword)
    {
        return $this->like('name', $keyword)
                   ->orLike('description', $keyword)
                   ->where('is_active', true)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function getCategories()
    {
        $categoryModel = new CategoryModel();
        return $categoryModel->getActiveCategories();
    }

    public function getHairstylesWithCategory()
    {
        return $this->select('hairstyles.*, categories.name as category_name')
                   ->join('categories', 'categories.id = hairstyles.category_id', 'left')
                   ->orderBy('hairstyles.sort_order', 'ASC')
                   ->orderBy('hairstyles.name', 'ASC')
                   ->findAll();
    }
}