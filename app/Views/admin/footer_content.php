<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Konten Footer</h1>
            <p class="text-gray-600 mt-1">Kelola konten dinamis untuk footer website</p>
        </div>
        <a href="/admin/footer-content/edit" class="bg-accent hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Konten
        </a>
    </div>

    <!-- Content Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-primary text-white px-6 py-4">
            <h2 class="text-lg font-semibold">Daftar Konten Footer</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($footer_content as $content): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= $content['id'] ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                <?= $content['section'] === 'about' ? 'bg-blue-100 text-blue-800' : 
                                    ($content['section'] === 'services' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') ?>">
                                <?= ucfirst($content['section']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <?php if ($content['title']): ?>
                                <div class="font-medium"><?= $content['title'] ?></div>
                            <?php else: ?>
                                <em class="text-gray-400">No title</em>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="max-w-xs truncate" title="<?= htmlspecialchars($content['content']) ?>">
                                <?= substr($content['content'], 0, 40) ?><?= strlen($content['content']) > 40 ? '...' : '' ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if ($content['icon']): ?>
                                <div class="flex items-center">
                                    <i class="<?= $content['icon'] ?> text-lg mr-2"></i>
                                    <span class="text-xs text-gray-400"><?= $content['icon'] ?></span>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 italic">No icon</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                <?= $content['order_position'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $content['is_active'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                <?= $content['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="/admin/footer-content/edit/<?= $content['id'] ?>" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/footer-content/delete/<?= $content['id'] ?>" 
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition duration-200"
                                   onclick="return confirm('Yakin ingin menghapus konten ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>