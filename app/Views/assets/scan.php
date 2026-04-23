<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Barang - Sistem Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f5f7fa; }
        .card-wrapper {
            max-width: 760px;
            margin: 32px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 28px;
        }
        .title { font-weight: 700; color: #1f2937; }
        .label { color: #6b7280; font-weight: 600; }
        .value { color: #111827; }
        .status-badge { font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="container py-3">
    <div class="card-wrapper">
        <h2 class="title mb-4"><i class="fas fa-box-open me-2"></i>Detail & Peminjaman Barang</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="label">Nama Barang</div>
                <div class="value"><?= esc($asset['nama_barang']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="label">Merk</div>
                <div class="value"><?= esc($asset['merk_barang'] ?: '-') ?></div>
            </div>
            <div class="col-md-6">
                <div class="label">Keterangan</div>
                <div class="value"><?= esc($asset['keterangan'] ?: '-') ?></div>
            </div>
            <div class="col-md-6">
                <div class="label">Status</div>
                <?php $isDipinjam = $asset['status'] === 'dipinjam'; ?>
                <?php $isBelumDitemukan = $asset['status'] === 'barang_belum_ditemukan'; ?>
                <div>
                    <span class="badge <?= $isDipinjam ? 'bg-warning text-dark' : ($isBelumDitemukan ? 'bg-danger' : 'bg-success') ?> status-badge">
                        <?= esc(ucwords(str_replace('_', ' ', $asset['status']))) ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if ($isDipinjam): ?>
            <div class="alert alert-warning mb-0">
                Barang ini sedang dipinjam oleh <strong><?= esc($asset['nama_peminjam'] ?: 'Pengguna lain') ?></strong>
                <?= $asset['keperluan_pinjam'] ? 'untuk ' . esc($asset['keperluan_pinjam']) : '' ?>.
            </div>
        <?php elseif ($isBelumDitemukan): ?>
            <div class="alert alert-danger mb-0">
                Barang sedang berstatus <strong>barang belum ditemukan</strong>, sehingga tidak dapat dipinjam.
            </div>
        <?php else: ?>
            <h5 class="mb-3">Form Pinjam Barang</h5>
            <form method="post" action="<?= site_url('scan/' . $asset['id'] . '/borrow') ?>">
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" name="nama_peminjam" value="<?= esc(old('nama_peminjam')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keperluan</label>
                    <textarea class="form-control" name="keperluan_pinjam" rows="3" required><?= esc(old('keperluan_pinjam')) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-paper-plane me-1"></i> Submit Peminjaman
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
