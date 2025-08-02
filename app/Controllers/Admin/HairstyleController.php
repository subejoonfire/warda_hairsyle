<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HairstyleModel;
use App\Models\CategoryModel;

class HairstyleController extends BaseController
{
    protected $hairstyleModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->hairstyleModel = new HairstyleModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Kelola Hairstyles',
            'hairstyles' => $this->hairstyleModel->getAllHairstyles(),
            'categories' => $this->categoryModel->getAllCategories()
        ];

        return view('admin/hairstyles/index', $data);
    }

    public function create()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'category_id' => $this->request->getPost('category_id') ?: null,
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                'image_url' => $this->request->getPost('image_url'),
                'duration_minutes' => $this->request->getPost('duration_minutes') ?: 60,
                'difficulty_level' => $this->request->getPost('difficulty_level') ?: 'medium',
                'tags' => $this->request->getPost('tags'),
                'sort_order' => $this->request->getPost('sort_order') ?: 0,
            ];

            if ($this->hairstyleModel->insert($data)) {
                session()->setFlashdata('success', 'Hairstyle berhasil ditambahkan');
                return redirect()->to('/admin/hairstyles');
            } else {
                session()->setFlashdata('errors', $this->hairstyleModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Tambah Hairstyle',
            'categories' => $this->categoryModel->getAllCategories()
        ];

        return view('admin/hairstyles/create', $data);
    }

    public function edit($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $hairstyle = $this->hairstyleModel->find($id);

        if (!$hairstyle) {
            session()->setFlashdata('error', 'Hairstyle tidak ditemukan');
            return redirect()->to('/admin/hairstyles');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'category_id' => $this->request->getPost('category_id') ?: null,
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                'image_url' => $this->request->getPost('image_url'),
                'duration_minutes' => $this->request->getPost('duration_minutes') ?: 60,
                'difficulty_level' => $this->request->getPost('difficulty_level') ?: 'medium',
                'tags' => $this->request->getPost('tags'),
                'sort_order' => $this->request->getPost('sort_order') ?: 0,
            ];

            if ($this->hairstyleModel->update($id, $data)) {
                session()->setFlashdata('success', 'Hairstyle berhasil diperbarui');
                return redirect()->to('/admin/hairstyles');
            } else {
                session()->setFlashdata('errors', $this->hairstyleModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Edit Hairstyle',
            'hairstyle' => $hairstyle,
            'categories' => $this->categoryModel->getAllCategories()
        ];

        return view('admin/hairstyles/edit', $data);
    }

    public function delete($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $hairstyle = $this->hairstyleModel->find($id);
        if (!$hairstyle) {
            session()->setFlashdata('error', 'Hairstyle tidak ditemukan');
            return redirect()->to('/admin/hairstyles');
        }

        if ($this->hairstyleModel->delete($id)) {
            session()->setFlashdata('success', 'Hairstyle berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus hairstyle');
        }

        return redirect()->to('/admin/hairstyles');
    }

    public function toggleStatus($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $hairstyle = $this->hairstyleModel->find($id);
        if (!$hairstyle) {
            return $this->response->setJSON(['success' => false, 'message' => 'Hairstyle tidak ditemukan']);
        }

        $newStatus = $hairstyle['is_active'] ? 0 : 1;
        
        if ($this->hairstyleModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Status berhasil diubah',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah status']);
        }
    }

    public function view($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $hairstyle = $this->hairstyleModel->find($id);
        if (!$hairstyle) {
            session()->setFlashdata('error', 'Hairstyle tidak ditemukan');
            return redirect()->to('/admin/hairstyles');
        }

        $data = [
            'title' => 'Detail Hairstyle',
            'hairstyle' => $hairstyle,
            'category' => $this->categoryModel->find($hairstyle['category_id'])
        ];

        return view('admin/hairstyles/view', $data);
    }

    public function categories()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Kelola Kategori',
            'categories' => $this->categoryModel->getAllCategories()
        ];

        return view('admin/hairstyles/categories', $data);
    }

    public function createCategory()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                'sort_order' => $this->request->getPost('sort_order') ?: 0,
            ];

            if ($this->categoryModel->insert($data)) {
                session()->setFlashdata('success', 'Kategori berhasil ditambahkan');
                return redirect()->to('/admin/hairstyles/categories');
            } else {
                session()->setFlashdata('errors', $this->categoryModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Tambah Kategori'
        ];

        return view('admin/hairstyles/create_category', $data);
    }

    public function editCategory($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan');
            return redirect()->to('/admin/hairstyles/categories');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                'sort_order' => $this->request->getPost('sort_order') ?: 0,
            ];

            if ($this->categoryModel->update($id, $data)) {
                session()->setFlashdata('success', 'Kategori berhasil diperbarui');
                return redirect()->to('/admin/hairstyles/categories');
            } else {
                session()->setFlashdata('errors', $this->categoryModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];

        return view('admin/hairstyles/edit_category', $data);
    }

    public function deleteCategory($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan');
            return redirect()->to('/admin/hairstyles/categories');
        }

        // Check if category is used by any hairstyles
        $hairstylesInCategory = $this->hairstyleModel->where('category_id', $id)->countAllResults();
        if ($hairstylesInCategory > 0) {
            session()->setFlashdata('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $hairstylesInCategory . ' hairstyle');
            return redirect()->to('/admin/hairstyles/categories');
        }

        if ($this->categoryModel->delete($id)) {
            session()->setFlashdata('success', 'Kategori berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kategori');
        }

        return redirect()->to('/admin/hairstyles/categories');
    }
}