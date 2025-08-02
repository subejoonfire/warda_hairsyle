<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Booking</h1>
            <p class="text-gray-600 text-sm sm:text-base">Lihat dan kelola semua booking customer</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8">
            <form method="GET" action="/admin/bookings" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= ($status ?? '') === 'confirmed' ? 'selected' : '' ?>>Dikonfirmasi</option>
                        <option value="completed" <?= ($status ?? '') === 'completed' ? 'selected' : '' ?>>Selesai</option>
                        <option value="cancelled" <?= ($status ?? '') === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="date" id="date" value="<?= $date ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Customer</label>
                    <input type="text" name="search" id="search" value="<?= $search ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                           placeholder="Nama atau WhatsApp">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 text-sm">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
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
                                Total
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
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-gray-400 text-4xl mb-4">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <p class="text-lg font-medium">Tidak ada booking</p>
                                    <p class="text-sm">Belum ada customer yang melakukan booking</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?= $booking['customer_name'] ?></div>
                                            <div class="text-sm text-gray-500"><?= $booking['customer_whatsapp'] ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= $booking['hairstyle_name'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= date('d/m/Y', strtotime($booking['booking_date'])) ?>
                                        </div>
                                        <div class="text-sm text-gray-500"><?= $booking['booking_time'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                   <?= $booking['service_type'] === 'home' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                            <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                        </span>
                                        <?php if ($booking['service_type'] === 'home' && !empty($booking['address'])): ?>
                                            <div class="text-xs text-gray-500 mt-1"><?= $booking['address'] ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?= number_format($booking['total_price'], 0, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                   <?= $booking['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                      ($booking['status'] === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                                      ($booking['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                                      'bg-red-100 text-red-800')) ?>">
                                            <?= ucfirst($booking['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="/admin/bookings/<?= $booking['id'] ?>" 
                                               class="text-primary hover:text-blue-700 transition duration-200" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($booking['status'] === 'pending'): ?>
                                                <button onclick="updateStatus(<?= $booking['id'] ?>, 'confirmed')" 
                                                        class="text-green-600 hover:text-green-900 transition duration-200" title="Konfirmasi">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button onclick="updateStatus(<?= $booking['id'] ?>, 'cancelled')" 
                                                        class="text-red-600 hover:text-red-900 transition duration-200" title="Batalkan">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php elseif ($booking['status'] === 'confirmed'): ?>
                                                <button onclick="updateStatus(<?= $booking['id'] ?>, 'completed')" 
                                                        class="text-green-600 hover:text-green-900 transition duration-200" title="Selesai">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden">
                <?php if (empty($bookings)): ?>
                    <div class="p-6 text-center text-gray-500">
                        <div class="text-gray-400 text-4xl mb-4">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <p class="text-lg font-medium">Tidak ada booking</p>
                        <p class="text-sm">Belum ada customer yang melakukan booking</p>
                    </div>
                <?php else: ?>
                    <div class="p-3 sm:p-4 space-y-3">
                        <?php foreach ($bookings as $booking): ?>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate"><?= $booking['customer_name'] ?></h3>
                                        <p class="text-xs sm:text-sm text-gray-500 truncate"><?= $booking['customer_whatsapp'] ?></p>
                                    </div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full flex-shrink-0 ml-2
                                               <?= $booking['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                  ($booking['status'] === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                                  ($booking['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                                  'bg-red-100 text-red-800')) ?>">
                                        <?= ucfirst($booking['status']) ?>
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Hairstyle:</span>
                                        <span class="text-xs sm:text-sm font-medium truncate ml-2"><?= $booking['hairstyle_name'] ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Tanggal:</span>
                                        <span class="text-xs sm:text-sm font-medium"><?= date('d/m/Y', strtotime($booking['booking_date'])) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Waktu:</span>
                                        <span class="text-xs sm:text-sm font-medium"><?= $booking['booking_time'] ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs sm:text-sm text-gray-600">Layanan:</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                   <?= $booking['service_type'] === 'home' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                            <?= $booking['service_type'] === 'home' ? 'Home Service' : 'Salon' ?>
                                        </span>
                                    </div>
                                    <?php if ($booking['service_type'] === 'home' && !empty($booking['address'])): ?>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Alamat:</span>
                                        <span class="text-xs sm:text-sm font-medium truncate ml-2 max-w-32"><?= $booking['address'] ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Total:</span>
                                        <span class="text-xs sm:text-sm font-medium">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between items-center">
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="text-primary hover:text-blue-700 text-xs sm:text-sm font-medium transition duration-200">
                                        Lihat Detail
                                    </a>
                                    <div class="flex space-x-2">
                                        <?php if ($booking['status'] === 'pending'): ?>
                                            <button onclick="updateStatus(<?= $booking['id'] ?>, 'confirmed')" 
                                                    class="text-green-600 hover:text-green-900 p-1 transition duration-200" title="Konfirmasi">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                            <button onclick="updateStatus(<?= $booking['id'] ?>, 'cancelled')" 
                                                    class="text-red-600 hover:text-red-900 p-1 transition duration-200" title="Batalkan">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                        <?php elseif ($booking['status'] === 'confirmed'): ?>
                                            <button onclick="updateStatus(<?= $booking['id'] ?>, 'completed')" 
                                                    class="text-green-600 hover:text-green-900 p-1 transition duration-200" title="Selesai">
                                                <i class="fas fa-check-double text-sm"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script>
function updateStatus(bookingId, status) {
    const statusText = {
        'confirmed': 'mengkonfirmasi',
        'completed': 'menyelesaikan',
        'cancelled': 'membatalkan'
    };
    
    const statusDisplay = {
        'confirmed': 'Dikonfirmasi',
        'completed': 'Selesai',
        'cancelled': 'Dibatalkan'
    };
    
    // Show confirmation dialog using custom notification
    const confirmed = confirm(`Apakah Anda yakin ingin ${statusText[status]} booking ini?`);
    
    if (confirmed) {
        // Show loading notification
        showNotification('Memproses perubahan status...', 'info');
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/update-booking-status';
        
        const bookingIdInput = document.createElement('input');
        bookingIdInput.type = 'hidden';
        bookingIdInput.name = 'booking_id';
        bookingIdInput.value = bookingId;
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        form.appendChild(bookingIdInput);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        
        // Submit form
        fetch('/admin/update-booking-status', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Status booking berhasil diubah menjadi ${statusDisplay[status]}`, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification('Gagal mengubah status: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengubah status', 'error');
        })
        .finally(() => {
            document.body.removeChild(form);
        });
    }
}
</script>

<?= $this->endSection() ?>