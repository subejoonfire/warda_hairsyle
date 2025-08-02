<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Customer</h1>
            <p class="text-gray-600">Lihat daftar semua customer terdaftar</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Search -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" action="/admin/customers" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="<?= $search ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="Cari nama atau nomor WhatsApp...">
                </div>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </form>
        </div>

        <!-- Customers Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
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
                                                    <img class="h-10 w-10 rounded-full" src="<?= $customer['profile_image'] ?>" alt="<?= $customer['name'] ?>">
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
                                           class="text-primary hover:text-blue-700 text-xs">
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
                                               class="text-primary hover:text-blue-700" title="Lihat Booking">
                                                <i class="fas fa-calendar"></i>
                                            </a>
                                            <a href="/admin/chats?customer=<?= $customer['id'] ?>" 
                                               class="text-green-600 hover:text-green-900" title="Chat">
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