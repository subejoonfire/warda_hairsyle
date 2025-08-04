<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $content ? 'Edit' : 'Tambah' ?> Konten Halaman Utama</h1>
                <a href="/admin/home-content" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST">
                        <?php if (!$content): ?>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select class="form-control" id="section" name="section" required>
                                <option value="">Pilih Section</option>
                                <option value="why_choose_us">Why Choose Us</option>
                                <option value="services">Services</option>
                            </select>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= $content['title'] ?? '' ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $content['description'] ?? '' ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="icon">Icon (FontAwesome Class)</label>
                            <input type="text" class="form-control" id="icon" name="icon" 
                                   value="<?= $content['icon'] ?? '' ?>"
                                   placeholder="Contoh: fas fa-star">
                            <small class="form-text text-muted">
                                Gunakan class FontAwesome. Contoh: fas fa-star, fas fa-clock, fas fa-user-tie
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="order_position">Order Position</label>
                            <input type="number" class="form-control" id="order_position" name="order_position" 
                                   value="<?= $content['order_position'] ?? 1 ?>" min="1">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       <?= ($content['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Icon preview
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value;
    const preview = document.getElementById('icon-preview');
    
    if (preview) {
        preview.remove();
    }
    
    if (iconClass) {
        const previewDiv = document.createElement('div');
        previewDiv.id = 'icon-preview';
        previewDiv.className = 'mt-2';
        previewDiv.innerHTML = `<i class="${iconClass}"></i> Preview`;
        this.parentNode.appendChild(previewDiv);
    }
});

// Trigger initial preview
document.getElementById('icon').dispatchEvent(new Event('input'));
</script>

<?= $this->endSection() ?>