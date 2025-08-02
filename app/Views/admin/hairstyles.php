<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Hairstyle</h1>
                <p class="text-gray-600 text-sm sm:text-base">Tambah, edit, dan hapus hairstyle</p>
            </div>
            <a href="/admin/hairstyles/create" class="bg-primary text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:bg-blue-700 transition duration-300 text-sm sm:text-base">
                <i class="fas fa-plus mr-2"></i>Tambah Hairstyle
            </a>
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

        <!-- Hairstyles Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gambar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
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
                        <?php if (empty($hairstyles)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-gray-400 text-4xl mb-4">
                                        <i class="fas fa-cut"></i>
                                    </div>
                                    <p class="text-lg font-medium">Belum ada hairstyle</p>
                                    <p class="text-sm">Mulai dengan menambahkan hairstyle pertama</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($hairstyles as $hairstyle): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                            <?php if (!empty($hairstyle['image'])): ?>
                                                <img src="<?= $hairstyle['image'] ?>" alt="<?= $hairstyle['name'] ?>" 
                                                     class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-cut text-gray-400"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?= $hairstyle['name'] ?></div>
                                            <div class="text-sm text-gray-500 line-clamp-2"><?= $hairstyle['description'] ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                   <?= $hairstyle['category'] === 'classic' ? 'bg-blue-100 text-blue-800' : 
                                                      ($hairstyle['category'] === 'modern' ? 'bg-green-100 text-green-800' : 
                                                      ($hairstyle['category'] === 'fade' ? 'bg-purple-100 text-purple-800' : 
                                                      'bg-gray-100 text-gray-800')) ?>">
                                            <?= ucfirst($hairstyle['category']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                   <?= $hairstyle['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= $hairstyle['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="/admin/hairstyles/edit/<?= $hairstyle['id'] ?>" 
                                               class="text-primary hover:text-blue-700 transition duration-200">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="deleteHairstyle(<?= $hairstyle['id'] ?>, '<?= $hairstyle['name'] ?>')" 
                                                    class="text-red-600 hover:text-red-900 transition duration-200">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                <?php if (empty($hairstyles)): ?>
                    <div class="p-6 text-center text-gray-500">
                        <div class="text-gray-400 text-4xl mb-4">
                            <i class="fas fa-cut"></i>
                        </div>
                        <p class="text-lg font-medium">Belum ada hairstyle</p>
                        <p class="text-sm">Mulai dengan menambahkan hairstyle pertama</p>
                    </div>
                <?php else: ?>
                    <div class="p-3 sm:p-4 space-y-3">
                        <?php foreach ($hairstyles as $hairstyle): ?>
                            <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border">
                                <div class="flex items-start mb-3">
                                    <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                        <?php if (!empty($hairstyle['image'])): ?>
                                            <img src="<?= $hairstyle['image'] ?>" alt="<?= $hairstyle['name'] ?>" 
                                                 class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-cut text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-3 min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate"><?= $hairstyle['name'] ?></h3>
                                        <p class="text-xs sm:text-sm text-gray-500 line-clamp-2 mt-1"><?= $hairstyle['description'] ?></p>
                                        <div class="flex items-center space-x-2 mt-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                       <?= $hairstyle['category'] === 'classic' ? 'bg-blue-100 text-blue-800' : 
                                                          ($hairstyle['category'] === 'modern' ? 'bg-green-100 text-green-800' : 
                                                          ($hairstyle['category'] === 'fade' ? 'bg-purple-100 text-purple-800' : 
                                                          'bg-gray-100 text-gray-800')) ?>">
                                                <?= ucfirst($hairstyle['category']) ?>
                                            </span>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                       <?= $hairstyle['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                                <?= $hairstyle['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs sm:text-sm text-gray-600">Harga:</span>
                                        <span class="text-xs sm:text-sm font-medium">Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between items-center">
                                    <a href="/admin/hairstyles/edit/<?= $hairstyle['id'] ?>" 
                                       class="text-primary hover:text-blue-700 text-xs sm:text-sm font-medium transition duration-200">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <button onclick="deleteHairstyle(<?= $hairstyle['id'] ?>, '<?= $hairstyle['name'] ?>')" 
                                            class="text-red-600 hover:text-red-900 text-xs sm:text-sm font-medium transition duration-200">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function deleteHairstyle(id, name) {
    const confirmed = confirm(`Apakah Anda yakin ingin menghapus hairstyle "${name}"?`);
    
    if (confirmed) {
        showNotification('Menghapus hairstyle...', 'info');
        
        fetch(`/admin/hairstyles/delete/${id}`, {
            method: 'GET'
        })
        .then(response => {
            if (response.ok) {
                showNotification('Hairstyle berhasil dihapus!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification('Gagal menghapus hairstyle', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat menghapus hairstyle', 'error');
        });
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?= $this->endSection() ?>