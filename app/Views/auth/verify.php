<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-accent">
                <i class="fab fa-whatsapp text-white text-2xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Verifikasi WhatsApp
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Masukkan kode verifikasi yang telah dikirim ke WhatsApp Anda
            </p>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Informasi Akun
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p><strong>Nama:</strong> <?= $user['name'] ?></p>
                        <p><strong>WhatsApp:</strong> <?= $user['whatsapp'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <form class="mt-8 space-y-6" action="/auth/verify/<?= $user['id'] ?>" method="POST">
            <div>
                <label for="verification_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Verifikasi
                </label>
                <input id="verification_code" name="verification_code" type="text" required 
                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent focus:border-accent focus:z-10 sm:text-sm text-center text-2xl tracking-widest" 
                       placeholder="000000"
                       maxlength="6"
                       pattern="[0-9]{6}">
                <p class="mt-2 text-sm text-gray-500 text-center">
                    Masukkan 6 digit kode yang diterima
                </p>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-accent hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-check text-yellow-500 group-hover:text-yellow-400"></i>
                    </span>
                    Verifikasi
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600 mb-4">
                    Tidak menerima kode?
                </p>
                <button type="button" id="resendBtn" 
                        class="text-accent hover:text-yellow-600 font-medium text-sm">
                    Kirim ulang kode
                </button>
            </div>
        </form>

        <div class="text-center">
            <a href="/auth/login" class="text-sm text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali ke login
            </a>
        </div>
    </div>
</div>

<script>
document.getElementById('resendBtn').addEventListener('click', function() {
    const button = this;
    const originalText = button.textContent;
    
    button.disabled = true;
    button.textContent = 'Mengirim...';
    
    fetch('/auth/resend-verification/<?= $user['id'] ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Kode verifikasi telah dikirim ulang ke WhatsApp Anda');
        } else {
            alert('Gagal mengirim kode verifikasi: ' + data.message);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan: ' + error.message);
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = originalText;
    });
});

// Auto-focus on input
document.getElementById('verification_code').focus();

// Auto-submit when 6 digits are entered
document.getElementById('verification_code').addEventListener('input', function() {
    if (this.value.length === 6) {
        this.form.submit();
    }
});
</script>

<?= $this->endSection() ?>