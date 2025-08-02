<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Wardati Hairstyle' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1f2937',
                        secondary: '#374151',
                        accent: '#f59e0b',
                    }
                }
            }
        }
    </script>
    <style>
        .notification {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        .notification.show {
            transform: translateX(0);
        }
        .notification.hide {
            transform: translateX(100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Navigation -->
    <nav class="bg-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <i class="fas fa-cut text-accent text-2xl mr-2"></i>
                        <span class="text-white font-bold text-xl">Wardati Hairstyle</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Beranda</a>
                    <a href="/hairstyles" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Hairstyles</a>
                    
                    <?php if (session()->get('user_id')): ?>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                            <a href="/admin/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Dashboard</a>
                            <a href="/admin/chats" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                Chat
                                <?php if (isset($admin_unread_chats) && $admin_unread_chats > 0): ?>
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1"><?= $admin_unread_chats ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="/admin/quick-messages" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Quick Messages</a>
                        <?php else: ?>
                            <a href="/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Dashboard</a>
                            <a href="/booking" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Booking</a>
                            <a href="/chat" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                Chat
                                <?php if (isset($unread_chats) && $unread_chats > 0): ?>
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1"><?= $unread_chats ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="relative">
                            <button id="profileDropdown" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center transition duration-200">
                                <i class="fas fa-user mr-2"></i>
                                <?= session()->get('user_name') ?>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">
                                    <i class="fas fa-user-edit mr-2"></i>Profile
                                </a>
                                <a href="/auth/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/auth/login" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">Login</a>
                        <a href="/auth/register" class="bg-accent text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-yellow-600 transition duration-200">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" class="text-gray-300 hover:text-white p-2 transition duration-200">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="hidden md:hidden bg-primary border-t border-gray-600">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="/hairstyles" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                        <i class="fas fa-cut mr-2"></i>Hairstyles
                    </a>
                    
                    <?php if (session()->get('user_id')): ?>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                            <a href="/admin/dashboard" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="/admin/chats" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-comments mr-2"></i>Chat
                                <?php if (isset($admin_unread_chats) && $admin_unread_chats > 0): ?>
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1"><?= $admin_unread_chats ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="/admin/quick-messages" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-reply-all mr-2"></i>Quick Messages
                            </a>
                        <?php else: ?>
                            <a href="/dashboard" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="/booking" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-calendar-alt mr-2"></i>Booking
                            </a>
                            <a href="/chat" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-comments mr-2"></i>Chat
                                <?php if (isset($unread_chats) && $unread_chats > 0): ?>
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1"><?= $unread_chats ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="border-t border-gray-600 pt-4 mt-4">
                            <div class="text-gray-300 px-3 py-2 text-base font-medium">
                                <i class="fas fa-user mr-2"></i>
                                <?= session()->get('user_name') ?>
                            </div>
                            <a href="/profile" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-user-edit mr-2"></i>Profile
                            </a>
                            <a href="/auth/logout" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="border-t border-gray-600 pt-4 mt-4">
                            <a href="/auth/login" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            <a href="/auth/register" class="bg-accent text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-yellow-600 transition duration-200">
                                <i class="fas fa-user-plus mr-2"></i>Register
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative shadow-lg" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
                </div>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative shadow-lg" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                </div>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <i class="fas fa-times text-red-500 hover:text-red-700"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Wardati Hairstyle</h3>
                    <p class="text-gray-300 text-sm">Layanan cukur rambut terbaik dengan kualitas profesional dan harga terjangkau.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Layanan</h3>
                    <ul class="text-gray-300 space-y-2 text-sm">
                        <li><i class="fas fa-cut mr-2"></i>Cukur Rambut</li>
                        <li><i class="fas fa-home mr-2"></i>Home Service</li>
                        <li><i class="fas fa-comments mr-2"></i>Konsultasi Style</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                    <div class="text-gray-300 space-y-2 text-sm">
                        <p><i class="fab fa-whatsapp mr-2"></i>+62 812-3456-7890</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Jl. Contoh No. 123</p>
                        <p><i class="fas fa-clock mr-2"></i>08:00 - 20:00</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p class="text-sm">&copy; 2024 Wardati Hairstyle. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Notification system
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
            
            notification.className = `notification ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg max-w-sm w-full flex items-center justify-between`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${icon} mr-3"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-4 hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                notification.classList.add('hide');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Profile dropdown toggle
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileDropdown) {
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('profileMenu').classList.toggle('hidden');
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileMenu');
            const button = document.getElementById('profileDropdown');
            
            if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking on a link
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && !mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // Replace all confirm dialogs with custom notifications
        window.confirm = function(message) {
            return new Promise((resolve) => {
                const container = document.getElementById('notificationContainer');
                const notification = document.createElement('div');
                
                notification.className = 'bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg max-w-sm w-full';
                notification.innerHTML = `
                    <div class="flex items-center mb-3">
                        <i class="fas fa-question-circle mr-3"></i>
                        <span class="font-medium">Konfirmasi</span>
                    </div>
                    <p class="mb-4">${message}</p>
                    <div class="flex space-x-2">
                        <button onclick="this.parentElement.parentElement.remove(); window.confirmResult = true;" 
                                class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-sm transition duration-200">
                            Ya
                        </button>
                        <button onclick="this.parentElement.parentElement.remove(); window.confirmResult = false;" 
                                class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm transition duration-200">
                            Tidak
                        </button>
                    </div>
                `;
                
                container.appendChild(notification);
                
                // Show notification
                setTimeout(() => {
                    notification.classList.add('show');
                }, 100);
                
                // Wait for user response
                const checkResult = setInterval(() => {
                    if (typeof window.confirmResult !== 'undefined') {
                        clearInterval(checkResult);
                        const result = window.confirmResult;
                        delete window.confirmResult;
                        resolve(result);
                    }
                }, 100);
            });
        };
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>