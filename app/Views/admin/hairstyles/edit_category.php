<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kategori</h1>
            <p class="text-gray-600">Edit kategori yang sudah ada</p>
        </div>
        <a href="<?= base_url('admin/hairstyles/categories') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?= base_url('admin/hairstyles/categories/edit/' . $category['id']) ?>" method="POST" id="categoryForm">
            <?= csrf_field() ?>
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" 
                           value="<?= old('name', $category['name']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                           placeholder="Contoh: Potong Rambut Pria" required>
                    <p class="text-xs text-gray-500 mt-1">Nama kategori yang akan ditampilkan</p>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                              placeholder="Deskripsi singkat tentang kategori ini"><?= old('description', $category['description']) ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Deskripsi singkat untuk kategori</p>
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan
                    </label>
                    <input type="number" id="sort_order" name="sort_order" 
                           value="<?= old('sort_order', $category['sort_order'] ?? 0) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                           placeholder="0">
                    <p class="text-xs text-gray-500 mt-1">Urutan tampilan (0 = paling atas)</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" 
                               <?= old('is_active', $category['is_active']) ? 'checked' : '' ?> 
                               class="rounded border-gray-300 text-accent focus:ring-accent">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Aktifkan kategori ini</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="<?= base_url('admin/hairstyles/categories') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>