<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Hairstyle</h1>
            <p class="text-gray-600">Informasi lengkap hairstyle</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?= base_url('admin/hairstyles/edit/' . $hairstyle['id']) ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="<?= base_url('admin/hairstyles') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Hairstyle Details -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Hairstyle</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Hairstyle</label>
                        <p class="text-lg font-semibold text-gray-900"><?= esc($hairstyle['name']) ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <p class="text-gray-900"><?= esc($hairstyle['description'] ?: 'Tidak ada deskripsi') ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <p class="text-gray-900">
                            <?php if ($category) : ?>
                                <?= esc($category['name']) ?>
                            <?php else : ?>
                                <span class="text-gray-500">Tidak ada kategori</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <p class="text-lg font-semibold text-gray-900">Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?></p>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Durasi</label>
                        <p class="text-gray-900"><?= $hairstyle['duration_minutes'] ?? 60 ?> menit</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Level Kesulitan</label>
                        <p class="text-gray-900">
                            <?php 
                            $difficultyLabels = [
                                'easy' => 'Mudah',
                                'medium' => 'Sedang',
                                'hard' => 'Sulit'
                            ];
                            echo $difficultyLabels[$hairstyle['difficulty_level'] ?? 'medium'] ?? 'Sedang';
                            ?>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                        <p class="text-gray-900">
                            <?php if (!empty($hairstyle['tags'])) : ?>
                                <?= esc($hairstyle['tags']) ?>
                            <?php else : ?>
                                <span class="text-gray-500">Tidak ada tags</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <p class="text-gray-900"><?= $hairstyle['sort_order'] ?? 0 ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                   <?= $hairstyle['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= $hairstyle['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <?php if (!empty($hairstyle['image_url'])) : ?>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    <div class="max-w-xs">
                        <img src="<?= esc($hairstyle['image_url']) ?>" alt="<?= esc($hairstyle['name']) ?>" 
                             class="w-full h-auto rounded-lg shadow-md">
                    </div>
                </div>
            <?php endif; ?>

            <!-- Timestamps -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                    <div>
                        <span class="font-medium">Dibuat:</span> 
                        <?= date('d/m/Y H:i', strtotime($hairstyle['created_at'])) ?>
                    </div>
                    <div>
                        <span class="font-medium">Diperbarui:</span> 
                        <?= date('d/m/Y H:i', strtotime($hairstyle['updated_at'])) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>