<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HairstyleModel;
use App\Models\BookingModel;
use App\Models\ChatModel;
use App\Models\HomeContentModel;
use App\Models\FooterContentModel;
use App\Services\WhatsAppService;

class Admin extends BaseController
{
    protected $userModel;
    protected $hairstyleModel;
    protected $bookingModel;
    protected $chatModel;
    protected $homeContentModel;
    protected $footerContentModel;
    protected $whatsappService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->hairstyleModel = new HairstyleModel();
        $this->bookingModel = new BookingModel();
        $this->chatModel = new ChatModel();
        $this->homeContentModel = new HomeContentModel();
        $this->footerContentModel = new FooterContentModel();
        $this->whatsappService = new WhatsAppService();
    }

    private function getAdminUnreadChats()
    {
        return $this->chatModel->where('sender_type', 'customer')->where('is_read', 0)->countAllResults();
    }

    public function dashboard()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Set timezone to Makassar
        date_default_timezone_set('Asia/Makassar');

        $data = [
            'total_customers' => $this->userModel->where('role', 'customer')->countAllResults(),
            'total_bookings' => $this->bookingModel->countAllResults(),
            'pending_bookings' => $this->bookingModel->where('status', 'pending')->countAllResults(),
            'today_bookings' => $this->bookingModel->getTodayBookings(),
            'recent_bookings' => $this->bookingModel->getBookingsByStatus('pending'),
            'recent_chats' => $this->chatModel->getRecentChatsForAdmin(),
            'current_time' => date('Y-m-d H:i:s'),
            'current_date' => date('Y-m-d'),
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/dashboard', $data);
    }







    public function bookings()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $status = $this->request->getGet('status');
        $date = $this->request->getGet('date');
        $search = $this->request->getGet('search');

        $query = $this->bookingModel->select('bookings.*, hairstyles.name as hairstyle_name, users.name as customer_name, users.whatsapp as customer_whatsapp')
            ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
            ->join('users', 'users.id = bookings.user_id');

        if ($status) {
            $query->where('bookings.status', $status);
        }

        if ($date) {
            $query->where('DATE(bookings.booking_date)', $date);
        }

        if ($search) {
            $query->groupStart()
                ->like('users.name', $search)
                ->orLike('users.whatsapp', $search)
                ->groupEnd();
        }

        $bookings = $query->orderBy('bookings.created_at', 'DESC')->findAll();

        $data = [
            'bookings' => $bookings,
            'status' => $status,
            'date' => $date,
            'search' => $search,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
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

        return view('admin/booking_detail', [
            'booking' => $booking,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ]);
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

        $search = $this->request->getGet('search');

        $query = $this->userModel->where('role', 'customer');

        if ($search) {
            $query->groupStart()
                ->like('name', $search)
                ->orLike('whatsapp', $search)
                ->groupEnd();
        }

        $customers = $query->findAll();

        $data = [
            'customers' => $customers,
            'search' => $search,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/customers', $data);
    }

    public function chats()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $customerId = $this->request->getGet('customer');

        // Get all customers with unread count
        $customers = $this->userModel->where('role', 'customer')->findAll();
        foreach ($customers as &$customer) {
            $customer['unread_count'] = $this->chatModel->where('user_id', $customer['id'])
                ->where('sender_type', 'customer')
                ->where('is_read', 0)
                ->countAllResults();
        }

        $selectedCustomer = null;
        $messages = [];

        if ($customerId) {
            $selectedCustomer = $this->userModel->find($customerId);
            if ($selectedCustomer) {
                $messages = $this->chatModel->getUserChats($customerId);
                // Mark messages as read
                $this->chatModel->where('user_id', $customerId)
                    ->where('sender_type', 'customer')
                    ->set(['is_read' => 1])
                    ->update();
            }
        }

        $data = [
            'customers' => $customers,
            'selected_customer' => $selectedCustomer,
            'messages' => $messages,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
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

        if (empty($userId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'User ID tidak boleh kosong']);
        }

        if (empty($message)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesan tidak boleh kosong']);
        }

        $adminId = session()->get('user_id');
        
        try {
            $chatId = $this->chatModel->sendAdminMessage($userId, $adminId, $message);

            if ($chatId) {
                // Send WhatsApp notification to customer
                $user = $this->userModel->find($userId);
                if ($user) {
                    try {
                        $this->whatsappService->sendMessage($user['whatsapp'], "💬 *Pesan dari Admin*\n\n{$message}");
                    } catch (Exception $e) {
                        // Log WhatsApp error but don't fail the chat
                        log_message('error', 'WhatsApp service error: ' . $e->getMessage());
                    }
                }

                return $this->response->setJSON(['success' => true, 'message' => 'Pesan terkirim']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim pesan']);
            }
        } catch (Exception $e) {
            log_message('error', 'Chat error: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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

    // Content Management Methods
    public function homeContent()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'home_content' => $this->homeContentModel->getActiveContent(),
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/home_content', $data);
    }

    public function footerContent()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'footer_content' => $this->footerContentModel->getActiveContent(),
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/footer_content', $data);
    }

    public function editHomeContent($id = null)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'icon' => $this->request->getPost('icon'),
                'order_position' => $this->request->getPost('order_position'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            if ($id) {
                // Update existing content
                if ($this->homeContentModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Konten berhasil diperbarui');
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui konten');
                }
            } else {
                // Create new content
                $data['section'] = $this->request->getPost('section');
                if ($this->homeContentModel->insert($data)) {
                    session()->setFlashdata('success', 'Konten berhasil ditambahkan');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan konten');
                }
            }

            return redirect()->to('/admin/home-content');
        }

        $content = $id ? $this->homeContentModel->find($id) : null;
        $data = [
            'content' => $content,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/edit_home_content', $data);
    }

    public function editFooterContent($id = null)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'icon' => $this->request->getPost('icon'),
                'order_position' => $this->request->getPost('order_position'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            if ($id) {
                // Update existing content
                if ($this->footerContentModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Konten footer berhasil diperbarui');
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui konten footer');
                }
            } else {
                // Create new content
                $data['section'] = $this->request->getPost('section');
                if ($this->footerContentModel->insert($data)) {
                    session()->setFlashdata('success', 'Konten footer berhasil ditambahkan');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan konten footer');
                }
            }

            return redirect()->to('/admin/footer-content');
        }

        $content = $id ? $this->footerContentModel->find($id) : null;
        $data = [
            'content' => $content,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/edit_footer_content', $data);
    }

    public function deleteHomeContent($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->homeContentModel->delete($id)) {
            session()->setFlashdata('success', 'Konten berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus konten');
        }

        return redirect()->to('/admin/home-content');
    }

    public function deleteFooterContent($id)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->footerContentModel->delete($id)) {
            session()->setFlashdata('success', 'Konten footer berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus konten footer');
        }

        return redirect()->to('/admin/footer-content');
    }

    // Price Confirmation Methods
    public function priceConfirmation()
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'pending_bookings' => $this->bookingModel->getPendingPriceBookings(),
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/price_confirmation', $data);
    }

    public function confirmPrice($bookingId)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $confirmedPrice = $this->request->getPost('confirmed_price');
            $action = $this->request->getPost('action');

            if ($action === 'confirm') {
                if ($this->bookingModel->updatePriceConfirmation($bookingId, $confirmedPrice, 'confirmed')) {
                    session()->setFlashdata('success', 'Harga berhasil dikonfirmasi');
                } else {
                    session()->setFlashdata('error', 'Gagal mengkonfirmasi harga');
                }
            } elseif ($action === 'reject') {
                if ($this->bookingModel->updatePriceConfirmation($bookingId, null, 'rejected')) {
                    session()->setFlashdata('success', 'Harga ditolak');
                } else {
                    session()->setFlashdata('error', 'Gagal menolak harga');
                }
            }

            return redirect()->to('/admin/price-confirmation');
        }

        $booking = $this->bookingModel->getBookingWithDetails($bookingId);
        $data = [
            'booking' => $booking,
            'admin_unread_chats' => $this->getAdminUnreadChats(),
        ];

        return view('admin/confirm_price', $data);
    }
}
