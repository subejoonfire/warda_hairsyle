<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-md">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Admin Management</h2>
                <p class="text-sm text-gray-600 mt-1">Manage admin users and their permissions</p>
            </div>
            <a href="/admin/admins/create" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Admin
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="searchInput" placeholder="Search admins..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select id="roleFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Roles</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="moderator">Moderator</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="clearFilters" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Admin
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Login
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="adminsTableBody">
                <?php if (empty($admins)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No admins found.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($admins as $admin): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-accent flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?= esc($admin['full_name']) ?></div>
                                <div class="text-sm text-gray-500">@<?= esc($admin['username']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?= esc($admin['email']) ?></div>
                        <?php if (!empty($admin['phone'])): ?>
                        <div class="text-sm text-gray-500"><?= esc($admin['phone']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $roleColors = [
                            'super_admin' => 'bg-red-100 text-red-800',
                            'admin' => 'bg-blue-100 text-blue-800',
                            'moderator' => 'bg-green-100 text-green-800'
                        ];
                        $roleColor = $roleColors[$admin['role']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $roleColor ?>">
                            <?= ucfirst(str_replace('_', ' ', $admin['role'])) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button 
                            onclick="toggleAdminStatus(<?= $admin['id'] ?>, <?= $admin['is_active'] ? 'true' : 'false' ?>)"
                            class="toggle-status-btn inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $admin['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> cursor-pointer hover:opacity-75 transition duration-200"
                            data-admin-id="<?= $admin['id'] ?>"
                            data-current-status="<?= $admin['is_active'] ?>"
                        >
                            <?= $admin['is_active'] ? 'Active' : 'Inactive' ?>
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?= $admin['last_login'] ? date('d M Y H:i', strtotime($admin['last_login'])) : 'Never' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="/admin/admins/view/<?= $admin['id'] ?>" class="text-blue-600 hover:text-blue-900" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/admins/edit/<?= $admin['id'] ?>" class="text-green-600 hover:text-green-900" title="Edit Admin">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($admin['id'] != session()->get('user_id')): ?>
                            <button onclick="deleteAdmin(<?= $admin['id'] ?>)" class="text-red-600 hover:text-red-900" title="Delete Admin">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalAdmins"><?= count($admins) ?></span> admins
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

// Filter functionality
document.getElementById('searchInput').addEventListener('input', filterAdmins);
document.getElementById('roleFilter').addEventListener('change', filterAdmins);
document.getElementById('statusFilter').addEventListener('change', filterAdmins);
document.getElementById('clearFilters').addEventListener('click', clearFilters);

function filterAdmins() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const role = document.getElementById('roleFilter').value;
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#adminsTableBody tr');

    rows.forEach(row => {
        if (row.cells.length === 1) return; // Skip "No admins found" row
        
        const name = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const roleCell = row.cells[2].textContent.toLowerCase();
        const statusCell = row.cells[3].textContent.toLowerCase();
        
        const matchesSearch = name.includes(search) || email.includes(search);
        const matchesRole = !role || roleCell.includes(role.replace('_', ' '));
        const matchesStatus = !status || (status === '1' && statusCell.includes('active')) || (status === '0' && statusCell.includes('inactive'));
        
        row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
    });
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('statusFilter').value = '';
    filterAdmins();
}

// Toggle admin status
function toggleAdminStatus(adminId, currentStatus) {
    fetch(`/admin/admins/toggle-status/${adminId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.querySelector(`[data-admin-id="${adminId}"]`);
            const newStatus = !currentStatus;
            
            button.textContent = newStatus ? 'Active' : 'Inactive';
            button.className = `toggle-status-btn inline-flex px-2 py-1 text-xs font-semibold rounded-full ${newStatus ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} cursor-pointer hover:opacity-75 transition duration-200`;
            button.setAttribute('data-current-status', newStatus);
            
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating admin status.', 'error');
    });
}

// Delete admin
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
                // Remove the row from the table
                const row = document.querySelector(`tr[data-admin-id="${currentDeleteId}"]`);
                if (row) {
                    row.remove();
                }
                showNotification(data.message, 'success');
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