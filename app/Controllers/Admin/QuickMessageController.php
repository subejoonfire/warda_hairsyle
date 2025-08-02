<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuickMessageModel;

class QuickMessageController extends BaseController
{
    protected $quickMessageModel;

    public function __construct()
    {
        $this->quickMessageModel = new QuickMessageModel();
    }

    public function index()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Kelola Quick Messages',
            'quick_messages' => $this->quickMessageModel->getAllQuickMessages(),
            'response_sources' => $this->quickMessageModel->getResponseSources()
        ];

        return view('admin/quick_messages/index', $data);
    }

    public function create()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'keyword' => $this->request->getPost('keyword'),
                'description' => $this->request->getPost('description'),
                'response_type' => $this->request->getPost('response_type'),
                'response_source' => $this->request->getPost('response_source') ?: null,
                'response_template' => $this->request->getPost('response_template') ?: null,
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                'sort_order' => $this->request->getPost('sort_order') ?: 0,
            ];

            if ($this->quickMessageModel->insert($data)) {
                session()->setFlashdata('success', 'Quick message berhasil ditambahkan');
                return redirect()->to('/admin/quick-messages');
            } else {
                session()->setFlashdata('errors', $this->quickMessageModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Tambah Quick Message',
            'response_sources' => $this->quickMessageModel->getResponseSources()
        ];

        return view('admin/quick_messages/create', $data);
    }

    public function edit($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $quickMessage = $this->quickMessageModel->find($id);

        if (!$quickMessage) {
            session()->setFlashdata('error', 'Quick message tidak ditemukan');
            return redirect()->to('/admin/quick-messages');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'keyword' => $this->request->getPost('keyword'),
                'description' => $this->request->getPost('description'),
                'response_type' => $this->request->getPost('response_type'),
                'response_source' => $this->request->getPost('response_source') ?: null,
                'response_template' => $this->request->getPost('response_template') ?: null,
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                'sort_order' => $this->request->getPost('sort_order') ?: 0,
            ];

            if ($this->quickMessageModel->update($id, $data)) {
                session()->setFlashdata('success', 'Quick message berhasil diperbarui');
                return redirect()->to('/admin/quick-messages');
            } else {
                session()->setFlashdata('errors', $this->quickMessageModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Edit Quick Message',
            'quick_message' => $quickMessage,
            'response_sources' => $this->quickMessageModel->getResponseSources()
        ];

        return view('admin/quick_messages/edit', $data);
    }

    public function delete($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $quickMessage = $this->quickMessageModel->find($id);
        if (!$quickMessage) {
            session()->setFlashdata('error', 'Quick message tidak ditemukan');
            return redirect()->to('/admin/quick-messages');
        }

        if ($this->quickMessageModel->delete($id)) {
            session()->setFlashdata('success', 'Quick message berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus quick message');
        }

        return redirect()->to('/admin/quick-messages');
    }

    public function toggleStatus($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $quickMessage = $this->quickMessageModel->find($id);
        if (!$quickMessage) {
            return $this->response->setJSON(['success' => false, 'message' => 'Quick message tidak ditemukan']);
        }

        $newStatus = $quickMessage['is_active'] ? 0 : 1;
        
        if ($this->quickMessageModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Status berhasil diubah',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah status']);
        }
    }

    public function preview($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $quickMessage = $this->quickMessageModel->find($id);

        if (!$quickMessage) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $previewContent = $this->quickMessageModel->generateResponse($quickMessage);

        return $this->response->setJSON([
            'success' => true,
            'preview' => $previewContent
        ]);
    }

    public function testResponse()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $responseType = $this->request->getPost('response_type');
        $responseSource = $this->request->getPost('response_source');
        $responseTemplate = $this->request->getPost('response_template');

        $testData = [
            'response_type' => $responseType,
            'response_source' => $responseSource,
            'response_template' => $responseTemplate
        ];

        $previewContent = $this->quickMessageModel->generateResponse($testData);

        return $this->response->setJSON([
            'success' => true,
            'preview' => $previewContent
        ]);
    }

    public function getResponseSources()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $sources = $this->quickMessageModel->getResponseSources();

        return $this->response->setJSON([
            'success' => true,
            'sources' => $sources
        ]);
    }
}