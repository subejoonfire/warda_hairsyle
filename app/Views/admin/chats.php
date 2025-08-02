<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Chat</h1>
            <p class="text-gray-600">Lihat dan balas pesan dari customer</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Customer</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <?php if (empty($customers)): ?>
                            <div class="p-4 text-center text-gray-500">
                                <i class="fas fa-comments text-2xl mb-2"></i>
                                <p>Tidak ada customer</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($customers as $customer): ?>
                                <div class="p-4 border-b hover:bg-gray-50 cursor-pointer <?= ($selected_customer && $selected_customer['id'] == $customer['id']) ? 'bg-blue-50 border-l-4 border-l-primary' : '' ?>"
                                     onclick="selectCustomer(<?= $customer['id'] ?>)">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <?php if (!empty($customer['profile_image'])): ?>
                                                <img class="h-10 w-10 rounded-full" src="<?= $customer['profile_image'] ?>" alt="<?= $customer['name'] ?>">
                                            <?php else: ?>
                                                <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center">
                                                    <span class="text-white font-medium"><?= strtoupper(substr($customer['name'], 0, 1)) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="text-sm font-medium text-gray-900"><?= $customer['name'] ?></div>
                                            <div class="text-sm text-gray-500"><?= $customer['whatsapp'] ?></div>
                                        </div>
                                        <?php if ($customer['unread_count'] > 0): ?>
                                            <div class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
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
                <div class="bg-white rounded-lg shadow-md h-96 flex flex-col">
                    <?php if ($selected_customer): ?>
                        <!-- Chat Header -->
                        <div class="p-4 border-b bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php if (!empty($selected_customer['profile_image'])): ?>
                                            <img class="h-10 w-10 rounded-full" src="<?= $selected_customer['profile_image'] ?>" alt="<?= $selected_customer['name'] ?>">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center">
                                                <span class="text-white font-medium"><?= strtoupper(substr($selected_customer['name'], 0, 1)) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900"><?= $selected_customer['name'] ?></div>
                                        <div class="text-sm text-gray-500"><?= $selected_customer['whatsapp'] ?></div>
                                    </div>
                                </div>
                                <a href="https://wa.me/<?= $selected_customer['whatsapp'] ?>" target="_blank" 
                                   class="text-primary hover:text-blue-700">
                                    <i class="fab fa-whatsapp text-xl"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-4">
                            <?php if (empty($messages)): ?>
                                <div class="text-center text-gray-500 py-8">
                                    <i class="fas fa-comments text-2xl mb-2"></i>
                                    <p>Belum ada pesan</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($messages as $message): ?>
                                    <div class="flex <?= $message['sender_type'] === 'admin' ? 'justify-end' : 'justify-start' ?>">
                                        <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg <?= $message['sender_type'] === 'admin' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-900' ?>">
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
                        <div class="p-4 border-t">
                            <form id="chatForm" class="flex space-x-2">
                                <input type="hidden" name="customer_id" value="<?= $selected_customer['id'] ?>">
                                <input type="text" name="message" id="messageInput" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="Ketik pesan..." required>
                                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- No Customer Selected -->
                        <div class="flex-1 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-comments text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Pilih customer untuk memulai chat</p>
                                <p class="text-sm">Klik pada nama customer di daftar sebelah kiri</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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
    
    fetch('/admin/chats/send', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            // Reload the page to show new message
            window.location.reload();
        } else {
            alert('Gagal mengirim pesan: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim pesan');
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