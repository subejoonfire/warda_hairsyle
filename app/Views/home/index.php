<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary to-secondary text-white py-20">
    <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Wardati Hairstyle
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-gray-200">
            Dapatkan tampilan rambut terbaik dengan layanan profesional kami
        </p>
        <div class="space-x-4">
            <a href="/hairstyles" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-yellow-600 transition duration-300">
                Lihat Hairstyles
            </a>
            <?php if (!session()->get('user_id')): ?>
                <a href="/auth/register" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-primary transition duration-300">
                    Daftar Sekarang
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Kami</h2>
        <p class="text-gray-600 text-lg">Berbagai layanan cukur rambut profesional</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-cut text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Cukur Rambut</h3>
            <p class="text-gray-600">Layanan cukur rambut dengan berbagai style modern dan klasik</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-home text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Home Service</h3>
            <p class="text-gray-600">Layanan cukur rambut di rumah Anda dengan kenyamanan maksimal</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-comments text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Konsultasi</h3>
            <p class="text-gray-600">Konsultasi style rambut sesuai dengan bentuk wajah Anda</p>
        </div>
    </div>
</section>

<!-- Featured Hairstyles -->
<section class="py-16 bg-gray-100">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Hairstyles Populer</h2>
        <p class="text-gray-600 text-lg">Pilihan hairstyle terbaik yang sering dipilih customer</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach (array_slice($hairstyles, 0, 6) as $hairstyle): ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <?php if ($hairstyle['image']): ?>
                    <img src="/<?= $hairstyle['image'] ?>" alt="<?= $hairstyle['name'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <i class="fas fa-cut text-4xl text-gray-400"></i>
                <?php endif; ?>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-2"><?= $hairstyle['name'] ?></h3>
                <p class="text-gray-600 mb-4"><?= $hairstyle['description'] ?></p>
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-bold text-accent">Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?></span>
                    <?php if (session()->get('user_id')): ?>
                        <a href="/booking?hairstyle=<?= $hairstyle['id'] ?>" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition duration-300">
                            Booking
                        </a>
                    <?php else: ?>
                        <a href="/auth/login" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition duration-300">
                            Login untuk Booking
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-8">
        <a href="/hairstyles" class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-yellow-600 transition duration-300">
            Lihat Semua Hairstyles
        </a>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Kategori Hairstyle</h2>
        <p class="text-gray-600 text-lg">Pilih kategori yang sesuai dengan preferensi Anda</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <?php 
        $categoryNames = [
            'classic' => 'Classic',
            'modern' => 'Modern',
            'fade' => 'Fade',
            'short' => 'Short'
        ];
        ?>
        <?php foreach ($categories as $category): ?>
        <a href="/hairstyles?category=<?= $category['category'] ?>" class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-xl transition duration-300">
            <div class="bg-primary text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-cut text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold"><?= $categoryNames[$category['category']] ?? ucfirst($category['category']) ?></h3>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-primary text-white">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold mb-4">Mengapa Memilih Wardati Hairstyle?</h2>
        <p class="text-gray-300 text-lg">Keunggulan yang membuat kami berbeda</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-star text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Kualitas Terbaik</h3>
            <p class="text-gray-300">Menggunakan alat dan teknik terbaik untuk hasil maksimal</p>
        </div>
        
        <div class="text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Tepat Waktu</h3>
            <p class="text-gray-300">Layanan cepat dan tepat waktu sesuai janji</p>
        </div>
        
        <div class="text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-tie text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Barber Profesional</h3>
            <p class="text-gray-300">Tim barber berpengalaman dan terlatih</p>
        </div>
        
        <div class="text-center">
            <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-heart text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Kepuasan Customer</h3>
            <p class="text-gray-300">Prioritas utama adalah kepuasan customer</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-accent">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Siap untuk Tampil Lebih Percaya Diri?</h2>
        <p class="text-yellow-100 text-lg mb-8">Daftar sekarang dan dapatkan layanan terbaik kami</p>
        <div class="space-x-4">
            <?php if (!session()->get('user_id')): ?>
                <a href="/auth/register" class="bg-white text-accent px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Daftar Sekarang
                </a>
                <a href="/auth/login" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-accent transition duration-300">
                    Login
                </a>
            <?php else: ?>
                <a href="/booking" class="bg-white text-accent px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Booking Sekarang
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>