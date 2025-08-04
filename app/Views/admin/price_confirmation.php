<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Konfirmasi Harga Booking</h1>
            <p class="text-gray-600 mt-1">Kelola booking dengan harga yang menunggu konfirmasi admin</p>
        </div>
        <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg">
            <span class="font-semibold"><?= count($pending_bookings) ?></span> booking menunggu
        </div>
    </div>

    <!-- Content Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-primary text-white px-6 py-4">
            <h2 class="text-lg font-semibold">Booking Menunggu Konfirmasi Harga</h2>
        </div>
        <div class="p-6">
            <?php if (empty($pending_bookings)): ?>
                <div class="text-center py-12">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-check-circle text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Semua Booking Sudah Dikonfirmasi</h3>
                    <p class="text-gray-500">Tidak ada booking yang menunggu konfirmasi harga saat ini.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-6">
                    <?php foreach ($pending_bookings as $booking): ?>
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold mr-3">
                                        ID #<?= $booking['id'] ?>
                                    </span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $booking['service_type'] === 'boxbraid' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= ucfirst($booking['service_type']) ?>
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-1">Customer</h4>
                                        <p class="text-sm text-gray-600"><?= $booking['customer_name'] ?></p>
                                        <p class="text-xs text-gray-500"><?= $booking['customer_whatsapp'] ?></p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-1">Layanan</h4>
                                        <p class="text-sm text-gray-600"><?= $booking['hairstyle_name'] ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?= date('d/m/Y', strtotime($booking['booking_date'])) ?> - <?= $booking['booking_time'] ?>
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-1">Harga Estimasi</h4>
                                        <p class="text-lg font-bold text-accent">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 ml-6">
                                <?php if ($booking['customer_photo']): ?>
                                    <a href="/<?= $booking['customer_photo'] ?>" target="_blank" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                                        <i class="fas fa-image mr-1"></i>
                                        Lihat Foto
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 italic text-sm">No photo</span>
                                <?php endif; ?>
                                
                                <a href="/admin/price-confirmation/<?= $booking['id'] ?>" 
                                   class="bg-accent hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                                    <i class="fas fa-check mr-1"></i>
                                    Konfirmasi
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>