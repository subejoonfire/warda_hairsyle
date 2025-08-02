<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Customer</h1>
            <p class="text-gray-600 text-sm sm:text-base">Lihat daftar semua customer terdaftar</p>
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

        <!-- Search -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8">
            <form method="GET" action="/admin/customers" class="flex gap-3 sm:gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="<?= $search ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                           placeholder="Cari nama atau nomor WhatsApp...">
                </div>
                <button type="submit" class="bg-primary text-white px-4 sm:px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300 text-sm">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </form>
        </div>

        <!-- Customers Table -->
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
                                WhatsApp
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Booking
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Terdaftar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($customers)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-gray-400 text-4xl mb-4">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <p class="text-lg font-medium">Tidak ada customer</p>
                                    <p class="text-sm">Belum ada customer yang terdaftar</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <?php if (!empty($customer['profile_image'])): ?>
                                                    <img class="h-10 w-10 rounded-full object-cover" src="<?= $customer['profile_image'] ?>" alt="<?= $customer['name'] ?>">
                                                <?php else: ?>
                                                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center">
                                                        <span class="text-white font-medium"><?= strtoupper(substr($customer['name'], 0, 1)) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?= $customer['name'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= $customer['whatsapp'] ?></div>
                                        <a href="https://wa.me/<?= $customer['whatsapp'] ?>" target="_blank" 
                                           class="text-primary hover:text-blue-700 text-xs transition duration-200">
                                            <i class="fab fa-whatsapp mr-1"></i>Chat
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?= !empty($customer['address']) ? $customer['address'] : '<span class="text-gray-400">-</span>' ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                   <?= $customer['is_verified'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= $customer['is_verified'] ? 'Terverifikasi' : 'Belum Verifikasi' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= $customer['total_bookings'] ?? 0 ?> booking
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d/m/Y', strtotime($customer['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="/admin/customers/<?= $customer['id'] ?>/bookings" 
                                               class="text-primary hover:text-blue-700 transition duration-200" title="Lihat Booking">
                                                <i class="fas fa-calendar"></i>
                                            </a>
                                            <a href="/admin/chats?customer=<?= $customer['id'] ?>" 
                                               class="text-green-600 hover:text-green-900 transition duration-200" title="Chat">
                                                <i class="fas fa-comments"></i>
                                            </a>
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
                <?php if (empty($customers)): ?>
                    <div class="p-6 text-center text-gray-500">
                        <div class="text-gray-400 text-4xl mb-4">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="text-lg font-medium">Tidak ada customer</p>
                        <p class="text-sm">Belum ada customer yang terdaftar</p>
                    </div>
                <?php else: ?>
                    <div class="p-3 sm:p-4 space-y-3">
                        <?php foreach ($customers as $customer): ?>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border">
                                <div class="flex items-start mb-3">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <?php if (!empty($customer['profile_image'])): ?>
                                            <img class="h-12 w-12 rounded-full object-cover" src="<?= $customer['profile_image'] ?>" alt="<?= $customer['name'] ?>">
                                        <?php else: ?>
                                            <div class="h-12 w-12 rounded-full bg-primary flex items-center justify-center">
                                                <span class="text-white font-medium text-lg"><?= strtoupper(substr($customer['name'], 0, 1)) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-3 min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate"><?= $customer['name'] ?></h3>
                                        <p class="text-xs sm:text-sm text-gray-500 truncate"><?= $customer['whatsapp'] ?></p>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1
                                                   <?= $customer['is_verified'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= $customer['is_verified'] ? 'Terverifikasi' : 'Belum Verifikasi' ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <?php if (!empty($customer['address'])): ?>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Alamat:</span>
                                        <span class="text-xs sm:text-sm font-medium truncate ml-2 max-w-32"><?= $customer['address'] ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Total Booking:</span>
                                        <span class="text-xs sm:text-sm font-medium"><?= $customer['total_bookings'] ?? 0 ?> booking</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Terdaftar:</span>
                                        <span class="text-xs sm:text-sm font-medium"><?= date('d/m/Y', strtotime($customer['created_at'])) ?></span>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between items-center">
                                    <div class="flex space-x-3">
                                        <a href="/admin/customers/<?= $customer['id'] ?>/bookings" 
                                           class="text-primary hover:text-blue-700 text-xs sm:text-sm font-medium transition duration-200">
                                            <i class="fas fa-calendar mr-1"></i>Booking
                                        </a>
                                        <a href="/admin/chats?customer=<?= $customer['id'] ?>" 
                                           class="text-green-600 hover:text-green-900 text-xs sm:text-sm font-medium transition duration-200">
                                            <i class="fas fa-comments mr-1"></i>Chat
                                        </a>
                                    </div>
                                    <a href="https://wa.me/<?= $customer['whatsapp'] ?>" target="_blank" 
                                       class="text-primary hover:text-blue-700 p-2 transition duration-200">
                                        <i class="fab fa-whatsapp text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
            <div class="mt-6 flex justify-center">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>