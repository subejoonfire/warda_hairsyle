<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $content ? 'Edit' : 'Tambah' ?> Konten Footer</h1>
                <a href="/admin/footer-content" class="btn btn-secondary">
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
                                <option value="about">About</option>
                                <option value="services">Services</option>
                                <option value="contact">Contact</option>
                            </select>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="title">Title (Optional)</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= $content['title'] ?? '' ?>"
                                   placeholder="Kosongkan jika ini adalah item list">
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required><?= $content['content'] ?? '' ?></textarea>
                            <small class="form-text text-muted">
                                Untuk section header, isi dengan nama section. Untuk item list, isi dengan konten item.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="icon">Icon (FontAwesome Class)</label>
                            <input type="text" class="form-control" id="icon" name="icon" 
                                   value="<?= $content['icon'] ?? '' ?>"
                                   placeholder="Contoh: fas fa-cut, fab fa-whatsapp">
                            <small class="form-text text-muted">
                                Gunakan class FontAwesome. Kosongkan untuk section header.
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