<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'whatsapp', 'password', 'role', 'is_verified', 
        'verification_code', 'verification_expires', 'profile_image', 'address'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'whatsapp' => 'required|min_length[10]|max_length[20]|is_unique[users.whatsapp,id,{id}]',
        'password' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 255 karakter',
        ],
        'whatsapp' => [
            'required' => 'Nomor WhatsApp harus diisi',
            'min_length' => 'Nomor WhatsApp minimal 10 digit',
            'max_length' => 'Nomor WhatsApp maksimal 20 digit',
            'is_unique' => 'Nomor WhatsApp sudah terdaftar',
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function findByWhatsApp($whatsapp)
    {
        return $this->where('whatsapp', $whatsapp)->first();
    }

    public function createVerificationCode($userId)
    {
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $this->update($userId, [
            'verification_code' => $code,
            'verification_expires' => $expires,
        ]);

        return $code;
    }

    public function verifyCode($userId, $code)
    {
        $user = $this->find($userId);
        
        if (!$user) {
            return false;
        }

        if ($user['verification_code'] !== $code) {
            return false;
        }

        if (strtotime($user['verification_expires']) < time()) {
            return false;
        }

        $this->update($userId, [
            'is_verified' => true,
            'verification_code' => null,
            'verification_expires' => null,
        ]);

        return true;
    }

    public function getCustomers()
    {
        return $this->where('role', 'customer')->findAll();
    }

    public function getAdmins()
    {
        return $this->where('role', 'admin')->findAll();
    }
}