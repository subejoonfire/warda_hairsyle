<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuickMessageModel;
use App\Models\QuickMessageResponseModel;

class QuickMessageController extends BaseController
{
    protected $quickMessageModel;
    protected $quickMessageResponseModel;

    public function __construct()
    {
        $this->quickMessageModel = new QuickMessageModel();
        $this->quickMessageResponseModel = new QuickMessageResponseModel();
    }

    public function index()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'quick_messages' => $this->quickMessageModel->getActiveQuickMessages(),
            'responses' => $this->quickMessageResponseModel->getActiveResponses()
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
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            if ($this->quickMessageModel->insert($data)) {
                $quickMessageId = $this->quickMessageModel->insertID();
                
                // Create response for this quick message
                $responseData = [
                    'quick_message_id' => $quickMessageId,
                    'response_type' => $this->request->getPost('response_type'),
                    'response_content' => $this->request->getPost('response_content'),
                    'is_active' => 1,
                ];

                $this->quickMessageResponseModel->insert($responseData);

                session()->setFlashdata('success', 'Quick message berhasil ditambahkan');
                return redirect()->to('/admin/quick-messages');
            } else {
                session()->setFlashdata('errors', $this->quickMessageModel->errors());
                return redirect()->back()->withInput();
            }
        }

        return view('admin/quick_messages/create');
    }

    public function edit($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $quickMessage = $this->quickMessageModel->find($id);
        $response = $this->quickMessageResponseModel->getResponseByQuickMessageId($id);

        if (!$quickMessage) {
            session()->setFlashdata('error', 'Quick message tidak ditemukan');
            return redirect()->to('/admin/quick-messages');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'keyword' => $this->request->getPost('keyword'),
                'description' => $this->request->getPost('description'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            if ($this->quickMessageModel->update($id, $data)) {
                // Update response
                $responseData = [
                    'response_type' => $this->request->getPost('response_type'),
                    'response_content' => $this->request->getPost('response_content'),
                    'is_active' => $this->request->getPost('response_active') ? 1 : 0,
                ];

                if ($response) {
                    $this->quickMessageResponseModel->update($response['id'], $responseData);
                } else {
                    $responseData['quick_message_id'] = $id;
                    $this->quickMessageResponseModel->insert($responseData);
                }

                session()->setFlashdata('success', 'Quick message berhasil diperbarui');
                return redirect()->to('/admin/quick-messages');
            } else {
                session()->setFlashdata('errors', $this->quickMessageModel->errors());
                return redirect()->back()->withInput();
            }
        }

        return view('admin/quick_messages/edit', [
            'quick_message' => $quickMessage,
            'response' => $response
        ]);
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

        // Soft delete by setting is_active to false
        if ($this->quickMessageModel->update($id, ['is_active' => 0])) {
            // Also deactivate the response
            $response = $this->quickMessageResponseModel->getResponseByQuickMessageId($id);
            if ($response) {
                $this->quickMessageResponseModel->update($response['id'], ['is_active' => 0]);
            }

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
        $response = $this->quickMessageResponseModel->getResponseByQuickMessageId($id);

        if (!$quickMessage || !$response) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $previewContent = '';
        
        if ($response['response_type'] === 'static') {
            $previewContent = $response['response_content'];
        } else {
            // For dynamic responses, we need to generate content based on the keyword
            $previewContent = $this->generateDynamicResponse($quickMessage['keyword']);
        }

        return $this->response->setJSON([
            'success' => true,
            'preview' => $previewContent
        ]);
    }

    private function generateDynamicResponse($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        switch ($keyword) {
            case 'list hairstyle':
                return $this->generateHairstyleList();
            case 'harga hairstyle':
                return $this->generateHairstylePrices();
            default:
                return 'Response dinamis untuk: ' . $keyword;
        }
    }

    private function generateHairstyleList()
    {
        $hairstyleModel = new \App\Models\HairstyleModel();
        $hairstyles = $hairstyleModel->getActiveHairstyles();
        
        $response = "Daftar Hairstyle Wardati\n\n";
        
        if (empty($hairstyles)) {
            $response .= "Tidak ada hairstyle yang tersedia saat ini\n\n";
        } else {
            $response .= "Hairstyle Tersedia:\n";
            foreach ($hairstyles as $hairstyle) {
                $response .= "- {$hairstyle['name']} - Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
                $response .= "  {$hairstyle['description']}\n\n";
            }
        }
        
        $response .= "Untuk melihat foto, ketik: foto hairstyle\n";
        $response .= "Untuk melihat harga, ketik: harga hairstyle\n";
        $response .= "Untuk booking, ketik: booking";
        
        return $response;
    }

    private function generateHairstylePrices()
    {
        $hairstyleModel = new \App\Models\HairstyleModel();
        $hairstyles = $hairstyleModel->getActiveHairstyles();
        
        $response = "Harga Hairstyle Wardati\n\n";
        
        if (empty($hairstyles)) {
            $response .= "Tidak ada hairstyle yang tersedia saat ini\n\n";
        } else {
            $response .= "Layanan Utama:\n";
            foreach ($hairstyles as $hairstyle) {
                $response .= "- {$hairstyle['name']}: Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
            }
            $response .= "\n";
        }
        
        $response .= "Layanan Tambahan:\n";
        $response .= "- Home Service: +Rp 25.000\n";
        $response .= "- Express Service: +Rp 15.000\n";
        $response .= "- Hair Treatment: +Rp 30.000\n";
        $response .= "- Coloring: +Rp 50.000\n\n";
        
        $response .= "Paket Promo:\n";
        $response .= "- Paket Wedding: Potong + Styling + Makeup\n";
        $response .= "- Paket Family: 3-5 orang (Diskon 20%)\n";
        $response .= "- Paket Student: Potong + Styling (Diskon 15%)\n\n";
        
        $response .= "Untuk booking, ketik: booking\n";
        $response .= "Untuk melihat daftar lengkap, ketik: list hairstyle";
        
        return $response;
    }
}