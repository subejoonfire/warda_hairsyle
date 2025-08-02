<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Edit Admin</h2>
                    <p class="text-sm text-gray-600 mt-1">Update admin user information</p>
                </div>
                <a href="/admin/admins" class="text-primary hover:text-primary-dark">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Admin List
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="/admin/admins/update/<?= $admin['id'] ?>" method="POST" class="p-6">
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
                    value="<?= old('username', $admin['username']) ?>"
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
                    value="<?= old('email', $admin['email']) ?>"
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
                    value="<?= old('full_name', $admin['full_name']) ?>"
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
                    value="<?= old('phone', $admin['phone']) ?>"
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
                    <option value="super_admin" <?= (old('role', $admin['role']) === 'super_admin') ? 'selected' : '' ?>>Super Admin</option>
                    <option value="admin" <?= (old('role', $admin['role']) === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="moderator" <?= (old('role', $admin['role']) === 'moderator') ? 'selected' : '' ?>>Moderator</option>
                </select>
                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['role'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('errors')['role'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Password (Optional for updates) -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    New Password <span class="text-gray-500">(leave blank to keep current password)</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Enter new password (optional)"
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
                    Confirm New Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Confirm new password"
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

            <!-- Current Status -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                <div class="flex items-center">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $admin['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                        <?= $admin['is_active'] ? 'Active' : 'Inactive' ?>
                    </span>
                    <span class="ml-2 text-sm text-gray-500">
                        (Status can be changed from the admin list)
                    </span>
                </div>
            </div>

            <!-- Last Login Info -->
            <?php if ($admin['last_login']): ?>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Login</label>
                <p class="text-sm text-gray-600">
                    <?= date('d M Y H:i', strtotime($admin['last_login'])) ?>
                </p>
            </div>
            <?php endif; ?>

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
                    <i class="fas fa-save mr-2"></i>Update Admin
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

// Password confirmation validation (only if password is being changed)
document.getElementById('password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (this.value && confirmPassword.value) {
        if (this.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    } else {
        confirmPassword.setCustomValidity('');
    }
});

document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    if (password && this.value) {
        if (password !== this.value) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?= $this->endSection() ?>