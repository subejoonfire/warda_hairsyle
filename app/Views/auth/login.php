<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 sm:space-y-8">
        <div>
            <div class="mx-auto h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center rounded-full bg-accent">
                <i class="fas fa-cut text-white text-lg sm:text-2xl"></i>
            </div>
            <h2 class="mt-4 sm:mt-6 text-center text-2xl sm:text-3xl font-extrabold text-gray-900">
                Login ke Akun Anda
            </h2>
            <p class="mt-2 text-center text-xs sm:text-sm text-gray-600">
                Atau
                <a href="/auth/register" class="font-medium text-accent hover:text-yellow-600">
                    daftar akun baru
                </a>
            </p>
        </div>
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>
        
        <form class="mt-6 sm:mt-8 space-y-4 sm:space-y-6" action="/auth/login" method="POST">
            <?= csrf_field() ?>
            <div class="space-y-3 sm:space-y-4">
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input id="whatsapp" name="whatsapp" type="text" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent focus:border-accent text-sm" 
                           placeholder="Nomor WhatsApp (contoh: 081234567890)"
                           value="<?= old('whatsapp') ?>">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent focus:border-accent text-sm" 
                           placeholder="Password">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-accent hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-yellow-500 group-hover:text-yellow-400"></i>
                    </span>
                    Login
                </button>
            </div>

            <div class="text-center">
                <p class="text-xs sm:text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="/auth/register" class="font-medium text-accent hover:text-yellow-600">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>