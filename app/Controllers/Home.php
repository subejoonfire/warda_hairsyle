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
            // Send notification to admin
            $whatsappService = new \App\Services\WhatsAppService();
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find(session()->get('user_id'));
            
            $adminModel = new \App\Models\UserModel();
            $admins = $adminModel->getAdmins();

            $bookingData = [
                'customer_name' => $user['name'],
                'customer_whatsapp' => $user['whatsapp'],
                'hairstyle_name' => $hairstyle['name'],
                'booking_date' => $bookingDate,
                'booking_time' => $bookingTime,
                'service_type' => $serviceType,
                'total_price' => $totalPrice,
                'address' => $address
            ];

            foreach ($admins as $admin) {
                $whatsappService->sendNewBookingNotification($admin['whatsapp'], $bookingData);
            }

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
            // Generate auto-reply directly in controller
            $autoReply = $this->generateAutoReply($message);
            
            // Send auto-reply as admin message
            $adminId = 1; // Default admin ID
            $this->chatModel->sendAdminMessage($userId, $adminId, $autoReply);

            // Check if message needs admin attention (for complex queries)
            $needsAdmin = $this->needsAdminAttention($message);
            
            if ($needsAdmin) {
                // Send notification to admin for complex queries
                $whatsappService = new \App\Services\WhatsAppService();
                $userModel = new \App\Models\UserModel();
                $user = $userModel->find($userId);

                $adminModel = new \App\Models\UserModel();
                $admins = $adminModel->getAdmins();

                foreach ($admins as $admin) {
                    $whatsappService->sendNewChatNotification($admin['whatsapp'], $user['name'], $message);
                }
            } else {
                // Check if message is not a quick message, then notify admin
                $quickMessageModel = new \App\Models\QuickMessageModel();
                $quickMessage = $quickMessageModel->findQuickMessage($message);
                
                if (!$quickMessage) {
                    // Send notification to admin for non-quick messages
                    $whatsappService = new \App\Services\WhatsAppService();
                    $userModel = new \App\Models\UserModel();
                    $user = $userModel->find($userId);

                    $adminModel = new \App\Models\UserModel();
                    $admins = $adminModel->getAdmins();

                    foreach ($admins as $admin) {
                        $whatsappService->sendNewChatNotification($admin['whatsapp'], $user['name'], $message);
                    }
                }
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Pesan terkirim']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim pesan']);
        }
    }

    private function needsAdminAttention($message)
    {
        $message = strtolower(trim($message));
        
        // Keywords that need admin attention
        $adminKeywords = [
            'komplain', 'complaint', 'saran', 'suggestion', 'masalah', 'problem',
            'refund', 'pengembalian', 'cancel', 'batal', 'reschedule', 'ubah jadwal',
            'urgent', 'mendesak', 'emergency', 'darurat', 'custom', 'khusus',
            'booking', 'pesan', 'order', 'reservasi', 'janji'
        ];
        
        foreach ($adminKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
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

    public function sendQuickMessage($quickMessageId = null)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'customer') {
            return redirect()->to('/auth/login');
        }

        if (empty($quickMessageId)) {
            return redirect()->to('/chat');
        }

        $userId = session()->get('user_id');
        
        // Get quick message from database
        $quickMessageModel = new \App\Models\QuickMessageModel();
        $quickMessage = $quickMessageModel->find($quickMessageId);
        
        if (!$quickMessage) {
            session()->setFlashdata('error', 'Quick message tidak ditemukan');
            return redirect()->to('/chat');
        }

        // Send customer message
        $chatId = $this->chatModel->sendCustomerMessage($userId, $quickMessage['keyword']);

        if ($chatId) {
            // Generate auto-reply based on quick message ID
            $autoReply = $this->getAutoReplyFromDatabase($quickMessageId);
            
            // Send auto-reply as admin message
            $adminId = 1; // Default admin ID
            $this->chatModel->sendAdminMessage($userId, $adminId, $autoReply);

            session()->setFlashdata('success', 'Pesan cepat berhasil dikirim');
        } else {
            session()->setFlashdata('error', 'Gagal mengirim pesan cepat');
        }

        return redirect()->to('/chat');
    }

    private function getAutoReplyFromDatabase($quickMessageId)
    {
        // Get response based on quick message ID
        switch ($quickMessageId) {
            case 1: // list hairstyle
                return $this->getHairstyleListFromDatabase();
            case 2: // harga hairstyle
                return $this->getHairstylePricesFromDatabase();
            case 3: // jam buka
                return $this->getOpeningHours();
            case 4: // lokasi
                return $this->getLocation();
            case 5: // layanan
                return $this->getServices();
            case 6: // kontak
                return $this->getContactInfo();
            case 7: // booking
                return $this->getBookingInfo();
            case 8: // menu
                return $this->getMainMenu();
            default:
                return $this->getDefaultResponse();
        }
    }

    private function getHairstyleListFromDatabase()
    {
        $hairstyles = $this->hairstyleModel->getActiveHairstyles();
        
        $response = "💇‍♀️ *Daftar Hairstyle Wardati*\n\n";
        
        if (empty($hairstyles)) {
            $response .= "❌ Tidak ada hairstyle yang tersedia saat ini\n\n";
        } else {
            $response .= "📋 *Hairstyle Tersedia:*\n";
            foreach ($hairstyles as $hairstyle) {
                $response .= "• *{$hairstyle['name']}* - Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
                $response .= "  {$hairstyle['description']}\n\n";
            }
        }
        
        $response .= "Untuk melihat foto, ketik: *foto hairstyle*\n";
        $response .= "Untuk melihat harga, ketik: *harga hairstyle*\n";
        $response .= "Untuk booking, ketik: *booking*";
        
        return $response;
    }

    private function getHairstylePricesFromDatabase()
    {
        $hairstyles = $this->hairstyleModel->getActiveHairstyles();
        
        $response = "💰 *Harga Hairstyle Wardati*\n\n";
        
        if (empty($hairstyles)) {
            $response .= "❌ Tidak ada hairstyle yang tersedia saat ini\n\n";
        } else {
            $response .= "💇‍♀️ *Layanan Utama:*\n";
            foreach ($hairstyles as $hairstyle) {
                $response .= "• *{$hairstyle['name']}*: Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
            }
            $response .= "\n";
        }
        
        $response .= "💡 *Layanan Tambahan:*\n";
        $response .= "• Home Service: +Rp 25.000\n";
        $response .= "• Express Service: +Rp 15.000\n";
        $response .= "• Hair Treatment: +Rp 30.000\n";
        $response .= "• Coloring: +Rp 50.000\n\n";
        
        $response .= "🎁 *Paket Promo:*\n";
        $response .= "• Paket Wedding: Potong + Styling + Makeup\n";
        $response .= "• Paket Family: 3-5 orang (Diskon 20%)\n";
        $response .= "• Paket Student: Potong + Styling (Diskon 15%)\n\n";
        
        $response .= "Untuk booking, ketik: *booking*\n";
        $response .= "Untuk melihat daftar lengkap, ketik: *list hairstyle*";
        
        return $response;
    }

    private function generateAutoReply($message)
    {
        $message = strtolower(trim($message));
        
        // Check for exact matches first
        $exactMatches = [
            'list hairstyle' => 'getHairstyleList',
            'harga hairstyle' => 'getHairstylePrices',
            'jam buka' => 'getOpeningHours',
            'lokasi' => 'getLocation',
            'layanan' => 'getServices',
            'kontak' => 'getContactInfo',
            'booking' => 'getBookingInfo',
            'menu' => 'getMainMenu',
            'foto hairstyle' => 'getHairstylePhotos'
        ];
        
        foreach ($exactMatches as $keyword => $method) {
            if ($message === $keyword) {
                return $this->$method();
            }
        }
        
        // Fallback to partial matches
        if (strpos($message, 'list') !== false && strpos($message, 'hairstyle') !== false) {
            return $this->getHairstyleList();
        }
        
        if (strpos($message, 'foto') !== false || strpos($message, 'gambar') !== false) {
            return $this->getHairstylePhotos();
        }
        
        if (strpos($message, 'harga') !== false || strpos($message, 'price') !== false) {
            return $this->getHairstylePrices();
        }
        
        if (strpos($message, 'booking') !== false || strpos($message, 'pesan') !== false || strpos($message, 'order') !== false) {
            return $this->getBookingInfo();
        }
        
        if (strpos($message, 'jam') !== false && strpos($message, 'buka') !== false) {
            return $this->getOpeningHours();
        }
        
        if (strpos($message, 'lokasi') !== false || strpos($message, 'alamat') !== false || strpos($message, 'dimana') !== false) {
            return $this->getLocation();
        }
        
        if (strpos($message, 'layanan') !== false || strpos($message, 'service') !== false) {
            return $this->getServices();
        }
        
        if (strpos($message, 'kontak') !== false || strpos($message, 'hubungi') !== false || strpos($message, 'telepon') !== false) {
            return $this->getContactInfo();
        }
        
        if (strpos($message, 'menu') !== false || strpos($message, 'bantuan') !== false || strpos($message, 'help') !== false) {
            return $this->getMainMenu();
        }
        
        return $this->getDefaultResponse();
    }

    private function getHairstyleList()
    {
        return "💇‍♀️ *Daftar Hairstyle Wardati*\n\n" .
               "📋 *Hairstyle Tersedia:*\n" .
               "• *Pompadour Classic* - Rp 75.000\n" .
               "  Gaya rambut klasik dengan volume tinggi di bagian depan\n\n" .
               "• *Undercut Modern* - Rp 85.000\n" .
               "  Gaya rambut modern dengan bagian samping yang dipotong pendek\n\n" .
               "• *Fade Style* - Rp 90.000\n" .
               "  Gaya rambut dengan gradasi dari pendek ke panjang\n\n" .
               "• *Quiff Style* - Rp 80.000\n" .
               "  Gaya rambut dengan bagian depan yang diangkat dan disisir ke belakang\n\n" .
               "• *Buzz Cut* - Rp 60.000\n" .
               "  Potongan rambut pendek dan rapi untuk tampilan bersih\n\n" .
               "• *Side Part* - Rp 70.000\n" .
               "  Gaya rambut dengan belahan samping yang elegan\n\n" .
               "Untuk melihat foto, ketik: *foto hairstyle*\n" .
               "Untuk melihat harga, ketik: *harga hairstyle*\n" .
               "Untuk booking, ketik: *booking*";
    }

    private function getHairstylePrices()
    {
        return "💰 *Harga Hairstyle Wardati*\n\n" .
               "💇‍♀️ *Layanan Utama:*\n" .
               "• *Pompadour Classic*: Rp 75.000\n" .
               "• *Undercut Modern*: Rp 85.000\n" .
               "• *Fade Style*: Rp 90.000\n" .
               "• *Quiff Style*: Rp 80.000\n" .
               "• *Buzz Cut*: Rp 60.000\n" .
               "• *Side Part*: Rp 70.000\n\n" .
               "💡 *Layanan Tambahan:*\n" .
               "• Home Service: +Rp 25.000\n" .
               "• Express Service: +Rp 15.000\n" .
               "• Hair Treatment: +Rp 30.000\n" .
               "• Coloring: +Rp 50.000\n\n" .
               "🎁 *Paket Promo:*\n" .
               "• Paket Wedding: Potong + Styling + Makeup\n" .
               "• Paket Family: 3-5 orang (Diskon 20%)\n" .
               "• Paket Student: Potong + Styling (Diskon 15%)\n\n" .
               "Untuk booking, ketik: *booking*\n" .
               "Untuk melihat daftar lengkap, ketik: *list hairstyle*";
    }

    private function getOpeningHours()
    {
        return "🕐 *Jam Buka Wardati Hairstyle*\n\n" .
               "📅 *Senin - Jumat:*\n" .
               "   09:00 - 20:00 WIB\n\n" .
               "📅 *Sabtu - Minggu:*\n" .
               "   08:00 - 21:00 WIB\n\n" .
               "📅 *Hari Libur Nasional:*\n" .
               "   10:00 - 18:00 WIB\n\n" .
               "💡 *Catatan:*\n" .
               "• Booking terakhir 2 jam sebelum tutup\n" .
               "• Home service tersedia 24 jam dengan booking minimal 1 hari sebelumnya\n" .
               "• Untuk booking mendesak, hubungi langsung\n\n" .
               "Untuk booking, ketik: *booking*";
    }

    private function getLocation()
    {
        return "📍 *Lokasi Wardati Hairstyle*\n\n" .
               "🏪 *Salon Utama:*\n" .
               "   Jl. Raya Wardati No. 123\n" .
               "   Jakarta Selatan, DKI Jakarta\n" .
               "   📍 Google Maps: bit.ly/wardati-salon\n\n" .
               "🚗 *Akses:*\n" .
               "• 5 menit dari Stasiun MRT Blok M\n" .
               "• 10 menit dari Mall Blok M Square\n" .
               "• Tersedia parkir motor & mobil\n\n" .
               "🚌 *Transportasi Umum:*\n" .
               "• MRT: Stasiun Blok M\n" .
               "• TransJakarta: Halte Blok M\n" .
               "• Angkot: 02, 05, 08\n\n" .
               "🏠 *Home Service:*\n" .
               "   Tersedia untuk area Jakarta Selatan\n" .
               "   Biaya tambahan: Rp 25.000\n\n" .
               "Untuk booking, ketik: *booking*";
    }

    private function getServices()
    {
        return "💇‍♀️ *Layanan Wardati Hairstyle*\n\n" .
               "✂️ *Potong Rambut:*\n" .
               "• Potong Pria (Semua Gaya)\n" .
               "• Potong Wanita (Semua Gaya)\n" .
               "• Potong Anak-anak\n" .
               "• Potong Rambut Panjang\n\n" .
               "💄 *Styling & Makeup:*\n" .
               "• Styling Rambut\n" .
               "• Makeup Natural\n" .
               "• Makeup Glamour\n" .
               "• Makeup Wedding\n\n" .
               "🎨 *Perawatan Rambut:*\n" .
               "• Hair Treatment\n" .
               "• Hair Coloring\n" .
               "• Hair Smoothing\n" .
               "• Hair Rebonding\n\n" .
               "🏠 *Layanan Tambahan:*\n" .
               "• Home Service\n" .
               "• Express Service\n" .
               "• Wedding Package\n" .
               "• Family Package\n\n" .
               "Untuk melihat harga, ketik: *harga hairstyle*\n" .
               "Untuk booking, ketik: *booking*";
    }

    private function getContactInfo()
    {
        return "📞 *Kontak Wardati Hairstyle*\n\n" .
               "📱 *WhatsApp:*\n" .
               "   0812-3456-7890\n\n" .
               "📞 *Telepon:*\n" .
               "   021-1234-5678\n\n" .
               "📧 *Email:*\n" .
               "   info@wardati-hairstyle.com\n\n" .
               "📱 *Social Media:*\n" .
               "• Instagram: @wardati_hairstyle\n" .
               "• Facebook: Wardati Hairstyle\n" .
               "• TikTok: @wardati_hairstyle\n\n" .
               "🌐 *Website:*\n" .
               "   wardati-hairstyle.com\n\n" .
               "Untuk booking, ketik: *booking*\n" .
               "Untuk melihat lokasi, ketik: *lokasi*";
    }

    private function getBookingInfo()
    {
        return "📅 *Cara Booking Wardati Hairstyle*\n\n" .
               "1️⃣ *Melalui Website:*\n" .
               "   Kunjungi: wardati-hairstyle.com\n" .
               "   Pilih hairstyle → Pilih tanggal & waktu → Konfirmasi\n\n" .
               "2️⃣ *Melalui WhatsApp:*\n" .
               "   Kirim pesan dengan format:\n" .
               "   *BOOKING [nama hairstyle] [tanggal] [waktu] [layanan]*\n" .
               "   Contoh: BOOKING Bob Cut 25/12/2024 14:00 salon\n\n" .
               "3️⃣ *Melalui Telepon:*\n" .
               "   Hubungi: 0812-3456-7890\n\n" .
               "📋 *Informasi yang diperlukan:*\n" .
               "• Nama lengkap\n" .
               "• Nomor WhatsApp\n" .
               "• Alamat (untuk home service)\n" .
               "• Catatan khusus\n\n" .
               "Untuk melihat daftar hairstyle, ketik: *list hairstyle*";
    }

    private function getMainMenu()
    {
        return "🎯 *Menu Bantuan Wardati Hairstyle*\n\n" .
               "📋 *Informasi Layanan:*\n" .
               "• *list hairstyle* - Daftar hairstyle\n" .
               "• *harga hairstyle* - Harga layanan\n" .
               "• *foto hairstyle* - Galeri foto\n" .
               "• *layanan* - Jenis layanan\n\n" .
               "📅 *Informasi Booking:*\n" .
               "• *booking* - Cara booking\n" .
               "• *jam buka* - Jam operasional\n" .
               "• *lokasi* - Lokasi salon\n\n" .
               "📞 *Kontak & Support:*\n" .
               "• *kontak* - Informasi kontak\n" .
               "• *menu* - Menu bantuan ini\n\n" .
               "💡 *Tips:*\n" .
               "• Ketik kata kunci yang diinginkan\n" .
               "• Admin akan merespon dalam waktu singkat\n" .
               "• Untuk pertanyaan khusus, admin akan membantu\n\n" .
               "Untuk booking, ketik: *booking*";
    }

    private function getHairstylePhotos()
    {
        return "📸 *Foto Hairstyle Wardati*\n\n" .
               "📷 *Galeri Foto:*\n" .
               "• Pompadour Classic: wardati.com/pompadour\n" .
               "• Undercut Modern: wardati.com/undercut\n" .
               "• Fade Style: wardati.com/fade\n" .
               "• Quiff Style: wardati.com/quiff\n" .
               "• Buzz Cut: wardati.com/buzz\n" .
               "• Side Part: wardati.com/sidepart\n\n" .
               "📱 *Social Media:*\n" .
               "• Instagram: @wardati_hairstyle\n" .
               "• Facebook: Wardati Hairstyle\n" .
               "• TikTok: @wardati_hairstyle\n\n" .
               "Untuk melihat harga, ketik: *harga hairstyle*\n" .
               "Untuk booking, ketik: *booking*";
    }

    private function getDefaultResponse()
    {
        return "Halo! 👋 Terima kasih telah menghubungi Wardati Hairstyle.\n\n" .
               "Untuk informasi lebih lanjut, silakan ketik salah satu kata kunci berikut:\n\n" .
               "• *list hairstyle* - Daftar hairstyle\n" .
               "• *harga hairstyle* - Harga layanan\n" .
               "• *jam buka* - Jam operasional\n" .
               "• *lokasi* - Lokasi salon\n" .
               "• *layanan* - Jenis layanan\n" .
               "• *kontak* - Informasi kontak\n" .
               "• *booking* - Cara booking\n" .
               "• *menu* - Menu bantuan lengkap\n\n" .
               "Untuk pertanyaan khusus, admin akan merespon dalam waktu singkat.";
    }
}
