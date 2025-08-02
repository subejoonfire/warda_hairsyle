<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Quick Message</h1>
            <p class="text-gray-600">Buat response otomatis baru untuk customer chat</p>
        </div>
        <a href="<?= base_url('admin/quick-messages') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?= base_url('admin/quick-messages/create') ?>" method="POST" id="quickMessageForm">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">
                            Keyword <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="keyword" name="keyword" 
                               value="<?= old('keyword') ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="Contoh: list hairstyle" required>
                        <p class="text-xs text-gray-500 mt-1">Kata kunci yang akan memicu response otomatis</p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <input type="text" id="description" name="description" 
                               value="<?= old('description') ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="Deskripsi singkat tentang quick message ini">
                        <p class="text-xs text-gray-500 mt-1">Deskripsi singkat untuk admin</p>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan
                        </label>
                        <input type="number" id="sort_order" name="sort_order" 
                               value="<?= old('sort_order', 0) ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Urutan tampilan (0 = paling atas)</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" 
                                   <?= old('is_active', true) ? 'checked' : '' ?> 
                                   class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Aktifkan quick message ini</p>
                    </div>
                </div>

                <!-- Response Configuration -->
                <div class="space-y-4">
                    <div>
                        <label for="response_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Response <span class="text-red-500">*</span>
                        </label>
                        <select id="response_type" name="response_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" required>
                            <option value="">Pilih tipe response</option>
                            <option value="static" <?= old('response_type') === 'static' ? 'selected' : '' ?>>Static (Teks tetap)</option>
                            <option value="dynamic" <?= old('response_type') === 'dynamic' ? 'selected' : '' ?>>Dynamic (Dari database)</option>
                            <option value="template" <?= old('response_type') === 'template' ? 'selected' : '' ?>>Template (Campuran)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            Static: Response teks tetap yang bisa diedit admin<br>
                            Dynamic: Response yang diambil dari data database<br>
                            Template: Response dengan template yang bisa menggunakan data dari database
                        </p>
                    </div>

                    <div id="response_source_group" style="display: none;">
                        <label for="response_source" class="block text-sm font-medium text-gray-700 mb-2">
                            Source Data
                        </label>
                        <select id="response_source" name="response_source" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                            <option value="">Pilih source data</option>
                            <?php foreach ($response_sources as $key => $value) : ?>
                                <option value="<?= $key ?>" <?= old('response_source') === $key ? 'selected' : '' ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Pilih sumber data untuk response</p>
                    </div>

                    <div id="response_template_group" style="display: none;">
                        <label for="response_template" class="block text-sm font-medium text-gray-700 mb-2">
                            Template Response
                        </label>
                        <textarea id="response_template" name="response_template" rows="8" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
                                  placeholder="Masukkan template response..."><?= old('response_template') ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Untuk template, gunakan placeholder seperti {hairstyle_list}, {price_list}, {category_list}<br>
                            Gunakan \n untuk baris baru
                        </p>
                    </div>

                    <div id="template_info" style="display: none;">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">Template Placeholders:</h4>
                            <ul class="text-xs text-blue-700 space-y-1">
                                <li><strong>{hairstyle_list}</strong> - Daftar hairstyle dengan harga</li>
                                <li><strong>{price_list}</strong> - Daftar harga hairstyle</li>
                                <li><strong>{category_list}</strong> - Daftar kategori hairstyle</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div id="preview_section" class="mt-6 p-4 bg-gray-50 rounded-lg" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Preview Response</h3>
                <div id="preview_content" class="bg-white p-4 rounded border whitespace-pre-wrap text-sm"></div>
                <button type="button" id="test_response" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Test Response
                </button>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="<?= base_url('admin/quick-messages') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Quick Message
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show/hide fields based on response type
    $('#response_type').change(function() {
        const responseType = $(this).val();
        
        // Hide all groups first
        $('#response_source_group, #response_template_group, #template_info, #preview_section').hide();
        
        if (responseType === 'static') {
            $('#response_template_group').show();
        } else if (responseType === 'dynamic') {
            $('#response_source_group').show();
        } else if (responseType === 'template') {
            $('#response_source_group, #response_template_group, #template_info').show();
        }
    });

    // Test response button
    $('#test_response').click(function() {
        const responseType = $('#response_type').val();
        const responseSource = $('#response_source').val();
        const responseTemplate = $('#response_template').val();

        if (!responseType) {
            showNotification('Pilih tipe response terlebih dahulu', 'error');
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/quick-messages/test-response') ?>',
            type: 'POST',
            data: {
                response_type: responseType,
                response_source: responseSource,
                response_template: responseTemplate
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#preview_content').html(response.preview);
                    $('#preview_section').show();
                } else {
                    showNotification('Gagal generate preview: ' + response.message, 'error');
                }
            },
            error: function() {
                showNotification('Terjadi kesalahan saat generate preview', 'error');
            }
        });
    });

    // Show preview section when template is filled
    $('#response_template').on('input', function() {
        if ($(this).val().trim()) {
            $('#preview_section').show();
        } else {
            $('#preview_section').hide();
        }
    });

    // Trigger change event on page load
    $('#response_type').trigger('change');
});
</script>
<?= $this->endSection() ?>