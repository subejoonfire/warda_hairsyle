<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Kelola Konten Footer</h1>
                <a href="/admin/footer-content/edit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Konten
                </a>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Konten Footer</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Section</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Icon</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($footer_content as $content): ?>
                                <tr>
                                    <td><?= $content['id'] ?></td>
                                    <td>
                                        <span class="badge badge-<?= $content['section'] === 'about' ? 'primary' : ($content['section'] === 'services' ? 'info' : 'success') ?>">
                                            <?= ucfirst($content['section']) ?>
                                        </span>
                                    </td>
                                    <td><?= $content['title'] ?: '<em class="text-muted">No title</em>' ?></td>
                                    <td><?= substr($content['content'], 0, 30) ?>...</td>
                                    <td>
                                        <?php if ($content['icon']): ?>
                                            <i class="<?= $content['icon'] ?>"></i> <?= $content['icon'] ?>
                                        <?php else: ?>
                                            <span class="text-muted">No icon</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $content['order_position'] ?></td>
                                    <td>
                                        <span class="badge badge-<?= $content['is_active'] ? 'success' : 'secondary' ?>">
                                            <?= $content['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/admin/footer-content/edit/<?= $content['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/footer-content/delete/<?= $content['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus konten ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>