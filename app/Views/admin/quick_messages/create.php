<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Quick Message</h1>
        <a href="<?= base_url('admin/quick-messages') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Quick Message</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/quick-messages/create') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keyword">Keyword <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="keyword" name="keyword" 
                                   value="<?= old('keyword') ?>" required>
                            <small class="form-text text-muted">Kata kunci yang akan memicu response otomatis</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description" 
                                   value="<?= old('description') ?>">
                            <small class="form-text text-muted">Deskripsi singkat tentang quick message ini</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="response_type">Tipe Response <span class="text-danger">*</span></label>
                            <select class="form-control" id="response_type" name="response_type" required>
                                <option value="">Pilih tipe response</option>
                                <option value="static" <?= old('response_type') === 'static' ? 'selected' : '' ?>>Static (Teks tetap)</option>
                                <option value="dynamic" <?= old('response_type') === 'dynamic' ? 'selected' : '' ?>>Dynamic (Dari database)</option>
                            </select>
                            <small class="form-text text-muted">
                                Static: Response teks tetap yang bisa diedit admin<br>
                                Dynamic: Response yang diambil dari data database (seperti daftar hairstyle, harga, dll)
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                <label class="custom-control-label" for="is_active">Aktif</label>
                            </div>
                            <small class="form-text text-muted">Quick message akan aktif setelah disimpan</small>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="static_content_group" style="display: none;">
                    <label for="response_content">Content Response <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="response_content" name="response_content" rows="10" 
                              placeholder="Masukkan content response..."><?= old('response_content') ?></textarea>
                    <small class="form-text text-muted">
                        Gunakan \n untuk baris baru. Contoh response yang baik:<br>
                        Jam Buka Wardati Hairstyle\n\nSenin - Jumat:\n09:00 - 20:00 WIB\n\nUntuk booking, ketik: booking
                    </small>
                </div>

                <div class="form-group" id="dynamic_content_info" style="display: none;">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Response Dynamic</h6>
                        <p class="mb-0">
                            Untuk response dynamic, content akan diambil secara otomatis dari database berdasarkan keyword yang dipilih.
                            Keyword yang tersedia untuk dynamic response:
                        </p>
                        <ul class="mb-0 mt-2">
                            <li><strong>list hairstyle</strong> - Menampilkan daftar hairstyle dari database</li>
                            <li><strong>harga hairstyle</strong> - Menampilkan harga hairstyle dari database</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Quick Message
                    </button>
                    <a href="<?= base_url('admin/quick-messages') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show/hide content based on response type
    $('#response_type').change(function() {
        const responseType = $(this).val();
        
        if (responseType === 'static') {
            $('#static_content_group').show();
            $('#dynamic_content_info').hide();
            $('#response_content').prop('required', true);
        } else if (responseType === 'dynamic') {
            $('#static_content_group').hide();
            $('#dynamic_content_info').show();
            $('#response_content').prop('required', false);
        } else {
            $('#static_content_group').hide();
            $('#dynamic_content_info').hide();
            $('#response_content').prop('required', false);
        }
    });

    // Trigger change event on page load
    $('#response_type').trigger('change');
});
</script>
<?= $this->endSection() ?>