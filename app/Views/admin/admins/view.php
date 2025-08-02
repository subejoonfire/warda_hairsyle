<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Admin Details</h2>
                    <p class="text-sm text-gray-600 mt-1">View admin user information</p>
                </div>
                <div class="flex space-x-2">
                    <a href="/admin/admins" class="text-primary hover:text-primary-dark">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Admin List
                    </a>
                    <a href="/admin/admins/edit/<?= $admin['id'] ?>" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Information -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        
                        <!-- Profile Picture -->
                        <div class="flex items-center mb-4">
                            <div class="h-16 w-16 rounded-full bg-accent flex items-center justify-center">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-semibold text-gray-900"><?= esc($admin['full_name']) ?></h4>
                                <p class="text-gray-500">@<?= esc($admin['username']) ?></p>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Username</label>
                                <p class="text-sm text-gray-900 mt-1"><?= esc($admin['username']) ?></p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="text-sm text-gray-900 mt-1"><?= esc($admin['email']) ?></p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <p class="text-sm text-gray-900 mt-1"><?= esc($admin['full_name']) ?></p>
                            </div>
                            
                            <?php if (!empty($admin['phone'])): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <p class="text-sm text-gray-900 mt-1"><?= esc($admin['phone']) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                        
                        <div class="space-y-4">
                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <?php
                                $roleColors = [
                                    'super_admin' => 'bg-red-100 text-red-800',
                                    'admin' => 'bg-blue-100 text-blue-800',
                                    'moderator' => 'bg-green-100 text-green-800'
                                ];
                                $roleColor = $roleColors[$admin['role']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $roleColor ?> mt-1">
                                    <?= ucfirst(str_replace('_', ' ', $admin['role'])) ?>
                                </span>
                            </div>
                            
                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $admin['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> mt-1">
                                    <?= $admin['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </div>
                            
                            <!-- Created Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created Date</label>
                                <p class="text-sm text-gray-900 mt-1">
                                    <?= date('d M Y H:i', strtotime($admin['created_at'])) ?>
                                </p>
                            </div>
                            
                            <!-- Last Updated -->
                            <?php if ($admin['updated_at']): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <p class="text-sm text-gray-900 mt-1">
                                    <?= date('d M Y H:i', strtotime($admin['updated_at'])) ?>
                                </p>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Last Login -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Login</label>
                                <p class="text-sm text-gray-900 mt-1">
                                    <?= $admin['last_login'] ? date('d M Y H:i', strtotime($admin['last_login'])) : 'Never' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Permissions -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Role Permissions</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <?php
                    $rolePermissions = [
                        'super_admin' => [
                            'title' => 'Super Admin',
                            'description' => 'Full access to all features and administrative functions',
                            'permissions' => [
                                'Manage all admin users',
                                'Access all system features',
                                'View and manage all reports',
                                'System configuration access',
                                'Full content management'
                            ]
                        ],
                        'admin' => [
                            'title' => 'Admin',
                            'description' => 'Can manage content, admins, and view reports',
                            'permissions' => [
                                'Manage content and hairstyles',
                                'View and manage admin users',
                                'Access booking management',
                                'View customer information',
                                'Manage quick messages'
                            ]
                        ],
                        'moderator' => [
                            'title' => 'Moderator',
                            'description' => 'Can view reports and moderate content',
                            'permissions' => [
                                'View reports and analytics',
                                'Moderate customer content',
                                'View booking information',
                                'Access chat management',
                                'Limited content editing'
                            ]
                        ]
                    ];
                    
                    $currentRole = $rolePermissions[$admin['role']] ?? $rolePermissions['moderator'];
                    ?>
                    
                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-800"><?= $currentRole['title'] ?></h4>
                        <p class="text-sm text-gray-600"><?= $currentRole['description'] ?></p>
                    </div>
                    
                    <div>
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Permissions:</h5>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <?php foreach ($currentRole['permissions'] as $permission): ?>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <?= $permission ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="/admin/admins" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition duration-200">
                    Back to List
                </a>
                <a href="/admin/admins/edit/<?= $admin['id'] ?>" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Admin
                </a>
                <?php if ($admin['id'] != session()->get('user_id')): ?>
                <button onclick="deleteAdmin(<?= $admin['id'] ?>)" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                    <i class="fas fa-trash mr-2"></i>Delete Admin
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Admin</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this admin? This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Delete
                </button>
                <button id="cancelDelete" class="mt-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentDeleteId = null;

function deleteAdmin(adminId) {
    currentDeleteId = adminId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (currentDeleteId) {
        fetch(`/admin/admins/delete/${currentDeleteId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.href = '/admin/admins';
                }, 1500);
            } else {
                showNotification(data.message, 'error');
            }
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeleteId = null;
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while deleting admin.', 'error');
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeleteId = null;
        });
    }
});

document.getElementById('cancelDelete').addEventListener('click', function() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentDeleteId = null;
});

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
        currentDeleteId = null;
    }
});
</script>

<?= $this->endSection() ?>