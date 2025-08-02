<?php

namespace App\Services;

use CodeIgniter\Config\BaseConfig;

class WhatsAppService
{
    private $apiKey;
    private $deviceId;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('fonnte.api_key');
        $this->deviceId = env('fonnte.device_id');
        $this->baseUrl = env('fonnte.base_url');
    }

    public function sendMessage($phoneNumber, $message)
    {
        $url = $this->baseUrl;
        
        $data = [
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '62',
        ];

        $headers = [
            'Authorization: ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            return [
                'success' => true,
                'data' => $result,
            ];
        }

        return [
            'success' => false,
            'error' => 'Failed to send message. HTTP Code: ' . $httpCode,
            'response' => $response,
        ];
    }

    public function sendVerificationCode($phoneNumber, $code)
    {
        $message = "🔐 *Kode Verifikasi Wardati Hairstyle*\n\n";
        $message .= "Kode verifikasi Anda adalah: *{$code}*\n\n";
        $message .= "Kode ini berlaku selama 10 menit.\n";
        $message .= "Jangan bagikan kode ini kepada siapapun.\n\n";
        $message .= "Terima kasih telah menggunakan layanan kami!";

        return $this->sendMessage($phoneNumber, $message);
    }

    public function sendBookingConfirmation($phoneNumber, $bookingData)
    {
        $message = "✅ *Konfirmasi Booking Wardati Hairstyle*\n\n";
        $message .= "Halo {$bookingData['customer_name']},\n\n";
        $message .= "Booking Anda telah dikonfirmasi:\n";
        $message .= "• Hairstyle: {$bookingData['hairstyle_name']}\n";
        $message .= "• Tanggal: " . date('d/m/Y', strtotime($bookingData['booking_date'])) . "\n";
        $message .= "• Waktu: {$bookingData['booking_time']}\n";
        $message .= "• Layanan: " . ($bookingData['service_type'] === 'home' ? 'Home Service' : 'Salon') . "\n";
        $message .= "• Total: Rp " . number_format($bookingData['total_price'], 0, ',', '.') . "\n\n";
        
        if ($bookingData['service_type'] === 'home' && !empty($bookingData['address'])) {
            $message .= "Alamat: {$bookingData['address']}\n\n";
        }
        
        $message .= "Tim kami akan menghubungi Anda untuk konfirmasi lebih lanjut.\n";
        $message .= "Terima kasih!";

        return $this->sendMessage($phoneNumber, $message);
    }

    public function sendBookingStatusUpdate($phoneNumber, $bookingData, $status)
    {
        $statusText = [
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $message = "📋 *Update Status Booking*\n\n";
        $message .= "Halo {$bookingData['customer_name']},\n\n";
        $message .= "Status booking Anda telah diperbarui:\n";
        $message .= "• Hairstyle: {$bookingData['hairstyle_name']}\n";
        $message .= "• Tanggal: " . date('d/m/Y', strtotime($bookingData['booking_date'])) . "\n";
        $message .= "• Waktu: {$bookingData['booking_time']}\n";
        $message .= "• Status: *{$statusText[$status]}*\n\n";
        
        if ($status === 'confirmed') {
            $message .= "Booking Anda telah dikonfirmasi. Silakan datang tepat waktu.\n";
        } elseif ($status === 'completed') {
            $message .= "Terima kasih telah menggunakan layanan kami!\n";
        } elseif ($status === 'cancelled') {
            $message .= "Booking Anda telah dibatalkan. Silakan booking ulang jika diperlukan.\n";
        }
        
        $message .= "\nTerima kasih!";

        return $this->sendMessage($phoneNumber, $message);
    }

    public function sendNewChatNotification($phoneNumber, $customerName, $message)
    {
        $messageText = "💬 *Pesan Baru dari Customer*\n\n";
        $messageText .= "Customer: {$customerName}\n";
        $messageText .= "Pesan: {$message}\n\n";
        $messageText .= "Silakan balas melalui aplikasi admin.";

        return $this->sendMessage($phoneNumber, $messageText);
    }

    public function sendNewBookingNotification($phoneNumber, $bookingData)
    {
        $message = "🆕 *Booking Baru*\n\n";
        $message .= "Ada booking baru dari:\n";
        $message .= "• Nama: {$bookingData['customer_name']}\n";
        $message .= "• WhatsApp: {$bookingData['customer_whatsapp']}\n";
        $message .= "• Hairstyle: {$bookingData['hairstyle_name']}\n";
        $message .= "• Tanggal: " . date('d/m/Y', strtotime($bookingData['booking_date'])) . "\n";
        $message .= "• Waktu: {$bookingData['booking_time']}\n";
        $message .= "• Layanan: " . ($bookingData['service_type'] === 'home' ? 'Home Service' : 'Salon') . "\n";
        $message .= "• Total: Rp " . number_format($bookingData['total_price'], 0, ',', '.') . "\n\n";
        $message .= "Silakan cek aplikasi admin untuk detail lengkap.";

        return $this->sendMessage($phoneNumber, $message);
    }
}