<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 mb-1">User Management</h2>
        <p class="text-muted mb-0">Kelola user admin (create, update, delete).</p>
    </div>
    <a href="<?= site_url('users/create') ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah User</a>
</div>

<div class="table-responsive bg-white rounded-3 p-2 border">
    <table class="table table-hover align-middle mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama User</th>
            <th>Username</th>
            <th>Dibuat</th>
            <th>Diubah</th>
            <th class="text-nowrap">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($users)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data user.</td></tr>
        <?php endif; ?>
        <?php foreach ($users as $item): ?>
            <tr>
                <td><?= esc($item['id']) ?></td>
                <td><strong><?= esc($item['nama_user'] ?? 'Administrator') ?></strong></td>
                <td><?= esc($item['username']) ?></td>
                <td><?= esc($item['created_at'] ?? '-') ?></td>
                <td><?= esc($item['updated_at'] ?? '-') ?></td>
                <td class="text-nowrap">
                    <a href="<?= site_url('users/' . $item['id'] . '/edit') ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                    <a href="<?= site_url('users/' . $item['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
