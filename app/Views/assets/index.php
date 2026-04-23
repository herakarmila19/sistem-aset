<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 mb-1">Data Barang</h2>
        <p class="text-muted mb-0">Kelola inventaris dan QR code setiap barang.</p>
    </div>
    <a href="<?= site_url('barang/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a>
</div>

<div class="table-responsive bg-white rounded-3 p-2 border">
    <table class="table table-hover align-middle mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>QR</th>
            <th class="text-nowrap">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($assets)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data barang.</td></tr>
        <?php endif; ?>
        <?php foreach ($assets as $asset): ?>
            <tr>
                <td><?= esc($asset['id']) ?></td>
                <td>
                    <strong><?= esc($asset['nama_barang']) ?></strong><br>
                    <small class="text-muted"><?= esc($asset['merk_barang'] ?: '-') ?></small>
                </td>
                <td><?= esc($asset['keterangan'] ?: '-') ?></td>
                <td>
                    <span class="badge <?= $asset['status'] === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' ?>">
                        <?= esc(ucfirst($asset['status'])) ?>
                    </span>
                </td>
                <td>
                    <?php if (!empty($asset['qr_code'])): ?>
                        <img src="<?= base_url('uploads/qrcode/' . $asset['qr_code']) ?>" alt="QR" width="56" height="56">
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td class="text-nowrap">
                    <a href="<?= site_url('barang/' . $asset['id']) ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                    <?php if (!empty($asset['qr_code'])): ?>
                        <a href="<?= base_url('uploads/qrcode/' . $asset['qr_code']) ?>" download class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
                    <?php endif; ?>
                    <a href="<?= site_url('barang/' . $asset['id'] . '/edit') ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                    <a href="<?= site_url('barang/' . $asset['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang ini?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
