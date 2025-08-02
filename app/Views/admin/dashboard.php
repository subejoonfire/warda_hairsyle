<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary to-secondary text-white rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Dashboard Admin</h1>
                <p class="text-gray-200">Kelola layanan, booking, dan customer</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-300">Admin</p>
                <p class="font-semibold"><?= session()->get('user_name') ?></p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Customer</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $total_customers ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-green-500 text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Booking</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $total_bookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-yellow-500 text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $pending_bookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-accent text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-cut text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Hairstyles Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">6</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="/admin/hairstyles/create" class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-plus text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Tambah Hairstyle</h3>
            <p class="text-gray-600">Tambah hairstyle baru ke katalog</p>
        </a>

        <a href="/admin/bookings" class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Kelola Booking</h3>
            <p class="text-gray-600">Lihat dan kelola semua booking</p>
        </a>

        <a href="/admin/chats" class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-comments text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Chat Customer</h3>
            <p class="text-gray-600">Balas pesan dari customer</p>
        </a>
    </div>

    <!-- Today's Bookings -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Booking Hari Ini</h2>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Waktu Makassar: <?= date('d/m/Y H:i', strtotime($current_time)) ?> WITA
                </div>
            </div>
        </div>
        
        <?php if (empty($today_bookings)): ?>
            <div class="p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-calendar-times text-6xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada booking hari ini</h3>
                <p class="text-gray-500">Belum ada customer yang booking untuk hari ini</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hairstyle
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Layanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($today_bookings as $booking): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= $booking['customer_name'] ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= $booking['customer_whatsapp'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= $booking['hairstyle_name'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= $booking['booking_time'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $booking['service_type'] === 'home' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusText = [
                                        'pending' => 'Menunggu',
                                        'confirmed' => 'Dikonfirmasi',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$booking['status']] ?>">
                                        <?= $statusText[$booking['status']] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-accent hover:text-yellow-600">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Pending Bookings -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Booking Menunggu Konfirmasi</h2>
        </div>
        
        <?php if (empty($recent_bookings)): ?>
            <div class="p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-check-circle text-6xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada booking pending</h3>
                <p class="text-gray-500">Semua booking telah dikonfirmasi</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hairstyle
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Layanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recent_bookings as $booking): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= $booking['customer_name'] ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= $booking['customer_whatsapp'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= $booking['hairstyle_name'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= date('d/m/Y', strtotime($booking['booking_date'])) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= $booking['booking_time'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $booking['service_type'] === 'home' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-accent hover:text-yellow-600 mr-3">
                                        Detail
                                    </a>
                                    <button onclick="updateStatus(<?= $booking['id'] ?>, 'confirmed')" class="text-green-600 hover:text-green-800 mr-2">
                                        Konfirmasi
                                    </button>
                                    <button onclick="updateStatus(<?= $booking['id'] ?>, 'cancelled')" class="text-red-600 hover:text-red-800">
                                        Batalkan
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Chats -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Chat Terbaru</h2>
                <a href="/admin/chats" class="text-accent hover:text-yellow-600 text-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <?php if (empty($recent_chats)): ?>
            <div class="p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-comments text-6xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada chat</h3>
                <p class="text-gray-500">Customer belum mengirim pesan</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pesan Terakhir
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach (array_slice($recent_chats, 0, 5) as $chat): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= $chat['customer_name'] ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= $chat['customer_whatsapp'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        <?= htmlspecialchars($chat['message']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        <?= date('d/m/Y H:i', strtotime($chat['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/admin/chats?customer=<?= $chat['user_id'] ?>" class="text-accent hover:text-yellow-600">
                                        Balas
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateStatus(bookingId, status) {
    if (!confirm('Apakah Anda yakin ingin mengubah status booking ini?')) {
        return;
    }
    
    fetch('/admin/update-booking-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `booking_id=${bookingId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status booking berhasil diperbarui');
            location.reload();
        } else {
            alert('Gagal memperbarui status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui status');
    });
}
</script>

<?= $this->endSection() ?>