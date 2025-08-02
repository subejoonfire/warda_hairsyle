<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary to-secondary text-white rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat datang, <?= $user['name'] ?>!</h1>
                <p class="text-gray-200">Kelola booking dan lihat riwayat layanan Anda</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-300">WhatsApp</p>
                <p class="font-semibold"><?= $user['whatsapp'] ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="/booking" class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-plus text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Booking Baru</h3>
            <p class="text-gray-600">Buat booking untuk layanan cukur rambut</p>
        </a>

        <a href="/hairstyles" class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center">
            <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-cut text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Lihat Hairstyles</h3>
            <p class="text-gray-600">Jelajahi berbagai pilihan hairstyle</p>
        </a>

        <a href="/chat" class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 text-center relative">
            <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-comments text-2xl"></i>
            </div>
            <?php if ($unread_chats > 0): ?>
                <span class="absolute top-4 right-4 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                    <?= $unread_chats ?>
                </span>
            <?php endif; ?>
            <h3 class="text-xl font-semibold mb-2">Chat dengan Admin</h3>
            <p class="text-gray-600">Konsultasi atau tanya jawab dengan admin</p>
        </a>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Booking Terbaru</h2>
        </div>
        
        <?php if (empty($recent_bookings)): ?>
            <div class="p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-calendar-times text-6xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada booking</h3>
                <p class="text-gray-500 mb-4">Anda belum pernah melakukan booking layanan</p>
                <a href="/booking" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition duration-300">
                    Booking Sekarang
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
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
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recent_bookings as $booking): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp <?= number_format($booking['total_price'], 0, ',', '.') ?>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <?php
        $totalBookings = count($recent_bookings);
        $completedBookings = count(array_filter($recent_bookings, function($b) { return $b['status'] === 'completed'; }));
        $pendingBookings = count(array_filter($recent_bookings, function($b) { return $b['status'] === 'pending'; }));
        $totalSpent = array_sum(array_column($recent_bookings, 'total_price'));
        ?>
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Booking</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $totalBookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-green-500 text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $completedBookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-yellow-500 text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $pendingBookings ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="bg-accent text-white w-12 h-12 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-gray-900">Rp <?= number_format($totalSpent, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>