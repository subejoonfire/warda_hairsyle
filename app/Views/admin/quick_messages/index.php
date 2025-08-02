<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Quick Messages</h1>
        <a href="<?= base_url('admin/quick-messages/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Quick Message
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Quick Messages</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keyword</th>
                            <th>Deskripsi</th>
                            <th>Tipe Response</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($quick_messages as $message) : ?>
                            <?php 
                            $response = null;
                            foreach ($responses as $resp) {
                                if ($resp['quick_message_id'] == $message['id']) {
                                    $response = $resp;
                                    break;
                                }
                            }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= esc($message['keyword']) ?></strong>
                                </td>
                                <td><?= esc($message['description']) ?></td>
                                <td>
                                    <?php if ($response) : ?>
                                        <span class="badge badge-<?= $response['response_type'] === 'static' ? 'info' : 'warning' ?>">
                                            <?= ucfirst($response['response_type']) ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Tidak ada response</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input toggle-status" 
                                               id="status_<?= $message['id'] ?>" 
                                               data-id="<?= $message['id'] ?>"
                                               <?= $message['is_active'] ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="status_<?= $message['id'] ?>">
                                            <?= $message['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info preview-btn" 
                                                data-id="<?= $message['id'] ?>" 
                                                data-keyword="<?= esc($message['keyword']) ?>">
                                            <i class="fas fa-eye"></i> Preview
                                        </button>
                                        <a href="<?= base_url('admin/quick-messages/edit/' . $message['id']) ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                                data-id="<?= $message['id'] ?>" 
                                                data-keyword="<?= esc($message['keyword']) ?>">
                                            <i class="fas fa-trash"></i> Hapus
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
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Preview Response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="previewContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus quick message "<span id="deleteKeyword"></span>"?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').change(function() {
        const id = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: '<?= base_url('admin/quick-messages/toggle-status/') ?>' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update label
                    const label = $('label[for="status_' + id + '"]');
                    label.text(isChecked ? 'Aktif' : 'Nonaktif');
                    
                    // Show success message
                    alert('Status berhasil diubah');
                } else {
                    alert('Gagal mengubah status: ' + response.message);
                    // Revert checkbox
                    $(this).prop('checked', !isChecked);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengubah status');
                // Revert checkbox
                $(this).prop('checked', !isChecked);
            }
        });
    });

    // Preview button
    $('.preview-btn').click(function() {
        const id = $(this).data('id');
        const keyword = $(this).data('keyword');
        
        $('#previewModalLabel').text('Preview Response untuk: ' + keyword);
        $('#previewContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
        $('#previewModal').modal('show');
        
        $.ajax({
            url: '<?= base_url('admin/quick-messages/preview/') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#previewContent').html('<pre>' + response.preview + '</pre>');
                } else {
                    $('#previewContent').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#previewContent').html('<div class="alert alert-danger">Terjadi kesalahan saat memuat preview</div>');
            }
        });
    });

    // Delete button
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const keyword = $(this).data('keyword');
        
        $('#deleteKeyword').text(keyword);
        $('#confirmDelete').attr('href', '<?= base_url('admin/quick-messages/delete/') ?>' + id);
        $('#deleteModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>