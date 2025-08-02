<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'full_name',
        'phone',
        'role',
        'is_active',
        'last_login',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[admins.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[admins.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'full_name' => 'required|min_length[3]|max_length[100]',
        'phone' => 'permit_empty|min_length[10]|max_length[15]',
        'role' => 'required|in_list[super_admin,admin,moderator]',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required.',
            'min_length' => 'Username must be at least 3 characters long.',
            'max_length' => 'Username cannot exceed 50 characters.',
            'is_unique' => 'Username already exists.'
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Please enter a valid email address.',
            'is_unique' => 'Email already exists.'
        ],
        'password' => [
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 6 characters long.'
        ],
        'full_name' => [
            'required' => 'Full name is required.',
            'min_length' => 'Full name must be at least 3 characters long.',
            'max_length' => 'Full name cannot exceed 100 characters.'
        ],
        'phone' => [
            'min_length' => 'Phone number must be at least 10 digits.',
            'max_length' => 'Phone number cannot exceed 15 digits.'
        ],
        'role' => [
            'required' => 'Role is required.',
            'in_list' => 'Please select a valid role.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get all admins with optional filtering
     */
    public function getAllAdmins($filters = [])
    {
        $builder = $this->builder();
        
        // Apply filters
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                ->like('username', $search)
                ->orLike('email', $search)
                ->orLike('full_name', $search)
                ->groupEnd();
        }
        
        if (isset($filters['role']) && $filters['role'] !== '') {
            $builder->where('role', $filters['role']);
        }
        
        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('is_active', $filters['status']);
        }
        
        return $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get active admins only
     */
    public function getActiveAdmins()
    {
        return $this->where('is_active', 1)->findAll();
    }

    /**
     * Get admin by username
     */
    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get admin by email
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Authenticate admin
     */
    public function authenticate($username, $password)
    {
        $admin = $this->where('username', $username)
                     ->where('is_active', 1)
                     ->first();
        
        if ($admin && password_verify($password, $admin['password'])) {
            // Update last login
            $this->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $admin;
        }
        
        return false;
    }

    /**
     * Get admin roles
     */
    public function getRoles()
    {
        return [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'moderator' => 'Moderator'
        ];
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName($role)
    {
        $roles = $this->getRoles();
        return isset($roles[$role]) ? $roles[$role] : $role;
    }

    /**
     * Insert default admin if none exists
     */
    public function insertDefaultAdmin()
    {
        $count = $this->countAll();
        
        if ($count == 0) {
            $data = [
                'username' => 'admin',
                'email' => 'admin@wardati.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Super Administrator',
                'phone' => '081234567890',
                'role' => 'super_admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            return $this->insert($data);
        }
        
        return false;
    }

    /**
     * Check if admin can perform action based on role
     */
    public function canPerformAction($adminId, $action)
    {
        $admin = $this->find($adminId);
        
        if (!$admin) {
            return false;
        }
        
        $rolePermissions = [
            'super_admin' => ['all'],
            'admin' => ['manage_admins', 'manage_content', 'view_reports'],
            'moderator' => ['view_reports', 'moderate_content']
        ];
        
        $permissions = $rolePermissions[$admin['role']] ?? [];
        
        return in_array('all', $permissions) || in_array($action, $permissions);
    }
}