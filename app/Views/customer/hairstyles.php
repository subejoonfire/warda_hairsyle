<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-6 sm:mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 sm:mb-4">Katalog Hair Model</h1>
        <p class="text-gray-600 text-sm sm:text-base">Pilih hair model yang sesuai dengan preferensi Anda</p>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8">
            <form method="GET" action="/hairstyles" class="space-y-3 sm:space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                    <!-- Search -->
                    <div>
                                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Hair Model</label>
                <input type="text" name="search" id="search" value="<?= $search ?? '' ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                       placeholder="Cari nama hair model...">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" id="category" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                            <option value="">Semua Kategori</option>
                            <?php 
                            $categoryNames = [
                                'classic' => 'Classic',
                                'modern' => 'Modern',
                                'fade' => 'Fade',
                                'short' => 'Short'
                            ];
                            ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category'] ?>" <?= ($selected_category ?? '') === $category['category'] ? 'selected' : '' ?>>
                                    <?= $categoryNames[$category['category']] ?? ucfirst($category['category']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 text-sm">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Clear Filters -->
            <?php if (!empty($search) || !empty($selected_category)): ?>
                <div class="mt-3 sm:mt-4">
                    <a href="/hairstyles" class="text-primary hover:text-blue-700 text-xs sm:text-sm">
                        <i class="fas fa-times mr-1"></i>Hapus Filter
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Results Count -->
        <div class="mb-4 sm:mb-6">
            <p class="text-gray-600 text-xs sm:text-sm">
                <?php if (!empty($search) || !empty($selected_category)): ?>
                    Menampilkan <?= count($hairstyles) ?> hasil
                    <?php if (!empty($search)): ?>untuk "<?= $search ?>"<?php endif; ?>
                    <?php if (!empty($selected_category)): ?>dalam kategori "<?= $categoryNames[$selected_category] ?? ucfirst($selected_category) ?>"<?php endif; ?>
                <?php else: ?>
                    Semua hair model (<?= count($hairstyles) ?>)
                <?php endif; ?>
            </p>
        </div>

        <!-- Hairstyles Grid -->
        <?php if (empty($hairstyles)): ?>
            <div class="text-center py-8 sm:py-12">
                <div class="text-gray-400 text-4xl sm:text-6xl mb-4">
                    <i class="fas fa-cut"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-600 mb-2">Tidak ada hair model ditemukan</h3>
                <p class="text-gray-500 text-sm">Coba ubah filter pencarian Anda</p>
                <a href="/hairstyles" class="inline-block mt-4 bg-primary text-white px-4 sm:px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300 text-sm sm:text-base">
                    Lihat Semua Hair Model
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <?php foreach ($hairstyles as $hairstyle): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <!-- Image -->
                        <div class="relative h-32 sm:h-48 bg-gray-200">
                            <?php if (!empty($hairstyle['image'])): ?>
                                <img src="<?= $hairstyle['image'] ?>" alt="<?= $hairstyle['name'] ?>" 
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-cut text-2xl sm:text-4xl text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-2 sm:top-3 left-2 sm:left-3">
                                <span class="bg-primary text-white px-2 py-1 rounded-full text-xs font-medium">
                                    <?= $categoryNames[$hairstyle['category']] ?? ucfirst($hairstyle['category']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3 sm:p-4 md:p-6">
                            <h3 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900 mb-2"><?= $hairstyle['name'] ?></h3>
                            <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2"><?= $hairstyle['description'] ?></p>
                            
                            <!-- Price -->
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <span class="text-lg sm:text-xl md:text-2xl font-bold text-primary">
                                    Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?>
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                <a href="/booking?hairstyle=<?= $hairstyle['id'] ?>" 
                                   class="w-full bg-accent text-white py-2 px-3 sm:px-4 rounded-md hover:bg-yellow-600 transition duration-300 text-center block text-xs sm:text-sm">
                                    <i class="fas fa-calendar-plus mr-2"></i>Booking Sekarang
                                </a>
                                
                                <?php if (!empty($hairstyle['image'])): ?>
                                    <button onclick="showImage('<?= $hairstyle['image'] ?>', '<?= $hairstyle['name'] ?>')" 
                                            class="w-full bg-gray-100 text-gray-700 py-2 px-3 sm:px-4 rounded-md hover:bg-gray-200 transition duration-300 text-xs sm:text-sm">
                                        <i class="fas fa-eye mr-2"></i>Lihat Foto
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-full overflow-hidden">
        <div class="flex items-center justify-between p-3 sm:p-4 border-b">
            <h3 id="modalTitle" class="text-base sm:text-lg font-semibold text-gray-900"></h3>
            <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600 p-1">
                <i class="fas fa-times text-lg sm:text-xl"></i>
            </button>
        </div>
        <div class="p-3 sm:p-4">
            <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>

<script>
function showImage(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
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