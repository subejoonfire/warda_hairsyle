<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Hairstyles</h1>
            <p class="text-gray-600">Kelola daftar hairstyle dan kategori</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?= base_url('admin/hairstyles/categories') ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 flex items-center">
                <i class="fas fa-tags mr-2"></i>
                Kelola Kategori
            </a>
            <a href="<?= base_url('admin/hairstyles/create') ?>" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Hairstyle
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-64">
                <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter Kategori</label>
                <select id="category_filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex-1 min-w-64">
                <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                <select id="status_filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" id="search" placeholder="Cari hairstyle..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
            </div>
        </div>
    </div>

    <!-- Hairstyles Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Hairstyles</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="hairstylesTableBody">
                    <?php $no = 1; ?>
                    <?php foreach ($hairstyles as $hairstyle) : ?>
                        <tr class="hairstyle-row hover:bg-gray-50" 
                            data-category="<?= $hairstyle['category_id'] ?>" 
                            data-status="<?= $hairstyle['is_active'] ?>"
                            data-name="<?= strtolower($hairstyle['name']) ?>"
                            data-description="<?= strtolower($hairstyle['description']) ?>">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $no++ ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($hairstyle['image_url'])) : ?>
                                    <img src="<?= esc($hairstyle['image_url']) ?>" alt="<?= esc($hairstyle['name']) ?>" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                <?php else : ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?= esc($hairstyle['name']) ?></div>
                                    <div class="text-sm text-gray-500"><?= esc($hairstyle['description']) ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php 
                                $categoryName = 'Tidak ada kategori';
                                foreach ($categories as $category) {
                                    if ($category['id'] == $hairstyle['category_id']) {
                                        $categoryName = $category['name'];
                                        break;
                                    }
                                }
                                ?>
                                <?= esc($categoryName) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $hairstyle['duration_minutes'] ?? 60 ?> menit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <button type="button" class="toggle-status-btn relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 
                                        <?= $hairstyle['is_active'] ? 'bg-accent' : 'bg-gray-200' ?>" 
                                        data-id="<?= $hairstyle['id'] ?>" 
                                        data-active="<?= $hairstyle['is_active'] ?>">
                                        <span class="sr-only">Toggle status</span>
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out 
                                            <?= $hairstyle['is_active'] ? 'translate-x-5' : 'translate-x-0' ?>"></span>
                                    </button>
                                    <span class="ml-3 text-sm text-gray-900">
                                        <?= $hairstyle['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $hairstyle['sort_order'] ?? 0 ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?= base_url('admin/hairstyles/view/' . $hairstyle['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/hairstyles/edit/' . $hairstyle['id']) ?>" 
                                       class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="delete-btn text-red-600 hover:text-red-900" 
                                            data-id="<?= $hairstyle['id'] ?>" 
                                            data-name="<?= esc($hairstyle['name']) ?>" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus hairstyle "<span id="deleteName" class="font-medium"></span>"?
                    </p>
                    <p class="text-xs text-red-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button type="button" class="close-delete-modal bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
                <a href="#" id="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Filter functionality
    function filterHairstyles() {
        const categoryFilter = $('#category_filter').val();
        const statusFilter = $('#status_filter').val();
        const searchTerm = $('#search').val().toLowerCase();

        $('.hairstyle-row').each(function() {
            const row = $(this);
            const category = row.data('category');
            const status = row.data('status');
            const name = row.data('name');
            const description = row.data('description');

            let show = true;

            // Category filter
            if (categoryFilter && category != categoryFilter) {
                show = false;
            }

            // Status filter
            if (statusFilter !== '' && status != statusFilter) {
                show = false;
            }

            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !description.includes(searchTerm)) {
                show = false;
            }

            row.toggle(show);
        });
    }

    $('#category_filter, #status_filter, #search').on('change keyup', filterHairstyles);

    // Toggle status
    $('.toggle-status-btn').click(function() {
        const id = $(this).data('id');
        const isActive = $(this).data('active');
        const button = $(this);
        const statusText = button.closest('td').find('span:last');
        
        $.ajax({
            url: '<?= base_url('admin/hairstyles/toggle-status/') ?>' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update button state
                    button.toggleClass('bg-accent bg-gray-200');
                    button.find('span').toggleClass('translate-x-5 translate-x-0');
                    button.data('active', !isActive);
                    
                    // Update status text
                    statusText.text(!isActive ? 'Aktif' : 'Nonaktif');
                    
                    // Update data attribute for filtering
                    button.closest('tr').attr('data-status', !isActive ? '1' : '0');
                    
                    showNotification('Status berhasil diubah', 'success');
                } else {
                    showNotification('Gagal mengubah status: ' + response.message, 'error');
                }
            },
            error: function() {
                showNotification('Terjadi kesalahan saat mengubah status', 'error');
            }
        });
    });

    // Delete button
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#deleteName').text(name);
        $('#confirmDelete').attr('href', '<?= base_url('admin/hairstyles/delete/') ?>' + id);
        $('#deleteModal').removeClass('hidden');
    });

    // Close delete modal
    $('.close-delete-modal').click(function() {
        $('#deleteModal').addClass('hidden');
    });

    // Close modal when clicking outside
    $('#deleteModal').click(function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
});
</script>
<?= $this->endSection() ?>