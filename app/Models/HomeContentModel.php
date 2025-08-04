<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeContentModel extends Model
{
    protected $table            = 'home_content';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'section',
        'title',
        'description',
        'icon',
        'order_position',
        'is_active'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'section'     => 'required|max_length[50]',
        'title'       => 'required|max_length[255]',
        'description' => 'permit_empty',
        'icon'        => 'permit_empty|max_length[100]',
        'order_position' => 'permit_empty|integer',
        'is_active'   => 'permit_empty|in_list[0,1]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getBySection($section)
    {
        return $this->where('section', $section)
                    ->where('is_active', 1)
                    ->orderBy('order_position', 'ASC')
                    ->findAll();
    }

    public function getActiveContent()
    {
        return $this->where('is_active', 1)
                    ->orderBy('section', 'ASC')
                    ->orderBy('order_position', 'ASC')
                    ->findAll();
    }

    public function updateOrder($id, $position)
    {
        return $this->update($id, ['order_position' => $position]);
    }

    public function toggleActive($id)
    {
        $content = $this->find($id);
        if ($content) {
            return $this->update($id, ['is_active' => $content['is_active'] ? 0 : 1]);
        }
        return false;
    }
}