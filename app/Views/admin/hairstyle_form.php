<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <?= isset($hairstyle) ? 'Edit Hairstyle' : 'Tambah Hairstyle Baru' ?>
            </h1>
            <p class="text-gray-600 text-sm sm:text-base">
                <?= isset($hairstyle) ? 'Edit informasi hairstyle' : 'Tambah hairstyle baru ke katalog' ?>
            </p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <form method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Hairstyle <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" 
                           value="<?= old('name', $hairstyle['name'] ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                           placeholder="Contoh: Undercut Modern" required>
                    <?php if (session()->getFlashdata('errors.name')): ?>
                        <p class="text-red-500 text-xs sm:text-sm mt-1"><?= session()->getFlashdata('errors.name') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" sm:rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                              placeholder="Deskripsikan hairstyle ini..." required><?= old('description', $hairstyle['description'] ?? '') ?></textarea>
                    <?php if (session()->getFlashdata('errors.description')): ?>
                        <p class="text-red-500 text-xs sm:text-sm mt-1"><?= session()->getFlashdata('errors.description') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" id="price" 
                           value="<?= old('price', $hairstyle['price'] ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                           placeholder="50000" min="0" required>
                    <?php if (session()->getFlashdata('errors.price')): ?>
                        <p class="text-red-500 text-xs sm:text-sm mt-1"><?= session()->getFlashdata('errors.price') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm" required>
                        <option value="">Pilih Kategori</option>
                        <option value="classic" <?= (old('category', $hairstyle['category'] ?? '') === 'classic') ? 'selected' : '' ?>>Classic</option>
                        <option value="modern" <?= (old('category', $hairstyle['category'] ?? '') === 'modern') ? 'selected' : '' ?>>Modern</option>
                        <option value="fade" <?= (old('category', $hairstyle['category'] ?? '') === 'fade') ? 'selected' : '' ?>>Fade</option>
                        <option value="short" <?= (old('category', $hairstyle['category'] ?? '') === 'short') ? 'selected' : '' ?>>Short</option>
                    </select>
                    <?php if (session()->getFlashdata('errors.category')): ?>
                        <p class="text-red-500 text-xs sm:text-sm mt-1"><?= session()->getFlashdata('errors.category') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Hairstyle
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                    
                    <?php if (isset($hairstyle) && !empty($hairstyle['image'])): ?>
                        <div class="mt-3">
                            <p class="text-xs sm:text-sm text-gray-700 mb-2">Gambar saat ini:</p>
                            <img src="<?= $hairstyle['image'] ?>" alt="<?= $hairstyle['name'] ?>" 
                                 class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-lg border">
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('errors.image')): ?>
                        <p class="text-red-500 text-xs sm:text-sm mt-1"><?= session()->getFlashdata('errors.image') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" 
                               <?= (old('is_active', $hairstyle['is_active'] ?? true)) ? 'checked' : '' ?>
                               class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="ml-2 text-xs sm:text-sm text-gray-700">Aktif (tampilkan di katalog)</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-4 sm:pt-6 border-t">
                    <a href="/admin/hairstyles" 
                       class="bg-gray-300 text-gray-700 px-4 sm:px-6 py-2 rounded-md hover:bg-gray-400 transition duration-300 text-sm sm:text-base text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-primary text-white px-4 sm:px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300 text-sm sm:text-base">
                        <?= isset($hairstyle) ? 'Update Hairstyle' : 'Tambah Hairstyle' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>