<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Konfirmasi Harga Booking #<?= $booking['id'] ?></h1>
                <a href="/admin/price-confirmation" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Booking</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Informasi Customer</h6>
                                    <p><strong>Nama:</strong> <?= $booking['customer_name'] ?></p>
                                    <p><strong>WhatsApp:</strong> <?= $booking['customer_whatsapp'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Detail Layanan</h6>
                                    <p><strong>Hairstyle:</strong> <?= $booking['hairstyle_name'] ?></p>
                                    <p><strong>Service Type:</strong> 
                                        <span class="badge badge-<?= $booking['service_type'] === 'boxbraid' ? 'warning' : 'info' ?>">
                                            <?= ucfirst($booking['service_type']) ?>
                                        </span>
                                    </p>
                                    <p><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($booking['booking_date'])) ?></p>
                                    <p><strong>Waktu:</strong> <?= $booking['booking_time'] ?></p>
                                </div>
                            </div>
                            
                            <?php if ($booking['notes']): ?>
                            <div class="mt-3">
                                <h6>Catatan Customer</h6>
                                <p class="text-muted"><?= nl2br($booking['notes']) ?></p>
                            </div>
                            <?php endif; ?>

                            <div class="mt-3">
                                <h6>Harga Estimasi Saat Ini</h6>
                                <h4 class="text-primary">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Konfirmasi Harga</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="confirmed_price">Harga Final</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" id="confirmed_price" 
                                               name="confirmed_price" value="<?= $booking['total_price'] ?>" 
                                               min="0" step="1000" required>
                                    </div>
                                    <small class="form-text text-muted">
                                        Sesuaikan harga berdasarkan kondisi rambut customer dan tingkat kesulitan
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="btn-group" role="group">
                                        <button type="submit" name="action" value="confirm" class="btn btn-success">
                                            <i class="fas fa-check"></i> Konfirmasi Harga
                                        </button>
                                        <button type="submit" name="action" value="reject" class="btn btn-danger">
                                            <i class="fas fa-times"></i> Tolak Booking
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php if ($booking['customer_photo']): ?>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Foto Rambut Customer</h6>
                        </div>
                        <div class="card-body text-center">
                            <img src="/<?= $booking['customer_photo'] ?>" 
                                 alt="Customer Hair Photo" 
                                 class="img-fluid rounded">
                            <div class="mt-3">
                                <a href="/<?= $booking['customer_photo'] ?>" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-expand"></i> Lihat Full Size
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="card shadow">
                        <div class="card-body text-center text-muted">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>Tidak ada foto yang diupload</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>