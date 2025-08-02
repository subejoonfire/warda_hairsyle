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
</head>
<body class="bg-gray-50">
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
                    <a href="/" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
                    <a href="/hairstyles" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Hairstyles</a>
                    
                    <?php if (session()->get('user_id')): ?>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                            <a href="/admin/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Admin</a>
                        <?php else: ?>
                            <a href="/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            <a href="/booking" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Booking</a>
                            <a href="/chat" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Chat
                                <?php if (isset($unread_chats) && $unread_chats > 0): ?>
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1"><?= $unread_chats ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="relative">
                            <button id="profileDropdown" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <?= session()->get('user_name') ?>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-edit mr-2"></i>Profile
                                </a>
                                <a href="/auth/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/auth/login" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="/auth/register" class="bg-accent text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-yellow-600">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" class="text-gray-300 hover:text-white p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-primary">
                    <a href="/" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                    <a href="/hairstyles" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Hairstyles</a>
                    
                    <?php if (session()->get('user_id')): ?>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                            <a href="/admin/dashboard" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Admin</a>
                        <?php else: ?>
                            <a href="/dashboard" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                            <a href="/booking" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Booking</a>
                            <a href="/chat" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                                Chat
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
                            <a href="/profile" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                                <i class="fas fa-user-edit mr-2"></i>Profile
                            </a>
                            <a href="/auth/logout" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="border-t border-gray-600 pt-4 mt-4">
                            <a href="/auth/login" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Login</a>
                            <a href="/auth/register" class="bg-accent text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-yellow-600">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="this.parentElement.parentElement.remove()">
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" onclick="this.parentElement.parentElement.remove()">
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Wardati Hairstyle</h3>
                    <p class="text-gray-300">Layanan cukur rambut terbaik dengan kualitas profesional dan harga terjangkau.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Layanan</h3>
                    <ul class="text-gray-300 space-y-2">
                        <li>Cukur Rambut</li>
                        <li>Home Service</li>
                        <li>Konsultasi Style</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                    <div class="text-gray-300 space-y-2">
                        <p><i class="fab fa-whatsapp mr-2"></i>+62 812-3456-7890</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Jl. Contoh No. 123</p>
                        <p><i class="fas fa-clock mr-2"></i>08:00 - 20:00</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 Wardati Hairstyle. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Profile dropdown toggle
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileDropdown) {
            profileDropdown.addEventListener('click', function() {
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
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>