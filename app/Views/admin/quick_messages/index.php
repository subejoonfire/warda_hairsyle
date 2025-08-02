<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Quick Messages</h1>
            <p class="text-gray-600">Kelola response otomatis untuk customer chat</p>
        </div>
        <a href="<?= base_url('admin/quick-messages/create') ?>" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Quick Message
        </a>
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

    <!-- Quick Messages Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Quick Messages</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keyword</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Response</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $no = 1; ?>
                    <?php foreach ($quick_messages as $message) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $no++ ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900"><?= esc($message['keyword']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?= esc($message['description']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?= $message['response_type'] === 'static' ? 'bg-blue-100 text-blue-800' : 
                                        ($message['response_type'] === 'dynamic' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') ?>">
                                    <?= ucfirst($message['response_type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $message['response_source'] ? esc($message['response_source']) : '-' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <button type="button" class="toggle-status-btn relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 
                                        <?= $message['is_active'] ? 'bg-accent' : 'bg-gray-200' ?>" 
                                        data-id="<?= $message['id'] ?>" 
                                        data-active="<?= $message['is_active'] ?>">
                                        <span class="sr-only">Toggle status</span>
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out 
                                            <?= $message['is_active'] ? 'translate-x-5' : 'translate-x-0' ?>"></span>
                                    </button>
                                    <span class="ml-3 text-sm text-gray-900">
                                        <?= $message['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $message['sort_order'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button type="button" class="preview-btn text-blue-600 hover:text-blue-900" 
                                            data-id="<?= $message['id'] ?>" 
                                            data-keyword="<?= esc($message['keyword']) ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="<?= base_url('admin/quick-messages/edit/' . $message['id']) ?>" 
                                       class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="delete-btn text-red-600 hover:text-red-900" 
                                            data-id="<?= $message['id'] ?>" 
                                            data-keyword="<?= esc($message['keyword']) ?>">
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

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="previewModalTitle">Preview Response</h3>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mt-2">
                <div id="previewContent" class="bg-gray-50 p-4 rounded-lg max-h-96 overflow-y-auto whitespace-pre-wrap text-sm"></div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" class="close-modal bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Tutup
                </button>
            </div>
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
                        Apakah Anda yakin ingin menghapus quick message "<span id="deleteKeyword" class="font-medium"></span>"?
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
    // Toggle status
    $('.toggle-status-btn').click(function() {
        const id = $(this).data('id');
        const isActive = $(this).data('active');
        const button = $(this);
        const statusText = button.closest('td').find('span:last');
        
        $.ajax({
            url: '<?= base_url('admin/quick-messages/toggle-status/') ?>' + id,
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

    // Preview button
    $('.preview-btn').click(function() {
        const id = $(this).data('id');
        const keyword = $(this).data('keyword');
        
        $('#previewModalTitle').text('Preview Response untuk: ' + keyword);
        $('#previewContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
        $('#previewModal').removeClass('hidden');
        
        $.ajax({
            url: '<?= base_url('admin/quick-messages/preview/') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#previewContent').html(response.preview);
                } else {
                    $('#previewContent').html('<div class="text-red-500">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#previewContent').html('<div class="text-red-500">Terjadi kesalahan saat memuat preview</div>');
            }
        });
    });

    // Delete button
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const keyword = $(this).data('keyword');
        
        $('#deleteKeyword').text(keyword);
        $('#confirmDelete').attr('href', '<?= base_url('admin/quick-messages/delete/') ?>' + id);
        $('#deleteModal').removeClass('hidden');
    });

    // Close modals
    $('.close-modal').click(function() {
        $('#previewModal').addClass('hidden');
    });

    $('.close-delete-modal').click(function() {
        $('#deleteModal').addClass('hidden');
    });

    // Close modal when clicking outside
    $('#previewModal, #deleteModal').click(function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
});
</script>
<?= $this->endSection() ?>