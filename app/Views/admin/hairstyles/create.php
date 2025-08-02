<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Hairstyle</h1>
            <p class="text-gray-600">Tambah hairstyle baru ke dalam sistem</p>
        </div>
        <a href="<?= base_url('admin/hairstyles') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200 flex items-center">
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
        <form action="<?= base_url('admin/hairstyles/create') ?>" method="POST" id="hairstyleForm">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Hairstyle <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" 
                               value="<?= old('name') ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="Contoh: Pompadour Classic" required>
                        <p class="text-xs text-gray-500 mt-1">Nama hairstyle yang akan ditampilkan</p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="description" name="description" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                                  placeholder="Deskripsi singkat tentang hairstyle ini"><?= old('description') ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Deskripsi singkat untuk customer</p>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori
                        </label>
                        <select id="category_id" name="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Kategori hairstyle (opsional)</p>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" id="price" name="price" 
                                   value="<?= old('price') ?>" 
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                                   placeholder="50000" min="0" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Harga dalam rupiah</p>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="space-y-4">
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                            URL Gambar
                        </label>
                        <input type="url" id="image_url" name="image_url" 
                               value="<?= old('image_url') ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="https://example.com/image.jpg">
                        <p class="text-xs text-gray-500 mt-1">Link gambar hairstyle (opsional)</p>
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                            Durasi (Menit)
                        </label>
                        <input type="number" id="duration_minutes" name="duration_minutes" 
                               value="<?= old('duration_minutes', 60) ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="60" min="15" max="300">
                        <p class="text-xs text-gray-500 mt-1">Estimasi waktu pengerjaan</p>
                    </div>

                    <div>
                        <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Level Kesulitan
                        </label>
                        <select id="difficulty_level" name="difficulty_level" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                            <option value="easy" <?= old('difficulty_level') === 'easy' ? 'selected' : '' ?>>Mudah</option>
                            <option value="medium" <?= old('difficulty_level', 'medium') === 'medium' ? 'selected' : '' ?>>Sedang</option>
                            <option value="hard" <?= old('difficulty_level') === 'hard' ? 'selected' : '' ?>>Sulit</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Level kesulitan pengerjaan</p>
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                            Tags
                        </label>
                        <input type="text" id="tags" name="tags" 
                               value="<?= old('tags') ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="pria, pendek, modern">
                        <p class="text-xs text-gray-500 mt-1">Tags untuk pencarian (pisahkan dengan koma)</p>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan
                        </label>
                        <input type="number" id="sort_order" name="sort_order" 
                               value="<?= old('sort_order', 0) ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Urutan tampilan (0 = paling atas)</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" 
                                   <?= old('is_active', true) ? 'checked' : '' ?> 
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Aktifkan hairstyle ini</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="<?= base_url('admin/hairstyles') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Hairstyle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Format price input
    $('#price').on('input', function() {
        let value = $(this).val();
        // Remove non-numeric characters
        value = value.replace(/[^0-9]/g, '');
        $(this).val(value);
    });

    // Auto-format price display
    $('#price').on('blur', function() {
        let value = parseInt($(this).val()) || 0;
        if (value > 0) {
            $(this).val(value.toLocaleString('id-ID'));
        }
    });

    // Remove formatting on focus
    $('#price').on('focus', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9]/g, '');
        $(this).val(value);
    });
});
</script>
<?= $this->endSection() ?>