<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'admin_id', 'message', 'sender_type', 'is_read'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'message' => 'required|min_length[1]',
        'sender_type' => 'required|in_list[customer,admin]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID harus diisi',
            'integer' => 'User ID harus berupa angka',
        ],
        'message' => [
            'required' => 'Pesan harus diisi',
            'min_length' => 'Pesan minimal 1 karakter',
        ],
        'sender_type' => [
            'required' => 'Tipe pengirim harus diisi',
            'in_list' => 'Tipe pengirim harus customer atau admin',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getUserChats($userId, $limit = 50)
    {
        return $this->select('chats.*, users.name as sender_name')
                   ->join('users', 'users.id = chats.user_id', 'left')
                   ->where('chats.user_id', $userId)
                   ->orderBy('chats.created_at', 'ASC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getUnreadChats($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('is_read', false)
                   ->where('sender_type', 'admin')
                   ->countAllResults();
    }

    public function markAsRead($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('sender_type', 'admin')
                   ->set(['is_read' => true])
                   ->update();
    }

    public function getRecentChatsForAdmin()
    {
        // Simple approach: just get the latest 10 customer messages
        return $this->select('chats.*, users.name as customer_name, users.whatsapp as customer_whatsapp')
                   ->join('users', 'users.id = chats.user_id')
                   ->where('chats.sender_type', 'customer')
                   ->orderBy('chats.created_at', 'DESC')
                   ->limit(10)
                   ->findAll();
    }

    public function getCustomerChats($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('sender_type', 'customer')
                   ->orderBy('created_at', 'DESC')
                   ->limit(1)
                   ->first();
    }

    public function sendCustomerMessage($userId, $message)
    {
        return $this->insert([
            'user_id' => $userId,
            'message' => $message,
            'sender_type' => 'customer',
            'is_read' => false,
        ]);
    }

    public function sendAdminMessage($userId, $adminId, $message)
    {
        return $this->insert([
            'user_id' => $userId,
            'admin_id' => $adminId,
            'message' => $message,
            'sender_type' => 'admin',
            'is_read' => false,
        ]);
    }
}