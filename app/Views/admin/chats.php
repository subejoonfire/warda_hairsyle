<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Chat Customer</h1>
            <p class="text-gray-600 text-sm sm:text-base">Lihat dan balas pesan dari customer</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Customer List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-users mr-2"></i>Daftar Customer
                        </h3>
                    </div>
                    <div class="max-h-64 sm:max-h-96 overflow-y-auto">
                        <?php if (empty($customers)): ?>
                            <div class="p-4 text-center text-gray-500">
                                <i class="fas fa-comments text-2xl mb-2"></i>
                                <p class="text-sm">Tidak ada customer</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($customers as $customer): ?>
                                <div class="p-3 sm:p-4 border-b hover:bg-gray-50 cursor-pointer transition duration-200 <?= ($selected_customer && $selected_customer['id'] == $customer['id']) ? 'bg-blue-50 border-l-4 border-l-primary' : '' ?>"
                                     onclick="selectCustomer(<?= $customer['id'] ?>)">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                            <?php if (!empty($customer['profile_image'])): ?>
                                                <img class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover" src="<?= $customer['profile_image'] ?>" alt="<?= $customer['name'] ?>">
                                            <?php else: ?>
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-primary flex items-center justify-center">
                                                    <span class="text-white font-medium text-sm sm:text-base"><?= strtoupper(substr($customer['name'], 0, 1)) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 truncate"><?= $customer['name'] ?></div>
                                            <div class="text-xs sm:text-sm text-gray-500 truncate"><?= $customer['whatsapp'] ?></div>
                                        </div>
                                        <?php if ($customer['unread_count'] > 0): ?>
                                            <div class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center flex-shrink-0">
                                                <?= $customer['unread_count'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md h-64 sm:h-96 flex flex-col">
                    <?php if ($selected_customer): ?>
                        <!-- Chat Header -->
                        <div class="p-3 sm:p-4 border-b bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                        <?php if (!empty($selected_customer['profile_image'])): ?>
                                            <img class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover" src="<?= $selected_customer['profile_image'] ?>" alt="<?= $selected_customer['name'] ?>">
                                        <?php else: ?>
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-primary flex items-center justify-center">
                                                <span class="text-white font-medium text-sm sm:text-base"><?= strtoupper(substr($selected_customer['name'], 0, 1)) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-3 min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 truncate"><?= $selected_customer['name'] ?></div>
                                        <div class="text-xs sm:text-sm text-gray-500 truncate"><?= $selected_customer['whatsapp'] ?></div>
                                    </div>
                                </div>
                                <a href="https://wa.me/<?= $selected_customer['whatsapp'] ?>" target="_blank" 
                                   class="text-primary hover:text-blue-700 p-2 transition duration-200 flex-shrink-0">
                                    <i class="fab fa-whatsapp text-lg sm:text-xl"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div id="chatMessages" class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-3 sm:space-y-4">
                            <?php if (empty($messages)): ?>
                                <div class="text-center text-gray-500 py-8">
                                    <i class="fas fa-comments text-2xl mb-2"></i>
                                    <p class="text-sm">Belum ada pesan</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($messages as $message): ?>
                                    <div class="flex <?= $message['sender_type'] === 'admin' ? 'justify-end' : 'justify-start' ?>">
                                        <div class="max-w-xs sm:max-w-sm lg:max-w-md px-3 sm:px-4 py-2 rounded-lg <?= $message['sender_type'] === 'admin' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-900' ?>">
                                            <div class="text-sm"><?= $message['message'] ?></div>
                                            <div class="text-xs <?= $message['sender_type'] === 'admin' ? 'text-blue-100' : 'text-gray-500' ?> mt-1">
                                                <?= date('H:i', strtotime($message['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Chat Input -->
                        <div class="p-3 sm:p-4 border-t">
                            <form id="chatForm" class="flex space-x-2">
                                <input type="hidden" name="user_id" value="<?= $selected_customer['id'] ?>">
                                <input type="text" name="message" id="messageInput" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                                       placeholder="Ketik pesan..." required>
                                <button type="submit" class="bg-primary text-white px-3 sm:px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 flex-shrink-0">
                                    <i class="fas fa-paper-plane text-sm sm:text-base"></i>
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- No Customer Selected -->
                        <div class="flex-1 flex items-center justify-center p-4">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-comments text-3xl sm:text-4xl mb-4"></i>
                                <p class="text-base sm:text-lg font-medium">Pilih customer untuk memulai chat</p>
                                <p class="text-xs sm:text-sm mt-2">Klik pada nama customer di daftar sebelah kiri</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<script>
function selectCustomer(customerId) {
    window.location.href = `/admin/chats?customer=${customerId}`;
}

// Auto-scroll to bottom of chat messages
function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Handle chat form submission
document.getElementById('chatForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageInput = document.getElementById('messageInput');
    const submitButton = this.querySelector('button[type="submit"]');
    
    // Disable submit button
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    fetch('/admin/send-admin-message', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            messageInput.value = '';
            showNotification('Pesan berhasil dikirim!', 'success');
            // Reload the page to show new message
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Gagal mengirim pesan: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengirim pesan: ' + error.message, 'error');
    })
    .finally(() => {
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-paper-plane text-sm sm:text-base"></i>';
    });
});

// Auto-scroll on page load
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
});

// Auto-refresh chat every 10 seconds
setInterval(function() {
    if (window.location.search.includes('customer=')) {
        window.location.reload();
    }
}, 10000);
</script>

<?= $this->endSection() ?>