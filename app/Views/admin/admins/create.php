<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Create New Admin</h2>
                    <p class="text-sm text-gray-600 mt-1">Add a new admin user to the system</p>
                </div>
                <a href="/admin/admins" class="text-primary hover:text-primary-dark">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Admin List
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="/admin/admins/store" method="POST" class="p-6">
            <?= csrf_field() ?>
            
            <!-- Username -->
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?= old('username') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Enter username"
                    required
                >
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['username'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= old('email') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Enter email address"
                    required
                >
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['email'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Full Name -->
            <div class="mb-6">
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    value="<?= old('full_name') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Enter full name"
                    required
                >
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['full_name'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['full_name'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Phone -->
            <div class="mb-6">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="<?= old('phone') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Enter phone number (optional)"
                >
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['phone'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['phone'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select 
                    id="role" 
                    name="role" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    required
                >
                    <option value="">Select a role</option>
                    <option value="super_admin" <?= old('role') === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="moderator" <?= old('role') === 'moderator' ? 'selected' : '' ?>>Moderator</option>
                </select>
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['role'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['role'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Enter password"
                        required
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    >
                        <i id="passwordIcon" class="fas fa-eye text-gray-400"></i>
                    </button>
                </div>
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['password'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Confirm password"
                        required
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('confirm_password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    >
                        <i id="confirmPasswordIcon" class="fas fa-eye text-gray-400"></i>
                    </button>
                </div>
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['confirm_password'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['confirm_password'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Role Permissions Info -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                <h4 class="text-sm font-medium text-blue-800 mb-2">Role Permissions:</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li><strong>Super Admin:</strong> Full access to all features</li>
                    <li><strong>Admin:</strong> Can manage content, admins, and view reports</li>
                    <li><strong>Moderator:</strong> Can view reports and moderate content</li>
                </ul>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="/admin/admins" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
                    <i class="fas fa-save mr-2"></i>Create Admin
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId === 'password' ? 'passwordIcon' : 'confirmPasswordIcon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?= $this->endSection() ?>