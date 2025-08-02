<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="py-4 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Booking</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Informasi lengkap booking customer</p>
                </div>
                <a href="<?= base_url('admin/bookings') ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800"><?= session()->getFlashdata('success') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800"><?= session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Booking Information -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Customer Information -->
            <div class="px-4 py-5 sm:p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Customer</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($booking['customer_name']) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">WhatsApp</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($booking['customer_whatsapp']) ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Booking</label>
                        <p class="mt-1 text-sm text-gray-900"><?= date('d/m/Y H:i', strtotime($booking['booking_date'])) ?></p>
                    </div>
                </div>
            </div>

            <!-- Service Information -->
            <div class="px-4 py-5 sm:p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Layanan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hairstyle</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($booking['hairstyle_name']) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Layanan</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($booking['service_type']) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                        <p class="mt-1 text-sm text-gray-900">Rp <?= number_format($booking['hairstyle_price'], 0, ',', '.') ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            <?php
                            switch ($booking['status']) {
                                case 'pending':
                                    echo 'bg-yellow-100 text-yellow-800';
                                    break;
                                case 'confirmed':
                                    echo 'bg-blue-100 text-blue-800';
                                    break;
                                case 'completed':
                                    echo 'bg-green-100 text-green-800';
                                    break;
                                case 'cancelled':
                                    echo 'bg-red-100 text-red-800';
                                    break;
                                default:
                                    echo 'bg-gray-100 text-gray-800';
                            }
                            ?>">
                            <?= ucfirst($booking['status']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $booking['notes'] ? esc($booking['notes']) : 'Tidak ada catatan' ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dibuat pada</label>
                        <p class="mt-1 text-sm text-gray-900"><?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></p>
                    </div>
                    <?php if ($booking['updated_at'] && $booking['updated_at'] !== $booking['created_at']): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Terakhir diperbarui</label>
                            <p class="mt-1 text-sm text-gray-900"><?= date('d/m/Y H:i', strtotime($booking['updated_at'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4">
            <?php if ($booking['status'] === 'pending'): ?>
                <button onclick="updateStatus('confirmed')" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <i class="fas fa-check mr-2"></i>
                    Konfirmasi Booking
                </button>
                <button onclick="updateStatus('cancelled')" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Batalkan Booking
                </button>
            <?php elseif ($booking['status'] === 'confirmed'): ?>
                <button onclick="updateStatus('completed')" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    <i class="fas fa-check-double mr-2"></i>
                    Selesai
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    const statusText = {
        'confirmed': 'konfirmasi',
        'cancelled': 'batalkan',
        'completed': 'selesai'
    };

    showNotification('Memperbarui status booking...', 'info');

    const formData = new FormData();
    formData.append('booking_id', '<?= $booking['id'] ?>');
    formData.append('status', status);

    fetch('<?= base_url('admin/update-booking-status') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Gagal memperbarui status booking', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memperbarui status booking', 'error');
    });
}
</script>
<?= $this->endSection() ?>