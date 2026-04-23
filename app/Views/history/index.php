<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<h2 class="h4 mb-3">History Peminjaman</h2>
<div class="table-responsive bg-white rounded-3 border p-2">
    <table class="table table-striped align-middle mb-0">
        <thead>
        <tr>
            <th>Nama Peminjam</th>
            <th>Keperluan</th>
            <th>Nama Barang</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Foto Pengembalian</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($history)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data history.</td></tr>
        <?php endif; ?>
        <?php foreach ($history as $item): ?>
            <tr>
                <td><?= esc($item['nama_peminjam']) ?></td>
                <td><?= esc($item['keperluan']) ?></td>
                <td><?= esc($item['nama_barang']) ?></td>
                <td><?= esc($item['tanggal_pinjam']) ?></td>
                <td><?= esc($item['tanggal_kembali'] ?? '-') ?></td>
                <td>
                    <?php if (!empty($item['foto_pengembalian'])): ?>
                        <a href="<?= base_url('uploads/pengembalian/' . $item['foto_pengembalian']) ?>" target="_blank">
                            <img src="<?= base_url('uploads/pengembalian/' . $item['foto_pengembalian']) ?>" alt="foto" width="64" height="64" style="object-fit:cover;border-radius:8px;">
                        </a>
                    <?php else: ?>-
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
