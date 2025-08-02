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

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.sidebar-collapsed {
            margin-left: 0;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Admin Layout -->
    <div class="flex h-screen bg-gray-50">
        <!-- Mobile overlay -->
        <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-primary text-white w-64 min-h-screen shadow-lg">
            <!-- Logo and Brand -->
            <div class="flex items-center justify-center h-16 bg-secondary">
                <i class="fas fa-cut text-accent text-2xl mr-3"></i>
                <span class="text-white font-bold text-xl">Wardati Admin</span>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-secondary rounded-lg transition duration-200 <?= current_url() == base_url('admin/dashboard') ? 'bg-secondary text-white' : '' ?>">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/admin/hairstyles" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-secondary rounded-lg transition duration-200 <?= current_url() == base_url('admin/hairstyles') ? 'bg-secondary text-white' : '' ?>">
                        <i class="fas fa-cut mr-3"></i>
                        <span>Hair Model</span>
                    </a>
                    <a href="/admin/bookings" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-secondary rounded-lg transition duration-200 <?= current_url() == base_url('admin/bookings') ? 'bg-secondary text-white' : '' ?>">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        <span>Bookings</span>
                    </a>
                    <a href="/admin/customers" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-secondary rounded-lg transition duration-200 <?= current_url() == base_url('admin/customers') ? 'bg-secondary text-white' : '' ?>">
                        <i class="fas fa-users mr-3"></i>
                        <span>Customers</span>
                    </a>
                    <a href="/admin/chats" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-secondary rounded-lg transition duration-200 <?= current_url() == base_url('admin/chats') ? 'bg-secondary text-white' : '' ?>">
                        <i class="fas fa-comments mr-3"></i>
                        <span>Chats</span>
                    </a>
                    <a href="/admin/quick-messages" class="flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-secondary rounded-lg transition duration-200 <?= current_url() == base_url('admin/quick-messages') ? 'bg-secondary text-white' : '' ?>">
                        <i class="fas fa-reply-all mr-3"></i>
                        <span>Quick Messages</span>
                    </a>
                </div>
            </nav>

            <!-- User Info at Bottom -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-600">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-white"><?= session()->get('user_name') ?></p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                    <a href="/auth/logout" class="text-gray-300 hover:text-white text-sm transition duration-200">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="mainContent" class="main-content flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-900"><?= $title ?? 'Admin Dashboard' ?></h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <span id="currentTime"></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('mobileOverlay');

            // Check if mobile
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('hidden');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-collapsed');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('mobileOverlay');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.classList.add('hidden');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('mobileOverlay');

            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                mainContent.classList.remove('sidebar-collapsed');
                overlay.classList.add('hidden');
            }
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