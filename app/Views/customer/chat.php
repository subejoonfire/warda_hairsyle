<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg">
        <!-- Chat Header -->
        <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-2 md:mb-0">
                    <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">Chat dengan Admin</h1>
                    <p class="text-xs sm:text-sm md:text-base text-gray-600">Konsultasi atau tanya jawab dengan tim admin kami</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-500 rounded-full"></div>
                    <span class="text-xs sm:text-sm text-gray-600">Admin Online</span>
                </div>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="h-64 sm:h-80 md:h-96 overflow-y-auto p-3 sm:p-4 md:p-6 space-y-3 sm:space-y-4">
            <?php if (empty($chats)): ?>
                <div class="text-center py-6 sm:py-8">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-comments text-3xl sm:text-4xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600 mb-2">Belum ada pesan</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Mulai percakapan dengan admin untuk konsultasi atau tanya jawab</p>
                </div>
            <?php else: ?>
                <?php foreach ($chats as $chat): ?>
                    <div class="flex <?= $chat['sender_type'] === 'customer' ? 'justify-end' : 'justify-start' ?>">
                        <div class="max-w-[85%] sm:max-w-xs lg:max-w-md px-3 md:px-4 py-2 rounded-lg <?= $chat['sender_type'] === 'customer' ? 'bg-accent text-white' : 'bg-gray-100 text-gray-800' ?>">
                            <div class="text-xs sm:text-sm">
                                <?= nl2br(htmlspecialchars($chat['message'])) ?>
                            </div>
                            <div class="text-xs mt-1 <?= $chat['sender_type'] === 'customer' ? 'text-yellow-100' : 'text-gray-500' ?>">
                                <?= date('H:i', strtotime($chat['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Chat Input -->
        <div class="p-3 sm:p-4 md:p-6 border-t border-gray-200">
            <form id="chat-form" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <textarea id="message-input" 
                              class="w-full px-3 md:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-accent focus:border-accent resize-none text-sm"
                              rows="2"
                              placeholder="Ketik pesan Anda di sini..."
                              maxlength="500"></textarea>
                </div>
                <button type="submit" 
                        class="bg-accent text-white px-3 sm:px-4 md:px-6 py-2 rounded-lg hover:bg-yellow-600 transition duration-300 flex items-center justify-center text-sm sm:text-base">
                    <i class="fas fa-paper-plane mr-2"></i>
                    <span class="hidden sm:inline">Kirim</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Messages -->
    <div class="mt-4 sm:mt-6 bg-white rounded-lg shadow-lg p-3 sm:p-4 md:p-6">
        <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Pesan Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-3">
            <button class="quick-message bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm transition duration-300">
                "Saya ingin konsultasi tentang hairstyle yang cocok"
            </button>
            <button class="quick-message bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm transition duration-300">
                "Berapa lama waktu yang dibutuhkan untuk cukur rambut?"
            </button>
            <button class="quick-message bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm transition duration-300">
                "Apakah tersedia layanan home service?"
            </button>
            <button class="quick-message bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm transition duration-300">
                "Saya ingin mengubah jadwal booking"
            </button>
        </div>
    </div>
</div>

<script>
const chatMessages = document.getElementById('chat-messages');
const chatForm = document.getElementById('chat-form');
const messageInput = document.getElementById('message-input');

// Auto-scroll to bottom
function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Send message
chatForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const message = messageInput.value.trim();
    if (!message) return;
    
    // Add message to chat immediately
    addMessage(message, 'customer');
    messageInput.value = '';
    
    // Send to server
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'message=' + encodeURIComponent(message)
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showNotification('Gagal mengirim pesan: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengirim pesan', 'error');
    });
});

// Add message to chat
function addMessage(message, senderType) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex ${senderType === 'customer' ? 'justify-end' : 'justify-start'}`;
    
    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    messageDiv.innerHTML = `
        <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${senderType === 'customer' ? 'bg-accent text-white' : 'bg-gray-100 text-gray-800'}">
            <div class="text-xs sm:text-sm">${message.replace(/\n/g, '<br>')}</div>
            <div class="text-xs mt-1 ${senderType === 'customer' ? 'text-yellow-100' : 'text-gray-500'}">${time}</div>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Quick messages
document.querySelectorAll('.quick-message').forEach(button => {
    button.addEventListener('click', function() {
        const message = this.textContent.replace(/"/g, '');
        messageInput.value = message;
        messageInput.focus();
    });
});

// Auto-refresh chat every 5 seconds
setInterval(function() {
    fetch('/get-chats')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.chats.length > 0) {
            // Check if there are new messages
            const currentMessages = chatMessages.querySelectorAll('[data-message-id]');
            const newMessages = data.chats.filter(chat => 
                !Array.from(currentMessages).some(el => el.dataset.messageId == chat.id)
            );
            
            newMessages.forEach(chat => {
                addMessage(chat.message, chat.sender_type);
            });
        }
    })
    .catch(error => {
        console.error('Error refreshing chat:', error);
    });
}, 5000);

// Initial scroll to bottom
scrollToBottom();
</script>

<?= $this->endSection() ?>