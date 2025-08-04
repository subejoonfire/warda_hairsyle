<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $content ? 'Edit' : 'Tambah' ?> Konten Halaman Utama</h1>
            <p class="text-gray-600 mt-1">
                <?= $content ? 'Ubah konten yang sudah ada' : 'Tambahkan konten baru ke halaman utama' ?>
            </p>
        </div>
        <a href="/admin/home-content" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-primary text-white px-6 py-4">
            <h2 class="text-lg font-semibold">Form Konten</h2>
        </div>
        <div class="p-6">
            <form method="POST" class="space-y-6">
                <?php if (!$content): ?>
                <div>
                    <label for="section" class="block text-sm font-medium text-gray-700 mb-2">Section</label>
                    <select id="section" name="section" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        <option value="">Pilih Section</option>
                        <option value="why_choose_us">Why Choose Us</option>
                        <option value="services">Services</option>
                    </select>
                </div>
                <?php endif; ?>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="title" name="title" required
                           value="<?= htmlspecialchars($content['title'] ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                           placeholder="Masukkan judul konten">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                              placeholder="Masukkan deskripsi konten"><?= htmlspecialchars($content['description'] ?? '') ?></textarea>
                </div>

                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (FontAwesome Class)</label>
                    <input type="text" id="icon" name="icon"
                           value="<?= htmlspecialchars($content['icon'] ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                           placeholder="Contoh: fas fa-star">
                    <p class="text-sm text-gray-500 mt-1">
                        Gunakan class FontAwesome. Contoh: fas fa-star, fas fa-clock, fas fa-user-tie
                    </p>
                    <div id="icon-preview-container" class="mt-2"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="order_position" class="block text-sm font-medium text-gray-700 mb-2">Order Position</label>
                        <input type="number" id="order_position" name="order_position" min="1"
                               value="<?= $content['order_position'] ?? 1 ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="is_active" name="is_active" 
                                   <?= ($content['is_active'] ?? 1) ? 'checked' : '' ?>
                                   class="h-4 w-4 text-accent focus:ring-accent border-gray-300 rounded">
                        </div>
                        <div class="ml-3">
                            <label for="is_active" class="text-sm font-medium text-gray-700">
                                Aktif
                            </label>
                            <p class="text-sm text-gray-500">Konten akan ditampilkan di halaman utama</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="/admin/home-content" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-accent hover:bg-yellow-600 text-white px-6 py-2 rounded-lg flex items-center transition duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Icon preview
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value;
    const container = document.getElementById('icon-preview-container');
    
    // Clear previous preview
    container.innerHTML = '';
    
    if (iconClass.trim()) {
        const previewDiv = document.createElement('div');
        previewDiv.className = 'flex items-center p-3 bg-gray-50 rounded-lg border';
        previewDiv.innerHTML = `
            <i class="${iconClass} text-2xl mr-3 text-accent"></i>
            <div>
                <div class="font-medium text-gray-900">Preview</div>
                <div class="text-sm text-gray-500">${iconClass}</div>
            </div>
        `;
        container.appendChild(previewDiv);
    }
});

// Trigger initial preview
document.getElementById('icon').dispatchEvent(new Event('input'));
</script>

<?= $this->endSection() ?>