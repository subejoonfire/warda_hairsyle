<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Konfirmasi Harga Booking</h1>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Menunggu Konfirmasi Harga</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($pending_bookings)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <p>Tidak ada booking yang menunggu konfirmasi harga</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Hairstyle</th>
                                        <th>Service Type</th>
                                        <th>Tanggal</th>
                                        <th>Harga Estimasi</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_bookings as $booking): ?>
                                    <tr>
                                        <td><?= $booking['id'] ?></td>
                                        <td>
                                            <strong><?= $booking['customer_name'] ?></strong><br>
                                            <small class="text-muted"><?= $booking['customer_whatsapp'] ?></small>
                                        </td>
                                        <td><?= $booking['hairstyle_name'] ?></td>
                                        <td>
                                            <span class="badge badge-<?= $booking['service_type'] === 'boxbraid' ? 'warning' : 'info' ?>">
                                                <?= ucfirst($booking['service_type']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($booking['booking_date'])) ?><br>
                                            <small><?= $booking['booking_time'] ?></small>
                                        </td>
                                        <td>Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($booking['customer_photo']): ?>
                                                <a href="/<?= $booking['customer_photo'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-image"></i> Lihat Foto
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">No photo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="/admin/price-confirmation/<?= $booking['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-check"></i> Konfirmasi
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>