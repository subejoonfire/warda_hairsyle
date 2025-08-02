<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AdminController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Management',
            'admins' => $this->adminModel->getAllAdmins()
        ];

        return view('admin/admins/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Admin'
        ];

        return view('admin/admins/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[admins.username]',
            'email' => 'required|valid_email|is_unique[admins.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'phone' => 'permit_empty|min_length[10]|max_length[15]',
            'role' => 'required|in_list[super_admin,admin,moderator]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'role' => $this->request->getPost('role'),
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->adminModel->insert($data)) {
            return redirect()->to('/admin/admins')->with('success', 'Admin created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create admin. Please try again.');
        }
    }

    public function edit($id = null)
    {
        $admin = $this->adminModel->find($id);
        
        if (!$admin) {
            return redirect()->to('/admin/admins')->with('error', 'Admin not found.');
        }

        $data = [
            'title' => 'Edit Admin',
            'admin' => $admin
        ];

        return view('admin/admins/edit', $data);
    }

    public function update($id = null)
    {
        $admin = $this->adminModel->find($id);
        
        if (!$admin) {
            return redirect()->to('/admin/admins')->with('error', 'Admin not found.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[admins.username,id,' . $id . ']',
            'email' => 'required|valid_email|is_unique[admins.email,id,' . $id . ']',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'phone' => 'permit_empty|min_length[10]|max_length[15]',
            'role' => 'required|in_list[super_admin,admin,moderator]'
        ];

        // Password is optional for updates
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'role' => $this->request->getPost('role'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update password only if provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->adminModel->update($id, $data)) {
            return redirect()->to('/admin/admins')->with('success', 'Admin updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update admin. Please try again.');
        }
    }

    public function delete($id = null)
    {
        $admin = $this->adminModel->find($id);
        
        if (!$admin) {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin not found.']);
        }

        // Prevent deleting own account
        if ($id == session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'You cannot delete your own account.']);
        }

        if ($this->adminModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Admin deleted successfully!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete admin.']);
        }
    }

    public function toggleStatus($id = null)
    {
        $admin = $this->adminModel->find($id);
        
        if (!$admin) {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin not found.']);
        }

        // Prevent deactivating own account
        if ($id == session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'You cannot deactivate your own account.']);
        }

        $newStatus = $admin['is_active'] ? 0 : 1;
        
        if ($this->adminModel->update($id, ['is_active' => $newStatus])) {
            $statusText = $newStatus ? 'activated' : 'deactivated';
            return $this->response->setJSON(['success' => true, 'message' => "Admin {$statusText} successfully!"]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update admin status.']);
        }
    }

    public function view($id = null)
    {
        $admin = $this->adminModel->find($id);
        
        if (!$admin) {
            return redirect()->to('/admin/admins')->with('error', 'Admin not found.');
        }

        $data = [
            'title' => 'Admin Details',
            'admin' => $admin
        ];

        return view('admin/admins/view', $data);
    }
}