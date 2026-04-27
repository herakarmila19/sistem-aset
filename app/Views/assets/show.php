<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<?php $successMessage = session()->getFlashdata('success'); ?>
<?php $errorMessage = session()->getFlashdata('error'); ?>
<div class="container py-4">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="mb-3">Informasi Barang</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-1">Nama Barang</label>
                            <input type="text" class="form-control" value="<?= esc($asset['nama_barang']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-1">Merk Barang</label>
                            <input type="text" class="form-control" value="<?= esc($asset['merk_barang'] ?: '-') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-1">Keterangan</label>
                            <input type="text" class="form-control" value="<?= esc($asset['keterangan'] ?: '-') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-1">Status</label>
                            <div>
                                <span class="badge fs-6 <?= $asset['status'] === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' ?>">
                                    <?= esc(ucfirst($asset['status'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body p-4">
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success mb-0"><?= esc($successMessage) ?></div>
                    <?php endif; ?>
                    <?php if ($errorMessage): ?>
                        <div class="alert alert-danger"><?= esc($errorMessage) ?></div>
                    <?php endif; ?>

                    <?php if ($asset['status'] === 'tersedia'): ?>
                        <h5 class="mb-3">Form Peminjaman Barang</h5>
                        <form method="post" action="<?= site_url('barang/' . $asset['id'] . '/pinjam') ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Nama Peminjam</label>
                                <input type="text" name="nama_peminjam" class="form-control" value="<?= esc(old('nama_peminjam')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keperluan</label>
                                <textarea name="keperluan" class="form-control" rows="3" required><?= esc(old('keperluan')) ?></textarea>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Submit</button>
                        </form>
                    <?php else: ?>
                        <h5 class="mb-3">Form Pengembalian Barang</h5>
                        <?php if (isset($validation) && $validation->hasError('tanggal_kembali')): ?>
                            <div class="alert alert-danger"><?= $validation->getError('tanggal_kembali') ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?= site_url('barang/' . $asset['id'] . '/kembalikan') ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Timestamp Pengembalian</label>
                                <input
                                    type="datetime-local"
                                    name="tanggal_kembali"
                                    class="form-control"
                                    value="<?= esc(old('tanggal_kembali', date('Y-m-d\TH:i'))) ?>"
                                    required
                                >
                                <small class="text-muted">Isi tanggal, bulan, tahun, dan jam pengembalian.</small>
                            </div>
                            <button class="btn btn-success w-100" type="submit">Kembalikan</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($successMessage): ?>
<script>
    alert('<?= esc($successMessage) ?>');
    window.location.href = '<?= site_url('barang/' . $asset['id']) ?>';
</script>
<?php endif; ?>
</body>
</html>
