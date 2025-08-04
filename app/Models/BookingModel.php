<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'hairstyle_id', 'booking_date', 'booking_time', 
        'service_type', 'address', 'total_price', 'status', 'notes',
        'customer_photo', 'price_confirmed', 'price_status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'hairstyle_id' => 'required|integer',
        'booking_date' => 'required|valid_date',
        'booking_time' => 'required',
        'service_type' => 'required|in_list[home,salon,cornrow,boxbraid]',
        'total_price' => 'required|numeric|greater_than[0]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID harus diisi',
            'integer' => 'User ID harus berupa angka',
        ],
        'hairstyle_id' => [
            'required' => 'Hairstyle ID harus diisi',
            'integer' => 'Hairstyle ID harus berupa angka',
        ],
        'booking_date' => [
            'required' => 'Tanggal booking harus diisi',
            'valid_date' => 'Format tanggal tidak valid',
        ],
        'booking_time' => [
            'required' => 'Waktu booking harus diisi',
        ],
        'service_type' => [
            'required' => 'Tipe layanan harus diisi',
            'in_list' => 'Tipe layanan harus home, salon, cornrow, atau boxbraid',
        ],
        'total_price' => [
            'required' => 'Total harga harus diisi',
            'numeric' => 'Total harga harus berupa angka',
            'greater_than' => 'Total harga harus lebih dari 0',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getUserBookings($userId)
    {
        return $this->select('bookings.*, hairstyles.name as hairstyle_name, hairstyles.price as hairstyle_price')
                   ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                   ->where('bookings.user_id', $userId)
                   ->orderBy('bookings.created_at', 'DESC')
                   ->findAll();
    }

    public function getBookingWithDetails($bookingId)
    {
        return $this->select('bookings.*, hairstyles.name as hairstyle_name, hairstyles.description as hairstyle_description, hairstyles.price as hairstyle_price, users.name as customer_name, users.whatsapp as customer_whatsapp')
                   ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                   ->join('users', 'users.id = bookings.user_id')
                   ->where('bookings.id', $bookingId)
                   ->first();
    }

    public function getPendingBookings()
    {
        return $this->select('bookings.*, hairstyles.name as hairstyle_name, users.name as customer_name, users.whatsapp as customer_whatsapp')
                   ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                   ->join('users', 'users.id = bookings.user_id')
                   ->where('bookings.status', 'pending')
                   ->orderBy('bookings.created_at', 'ASC')
                   ->findAll();
    }

    public function getBookingsByStatus($status)
    {
        return $this->select('bookings.*, hairstyles.name as hairstyle_name, users.name as customer_name, users.whatsapp as customer_whatsapp')
                   ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                   ->join('users', 'users.id = bookings.user_id')
                   ->where('bookings.status', $status)
                   ->orderBy('bookings.created_at', 'DESC')
                   ->findAll();
    }

    public function getTodayBookings()
    {
        // Set timezone to Makassar (WITA)
        date_default_timezone_set('Asia/Makassar');
        $today = date('Y-m-d');
        
        return $this->select('bookings.*, hairstyles.name as hairstyle_name, users.name as customer_name, users.whatsapp as customer_whatsapp')
                   ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                   ->join('users', 'users.id = bookings.user_id')
                   ->where('bookings.booking_date', $today)
                   ->orderBy('bookings.booking_time', 'ASC')
                   ->findAll();
    }

    public function updateStatus($bookingId, $status)
    {
        return $this->update($bookingId, ['status' => $status]);
    }

    public function updatePriceConfirmation($bookingId, $confirmedPrice, $priceStatus = 'confirmed')
    {
        return $this->update($bookingId, [
            'price_confirmed' => $confirmedPrice,
            'price_status' => $priceStatus
        ]);
    }

    public function getPendingPriceBookings()
    {
        return $this->select('bookings.*, hairstyles.name as hairstyle_name, users.name as customer_name, users.whatsapp as customer_whatsapp')
                   ->join('hairstyles', 'hairstyles.id = bookings.hairstyle_id')
                   ->join('users', 'users.id = bookings.user_id')
                   ->where('bookings.price_status', 'pending')
                   ->orderBy('bookings.created_at', 'ASC')
                   ->findAll();
    }
}