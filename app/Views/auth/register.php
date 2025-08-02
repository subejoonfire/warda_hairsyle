<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-accent">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau
                <a href="/auth/login" class="font-medium text-accent hover:text-yellow-600">
                    login ke akun yang sudah ada
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="/auth/register" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-accent focus:border-accent focus:z-10 sm:text-sm" 
                           placeholder="Nama Lengkap"
                           value="<?= old('name') ?>">
                </div>
                <div>
                    <label for="whatsapp" class="sr-only">Nomor WhatsApp</label>
                    <input id="whatsapp" name="whatsapp" type="text" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-accent focus:border-accent focus:z-10 sm:text-sm" 
                           placeholder="Nomor WhatsApp (contoh: 081234567890)"
                           value="<?= old('whatsapp') ?>">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-accent focus:border-accent focus:z-10 sm:text-sm" 
                           placeholder="Password (minimal 6 karakter)">
                </div>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-accent hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-yellow-500 group-hover:text-yellow-400"></i>
                    </span>
                    Daftar
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="/auth/login" class="font-medium text-accent hover:text-yellow-600">
                        Login di sini
                    </a>
                </p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Verifikasi WhatsApp
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Setelah mendaftar, Anda akan menerima kode verifikasi melalui WhatsApp untuk mengaktifkan akun.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>