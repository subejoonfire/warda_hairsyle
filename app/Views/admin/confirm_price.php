<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Konfirmasi Harga Booking #<?= $booking['id'] ?></h1>
            <p class="text-gray-600 mt-1">Review foto customer dan tentukan harga final</p>
        </div>
        <a href="/admin/price-confirmation" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-primary text-white px-6 py-4">
                    <h2 class="text-lg font-semibold">Detail Booking</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Informasi Customer</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Nama:</span>
                                    <p class="font-medium"><?= $booking['customer_name'] ?></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">WhatsApp:</span>
                                    <p class="font-medium"><?= $booking['customer_whatsapp'] ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Detail Layanan</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Hairstyle:</span>
                                    <p class="font-medium"><?= $booking['hairstyle_name'] ?></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Service Type:</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $booking['service_type'] === 'boxbraid' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= ucfirst($booking['service_type']) ?>
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Tanggal:</span>
                                    <p class="font-medium"><?= date('d/m/Y', strtotime($booking['booking_date'])) ?></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Waktu:</span>
                                    <p class="font-medium"><?= $booking['booking_time'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($booking['notes']): ?>
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Catatan Customer</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($booking['notes'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Harga Estimasi Saat Ini</h3>
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <p class="text-2xl font-bold text-accent">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></p>
                            <p class="text-sm text-yellow-700 mt-1">Harga ini dapat disesuaikan berdasarkan kondisi rambut customer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Confirmation Form -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-accent text-white px-6 py-4">
                    <h2 class="text-lg font-semibold">Konfirmasi Harga</h2>
                </div>
                <div class="p-6">
                    <form method="POST" class="space-y-6">
                        <div>
                            <label for="confirmed_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Final</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" id="confirmed_price" name="confirmed_price" 
                                       value="<?= $booking['total_price'] ?>" min="0" step="1000" required
                                       class="pl-12 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-lg">
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                Sesuaikan harga berdasarkan kondisi rambut customer dan tingkat kesulitan
                            </p>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" name="action" value="confirm" 
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-check mr-2"></i>
                                Konfirmasi Harga
                            </button>
                            <button type="submit" name="action" value="reject" 
                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Tolak Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Photo Sidebar -->
        <div class="lg:col-span-1">
            <?php if ($booking['customer_photo']): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden sticky top-6">
                <div class="bg-primary text-white px-6 py-4">
                    <h2 class="text-lg font-semibold">Foto Rambut Customer</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <img src="/<?= $booking['customer_photo'] ?>" 
                             alt="Customer Hair Photo" 
                             class="w-full h-auto rounded-lg border border-gray-200">
                    </div>
                    <a href="/<?= $booking['customer_photo'] ?>" target="_blank" 
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center block transition duration-200">
                        <i class="fas fa-expand mr-2"></i>
                        Lihat Full Size
                    </a>
                </div>
            </div>
            <?php else: ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-image text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Foto</h3>
                    <p class="text-gray-500">Customer tidak mengupload foto rambut</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>