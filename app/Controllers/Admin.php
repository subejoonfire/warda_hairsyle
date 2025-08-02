<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HairstyleModel;
use App\Models\BookingModel;
use App\Models\ChatModel;
use App\Services\WhatsAppService;

class Admin extends BaseController
{
    protected $userModel;
    protected $hairstyleModel;
    protected $bookingModel;
    protected $chatModel;
    protected $whatsappService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->hairstyleModel = new HairstyleModel();
        $this->bookingModel = new BookingModel();
        $this->chatModel = new ChatModel();
        $this->whatsappService = new WhatsAppService();
    }

    public function dashboard()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'total_customers' => $this->userModel->where('role', 'customer')->countAllResults(),
            'total_bookings' => $this->bookingModel->countAllResults(),
            'pending_bookings' => $this->bookingModel->where('status', 'pending')->countAllResults(),
            'today_bookings' => $this->bookingModel->getTodayBookings(),
            'recent_bookings' => $this->bookingModel->getBookingsByStatus('pending'),
        ];

        return view('admin/dashboard', $data);
    }

    public function hairstyles()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'hairstyles' => $this->hairstyleModel->findAll(),
        ];

        return view('admin/hairstyles', $data);
    }

    public function createHairstyle()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'category' => $this->request->getPost('category'),
                'is_active' => $this->request->getPost('is_active') ? true : false,
            ];

            // Handle image upload
            $image = $this->request->getFile('image');
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads/hairstyles', $newName);
                $data['image'] = 'uploads/hairstyles/' . $newName;
            }

            if ($this->hairstyleModel->insert($data)) {
                session()->setFlashdata('success', 'Hairstyle berhasil ditambahkan');
                return redirect()->to('/admin/hairstyles');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan hairstyle');
                return redirect()->back()->withInput();
            }
        }

        return view('admin/hairstyle_form');
    }

    public function editHairstyle($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $hairstyle = $this->hairstyleModel->find($id);
        if (!$hairstyle) {
            session()->setFlashdata('error', 'Hairstyle tidak ditemukan');
            return redirect()->to('/admin/hairstyles');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'category' => $this->request->getPost('category'),
                'is_active' => $this->request->getPost('is_active') ? true : false,
            ];

            // Handle image upload
            $image = $this->request->getFile('image');
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads/hairstyles', $newName);
                $data['image'] = 'uploads/hairstyles/' . $newName;
            }

            if ($this->hairstyleModel->update($id, $data)) {
                session()->setFlashdata('success', 'Hairstyle berhasil diperbarui');
                return redirect()->to('/admin/hairstyles');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui hairstyle');
                return redirect()->back()->withInput();
            }
        }

        return view('admin/hairstyle_form', ['hairstyle' => $hairstyle]);
    }

    public function deleteHairstyle($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->hairstyleModel->delete($id)) {
            session()->setFlashdata('success', 'Hairstyle berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus hairstyle');
        }

        return redirect()->to('/admin/hairstyles');
    }

    public function bookings()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $status = $this->request->getGet('status');
        
        if ($status) {
            $bookings = $this->bookingModel->getBookingsByStatus($status);
        } else {
            $bookings = $this->bookingModel->select('bookings.*, hairstyles.name as hairstyle_name, users.name as customer_name, users.whatsapp as customer_whatsapp')
                                         ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                                         ->join('users', 'users.id = bookings.user_id')
                                         ->orderBy('bookings.created_at', 'DESC')
                                         ->findAll();
        }

        $data = [
            'bookings' => $bookings,
            'selected_status' => $status,
        ];

        return view('admin/bookings', $data);
    }

    public function bookingDetail($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $booking = $this->bookingModel->getBookingWithDetails($id);
        if (!$booking) {
            session()->setFlashdata('error', 'Booking tidak ditemukan');
            return redirect()->to('/admin/bookings');
        }

        return view('admin/booking_detail', ['booking' => $booking]);
    }

    public function updateBookingStatus()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $bookingId = $this->request->getPost('booking_id');
        $status = $this->request->getPost('status');

        $booking = $this->bookingModel->getBookingWithDetails($bookingId);
        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Booking tidak ditemukan']);
        }

        if ($this->bookingModel->updateStatus($bookingId, $status)) {
            // Send WhatsApp notification
            $this->whatsappService->sendBookingStatusUpdate($booking['customer_whatsapp'], $booking, $status);

            return $this->response->setJSON(['success' => true, 'message' => 'Status booking berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status booking']);
        }
    }

    public function customers()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'customers' => $this->userModel->getCustomers(),
        ];

        return view('admin/customers', $data);
    }

    public function chats()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $customerId = $this->request->getGet('customer');
        
        if ($customerId) {
            $chats = $this->chatModel->getUserChats($customerId);
            $customer = $this->userModel->find($customerId);
        } else {
            $chats = [];
            $customer = null;
        }

        $recentChats = $this->chatModel->getRecentChatsForAdmin();

        $data = [
            'chats' => $chats,
            'customer' => $customer,
            'recent_chats' => $recentChats,
        ];

        return view('admin/chats', $data);
    }

    public function sendAdminMessage()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = $this->request->getPost('user_id');
        $message = $this->request->getPost('message');

        if (empty($message)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesan tidak boleh kosong']);
        }

        $adminId = session()->get('user_id');
        $chatId = $this->chatModel->sendAdminMessage($userId, $adminId, $message);

        if ($chatId) {
            // Send WhatsApp notification to customer
            $user = $this->userModel->find($userId);
            $this->whatsappService->sendMessage($user['whatsapp'], "💬 *Pesan dari Admin*\n\n{$message}");

            return $this->response->setJSON(['success' => true, 'message' => 'Pesan terkirim']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim pesan']);
        }
    }

    public function getCustomerChats($userId)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $chats = $this->chatModel->getUserChats($userId);
        return $this->response->setJSON(['success' => true, 'chats' => $chats]);
    }
}