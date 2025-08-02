<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard - Wardati Hairstyle' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
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

    <!-- Admin Layout -->
    <div class="min-h-screen bg-gray-50">
        <!-- Top Navigation -->
        <nav class="bg-primary text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <i class="fas fa-cut text-accent text-2xl mr-3"></i>
                        <span class="text-white font-bold text-xl">Wardati Admin</span>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="/admin/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="/admin/hairstyles" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-cut mr-2"></i>Hairstyles
                            </a>
                            <a href="/admin/bookings" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-calendar-alt mr-2"></i>Bookings
                            </a>
                            <a href="/admin/customers" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-users mr-2"></i>Customers
                            </a>
                            <a href="/admin/chats" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-comments mr-2"></i>Chats
                            </a>
                            <a href="/admin/quick-messages" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-reply-all mr-2"></i>Quick Messages
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-300">
                            <i class="fas fa-clock mr-1"></i>
                            <span id="currentTime"></span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white"><?= session()->get('user_name') ?></p>
                                <p class="text-xs text-gray-400">Admin</p>
                            </div>
                        </div>
                        <a href="/auth/logout" class="text-gray-300 hover:text-white text-sm transition duration-200">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobileMenuButton" class="text-gray-300 hover:text-white">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobileMenu" class="md:hidden hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-800">
                    <a href="/admin/dashboard" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="/admin/hairstyles" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-cut mr-2"></i>Hairstyles
                    </a>
                    <a href="/admin/bookings" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-calendar-alt mr-2"></i>Bookings
                    </a>
                    <a href="/admin/customers" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-users mr-2"></i>Customers
                    </a>
                    <a href="/admin/chats" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-comments mr-2"></i>Chats
                    </a>
                    <a href="/admin/quick-messages" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-reply-all mr-2"></i>Quick Messages
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <h1 class="text-2xl font-bold text-gray-900"><?= $title ?? 'Admin Dashboard' ?></h1>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        });

        // Current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeString;
        }
        updateTime();
        setInterval(updateTime, 1000);

        // Show notification function
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            
            const bgColor = type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500';
            
            notification.className = `notification ${bgColor} text-white px-4 py-3 rounded-lg shadow-lg max-w-sm`;
            notification.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="text-sm">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => notification.classList.add('show'), 100);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                notification.classList.add('hide');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Global notification function
        window.showNotification = showNotification;
    </script>
</body>
</html>