<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="assets-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 class="mb-1">Data Barang</h2>
        <p class="text-muted mb-0">Kelola semua aset kantor Anda.</p>
    </div>
    <a href="<?= site_url('barang/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang Baru
    </a>
</div>

<?php if (!empty($assets)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th>Merk</th>
                    <th>Tahun</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Kondisi</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assets as $asset): ?>
                    <?php
                    $statusClass = match ($asset['status']) {
                        'ada' => 'success',
                        'dipinjam' => 'warning',
                        'barang_belum_ditemukan' => 'danger',
                        default => 'secondary',
                    };

                    $kondisiClass = match ($asset['kondisi']) {
                        'baik' => 'success',
                        'rusak_ringan' => 'warning',
                        'rusak_berat' => 'danger',
                        default => 'secondary',
                    };
                    ?>
                    <tr>
                        <td><strong>#<?= $asset['id'] ?></strong></td>
                        <td>
                            <?php if (!empty($asset['foto'])): ?>
                                <img src="<?= base_url('uploads/' . $asset['foto']) ?>" alt="<?= esc($asset['nama_barang']) ?>" width="54" height="54" style="object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($asset['nama_barang']) ?></td>
                        <td><?= esc($asset['keterangan'] ?: '-') ?></td>
                        <td><?= esc($asset['merk_barang'] ?? '-') ?></td>
                        <td><?= esc($asset['tahun_pengadaan'] ?? '-') ?></td>
                        <td><span class="badge bg-secondary"><?= esc(ucfirst(str_replace('_', ' ', $asset['jenis_aset']))) ?></span></td>
                        <td><span class="badge bg-<?= $statusClass ?>"><?= esc(ucfirst(str_replace('_', ' ', $asset['status']))) ?></span></td>
                        <td><span class="badge bg-<?= $kondisiClass ?>"><?= esc(ucfirst(str_replace('_', ' ', $asset['kondisi']))) ?></span></td>
                        <td class="text-nowrap">
                            <a href="<?= site_url('barang/' . $asset['id']) ?>" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                            <?php if (!empty($asset['qr_code'])): ?>
                                <a href="<?= base_url('uploads/' . $asset['qr_code']) ?>" class="btn btn-sm btn-success" title="Download QR" download><i class="fas fa-download"></i></a>
                            <?php endif; ?>
                            <a href="<?= site_url('barang/' . $asset['id'] . '/edit') ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="<?= site_url('barang/' . $asset['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="text-center py-5 bg-white rounded-3 border">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <h4>Belum Ada Data Barang</h4>
        <p class="text-muted">Mulai dengan menambahkan barang pertama Anda.</p>
        <a href="<?= site_url('barang/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Barang Pertama
        </a>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
