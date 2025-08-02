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
        'quick_message_id', 'response_text', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'quick_message_id' => 'required|integer',
        'response_text' => 'required|min_length[1]',
    ];

    protected $validationMessages = [
        'quick_message_id' => [
            'required' => 'Quick message ID harus diisi',
            'integer' => 'Quick message ID harus berupa angka',
        ],
        'response_text' => [
            'required' => 'Response text harus diisi',
            'min_length' => 'Response text minimal 1 karakter',
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

    public function getAllResponses()
    {
        return $this->select('quick_message_responses.*, quick_messages.keyword')
                   ->join('quick_messages', 'quick_messages.id = quick_message_responses.quick_message_id')
                   ->where('quick_message_responses.is_active', true)
                   ->findAll();
    }
}