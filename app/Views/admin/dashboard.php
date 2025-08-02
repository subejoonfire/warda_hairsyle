<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="space-y-4 sm:space-y-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary to-secondary text-white rounded-lg p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2">Dashboard Admin</h1>
                <p class="text-xs sm:text-sm md:text-base text-gray-200">Kelola layanan, booking, dan customer</p>
            </div>
            <div class="text-left md:text-right">
                <p class="text-xs sm:text-sm text-gray-300">Admin</p>
                <p class="font-semibold text-sm md:text-base"><?= session()->get('user_name') ?></p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
        <div class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-blue-500 text-white w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-sm sm:text-lg md:text-xl"></i>
                </div>
                <div class="ml-2 sm:ml-3 md:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Customer</p>
                    <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900"><?= $total_customers ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-green-500 text-white w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar-check text-sm sm:text-lg md:text-xl"></i>
                </div>
                <div class="ml-2 sm:ml-3 md:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Booking</p>
                    <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900"><?= $total_bookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-yellow-500 text-white w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-sm sm:text-lg md:text-xl"></i>
                </div>
                <div class="ml-2 sm:ml-3 md:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Menunggu</p>
                    <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900"><?= $pending_bookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-accent text-white w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-cut text-sm sm:text-lg md:text-xl"></i>
                </div>
                <div class="ml-2 sm:ml-3 md:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Hairstyles</p>
                    <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">6</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
        <a href="/admin/hairstyles/create" class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-accent text-white w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mx-auto mb-2 sm:mb-3 md:mb-4">
                <i class="fas fa-plus text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg md:text-xl font-semibold mb-1 sm:mb-2">Tambah Hairstyle</h3>
            <p class="text-xs sm:text-sm md:text-base text-gray-600">Tambah hairstyle baru ke katalog</p>
        </a>

        <a href="/admin/bookings" class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-primary text-white w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mx-auto mb-2 sm:mb-3 md:mb-4">
                <i class="fas fa-calendar-alt text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg md:text-xl font-semibold mb-1 sm:mb-2">Kelola Booking</h3>
            <p class="text-xs sm:text-sm md:text-base text-gray-600">Lihat dan kelola semua booking</p>
        </a>

        <a href="/admin/chats" class="bg-white p-3 sm:p-4 md:p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-green-500 text-white w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mx-auto mb-2 sm:mb-3 md:mb-4">
                <i class="fas fa-comments text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg md:text-xl font-semibold mb-1 sm:mb-2">Chat Customer</h3>
            <p class="text-xs sm:text-sm md:text-base text-gray-600">Balas pesan dari customer</p>
        </a>
    </div>

    <!-- Today's Bookings -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-2 sm:mb-0">Booking Hari Ini</h2>
                <div class="text-xs sm:text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Waktu Makassar: <?= date('d/m/Y H:i', strtotime($current_time)) ?> WITA
                </div>
            </div>
        </div>
        
        <?php if (empty($today_bookings)): ?>
            <div class="p-6 sm:p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-calendar-times text-4xl sm:text-6xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-600 mb-2">Tidak ada booking hari ini</h3>
                <p class="text-sm text-gray-500">Belum ada customer yang booking untuk hari ini</p>
            </div>
        <?php else: ?>
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
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
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-accent hover:text-yellow-600 transition duration-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3 p-3 sm:p-4">
                <?php foreach ($today_bookings as $booking): ?>
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
                    <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border">
                        <div class="flex justify-between items-start mb-3">
                            <div class="min-w-0 flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate"><?= $booking['customer_name'] ?></h3>
                                <p class="text-xs sm:text-sm text-gray-500 truncate"><?= $booking['customer_whatsapp'] ?></p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $statusColors[$booking['status']] ?> flex-shrink-0 ml-2">
                                <?= $statusText[$booking['status']] ?>
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-xs sm:text-sm text-gray-600">Hairstyle:</span>
                                <span class="text-xs sm:text-sm font-medium truncate ml-2"><?= $booking['hairstyle_name'] ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs sm:text-sm text-gray-600">Waktu:</span>
                                <span class="text-xs sm:text-sm font-medium"><?= $booking['booking_time'] ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-gray-600">Layanan:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $booking['service_type'] === 'home' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                </span>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-accent hover:text-yellow-600 text-xs sm:text-sm font-medium transition duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Pending Bookings -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">Booking Menunggu Konfirmasi</h2>
        </div>
        
        <?php if (empty($recent_bookings)): ?>
            <div class="p-6 sm:p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-check-circle text-4xl sm:text-6xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-600 mb-2">Tidak ada booking pending</h3>
                <p class="text-sm text-gray-500">Semua booking telah dikonfirmasi</p>
            </div>
        <?php else: ?>
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
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
                                        <?= date('d/m/Y H:i', strtotime($booking['booking_date'] . ' ' . $booking['booking_time'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $booking['service_type'] === 'home' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-accent hover:text-yellow-600 transition duration-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3 p-3 sm:p-4">
                <?php foreach ($recent_bookings as $booking): ?>
                    <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border">
                        <div class="flex justify-between items-start mb-3">
                            <div class="min-w-0 flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate"><?= $booking['customer_name'] ?></h3>
                                <p class="text-xs sm:text-sm text-gray-500 truncate"><?= $booking['customer_whatsapp'] ?></p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 flex-shrink-0 ml-2">
                                Menunggu
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-xs sm:text-sm text-gray-600">Hairstyle:</span>
                                <span class="text-xs sm:text-sm font-medium truncate ml-2"><?= $booking['hairstyle_name'] ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs sm:text-sm text-gray-600">Tanggal:</span>
                                <span class="text-xs sm:text-sm font-medium"><?= date('d/m/Y H:i', strtotime($booking['booking_date'] . ' ' . $booking['booking_time'])) ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-gray-600">Layanan:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $booking['service_type'] === 'home' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                </span>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-accent hover:text-yellow-600 text-xs sm:text-sm font-medium transition duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Chats -->
    <?php if (!empty($recent_chats)): ?>
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">Chat Terbaru</h2>
        </div>
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pesan
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
                    <?php foreach ($recent_chats as $chat): ?>
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
                                    <?= $chat['message'] ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    <?= date('d/m/Y H:i', strtotime($chat['created_at'])) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/admin/chats?customer=<?= $chat['user_id'] ?>" class="text-accent hover:text-yellow-600 transition duration-200">
                                    Balas
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-3 p-3 sm:p-4">
            <?php foreach ($recent_chats as $chat): ?>
                <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border">
                    <div class="flex justify-between items-start mb-3">
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate"><?= $chat['customer_name'] ?></h3>
                            <p class="text-xs sm:text-sm text-gray-500 truncate"><?= $chat['customer_whatsapp'] ?></p>
                        </div>
                        <span class="text-xs text-gray-500 flex-shrink-0 ml-2">
                            <?= date('H:i', strtotime($chat['created_at'])) ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <p class="text-xs sm:text-sm text-gray-700 line-clamp-2"><?= $chat['message'] ?></p>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <a href="/admin/chats?customer=<?= $chat['user_id'] ?>" class="text-accent hover:text-yellow-600 text-xs sm:text-sm font-medium transition duration-200">
                            Balas Chat
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Add any dashboard-specific JavaScript here
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh dashboard every 30 seconds
    setInterval(function() {
        window.location.reload();
    }, 30000);
});
</script>

<?= $this->endSection() ?>