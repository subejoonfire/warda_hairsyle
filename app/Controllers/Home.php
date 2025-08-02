<?php

namespace App\Controllers;

use App\Models\HairstyleModel;
use App\Models\BookingModel;
use App\Models\ChatModel;

class Home extends BaseController
{
    protected $hairstyleModel;
    protected $bookingModel;
    protected $chatModel;

    public function __construct()
    {
        $this->hairstyleModel = new HairstyleModel();
        $this->bookingModel = new BookingModel();
        $this->chatModel = new ChatModel();
    }

    public function index()
    {
        $data = [
            'hairstyles' => $this->hairstyleModel->getActiveHairstyles(),
            'categories' => $this->hairstyleModel->getCategories(),
        ];
        return view('home/index', $data);
    }

    public function dashboard()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');

        $data = [
            'user' => [
                'name' => session()->get('user_name'),
                'whatsapp' => session()->get('user_whatsapp'),
            ],
            'recent_bookings' => $this->bookingModel->getUserBookings($userId),
            'unread_chats' => $this->chatModel->getUnreadChats($userId),
        ];

        return view('customer/dashboard', $data);
    }

    public function hairstyles()
    {
        $category = $this->request->getGet('category');
        $search = $this->request->getGet('search');

        if ($category) {
            $hairstyles = $this->hairstyleModel->getByCategory($category);
        } elseif ($search) {
            $hairstyles = $this->hairstyleModel->searchHairstyles($search);
        } else {
            $hairstyles = $this->hairstyleModel->getActiveHairstyles();
        }

        $data = [
            'hairstyles' => $hairstyles,
            'categories' => $this->hairstyleModel->getCategories(),
            'selected_category' => $category,
            'search' => $search,
        ];

        return view('customer/hairstyles', $data);
    }

    public function booking()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return redirect()->to('/auth/login');
        }

        $hairstyleId = $this->request->getGet('hairstyle');
        $hairstyle = null;

        if ($hairstyleId) {
            $hairstyle = $this->hairstyleModel->find($hairstyleId);
        }

        $data = [
            'hairstyles' => $this->hairstyleModel->getActiveHairstyles(),
            'selected_hairstyle' => $hairstyle,
        ];

        return view('customer/booking', $data);
    }

    public function createBooking()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/booking');
        }

        $hairstyleId = $this->request->getPost('hairstyle_id');
        $bookingDate = $this->request->getPost('booking_date');
        $bookingTime = $this->request->getPost('booking_time');
        $serviceType = $this->request->getPost('service_type');
        $address = $this->request->getPost('address');
        $notes = $this->request->getPost('notes');

        $hairstyle = $this->hairstyleModel->find($hairstyleId);
        if (!$hairstyle) {
            session()->setFlashdata('error', 'Hairstyle tidak ditemukan');
            return redirect()->back()->withInput();
        }

        $totalPrice = $hairstyle['price'];
        if ($serviceType === 'home') {
            $totalPrice += 25000; // Additional fee for home service
        }

        $data = [
            'user_id' => session()->get('user_id'),
            'hairstyle_id' => $hairstyleId,
            'booking_date' => $bookingDate,
            'booking_time' => $bookingTime,
            'service_type' => $serviceType,
            'address' => $serviceType === 'home' ? $address : null,
            'total_price' => $totalPrice,
            'notes' => $notes,
            'status' => 'pending',
        ];

        if (!$this->bookingModel->validate($data)) {
            session()->setFlashdata('errors', $this->bookingModel->errors());
            return redirect()->back()->withInput();
        }

        $bookingId = $this->bookingModel->insert($data);

        if ($bookingId) {
            session()->setFlashdata('success', 'Booking berhasil dibuat! Admin akan menghubungi Anda segera');
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Gagal membuat booking');
            return redirect()->back()->withInput();
        }
    }

    public function profile()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return redirect()->to('/auth/login');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'address' => $this->request->getPost('address'),
            ];

            if ($userModel->update(session()->get('user_id'), $data)) {
                session()->set('user_name', $data['name']);
                session()->setFlashdata('success', 'Profile berhasil diperbarui');
                return redirect()->to('/profile');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui profile');
                return redirect()->back()->withInput();
            }
        }

        return view('customer/profile', ['user' => $user]);
    }

    public function chat()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $chats = $this->chatModel->getUserChats($userId);

        return view('customer/chat', ['chats' => $chats]);
    }

    public function sendMessage()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $message = $this->request->getPost('message');
        if (empty($message)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesan tidak boleh kosong']);
        }

        $userId = session()->get('user_id');
        $chatId = $this->chatModel->sendCustomerMessage($userId, $message);

        if ($chatId) {
            // Send notification to admin
            $whatsappService = new \App\Services\WhatsAppService();
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($userId);

            $adminModel = new \App\Models\UserModel();
            $admins = $adminModel->getAdmins();

            foreach ($admins as $admin) {
                $whatsappService->sendNewChatNotification($admin['whatsapp'], $user['name'], $message);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Pesan terkirim']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim pesan']);
        }
    }

    public function getChats()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $chats = $this->chatModel->getUserChats($userId);

        // Mark messages as read
        $this->chatModel->markAsRead($userId);

        return $this->response->setJSON(['success' => true, 'chats' => $chats]);
    }
}
