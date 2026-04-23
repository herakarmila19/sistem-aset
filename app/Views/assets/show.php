<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="mb-3"><?= esc($asset['nama_barang']) ?></h3>
                    <p class="text-muted mb-2"><?= esc($asset['keterangan'] ?: '-') ?></p>
                    <div class="mb-2"><strong>Status:</strong>
                        <span class="badge <?= $asset['status'] === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' ?>">
                            <?= esc(ucfirst($asset['status'])) ?>
                        </span>
                    </div>
                    <div class="mb-2"><strong>Merk:</strong> <?= esc($asset['merk_barang'] ?: '-') ?></div>
                    <div class="mb-0"><strong>Tahun:</strong> <?= esc($asset['tahun_pengadaan'] ?: '-') ?></div>
                    <div class="mt-3">
                        <a href="<?= site_url('barang') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

                    <?php if ($asset['status'] === 'tersedia'): ?>
                        <h5 class="mb-3">Form Peminjaman</h5>
                        <form method="post" action="<?= site_url('barang/' . $asset['id'] . '/pinjam') ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Nama peminjam</label>
                                <input type="text" name="nama_peminjam" class="form-control" value="<?= esc(old('nama_peminjam')) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keperluan</label>
                                <textarea name="keperluan" class="form-control" rows="3" required><?= esc(old('keperluan')) ?></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit Peminjaman</button>
                        </form>
                    <?php else: ?>
                        <h5 class="mb-3">Proses Pengembalian</h5>
                        <p class="text-muted">Barang sedang dipinjam. Upload foto pengembalian untuk mengubah status kembali tersedia.</p>
                        <form method="post" action="<?= site_url('barang/' . $asset['id'] . '/kembalikan') ?>" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Foto pengembalian</label>
                                <input type="file" name="foto_pengembalian" class="form-control" accept="image/*" required>
                            </div>
                            <button class="btn btn-success" type="submit">Kembalikan</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <h5>QR Code Barang</h5>
                    <?php if (!empty($asset['qr_code'])): ?>
                        <img src="<?= base_url('uploads/qrcode/' . $asset['qr_code']) ?>" alt="QR Code" width="220" height="220" class="my-3">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('uploads/qrcode/' . $asset['qr_code']) ?>" download class="btn btn-success"><i class="fas fa-download"></i> Download QR</a>
                            <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Print QR</button>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">QR code belum tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
