<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-3 border p-4" style="max-width: 720px;">
    <h2 class="h4 mb-3">Tambah User Admin</h2>

    <form method="post" action="<?= site_url('users/store') ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Nama User</label>
            <input type="text" name="nama_user" class="form-control" value="<?= esc(old('nama_user', 'Administrator')) ?>" required>
            <?php if (isset($validation) && $validation->hasError('nama_user')): ?>
                <small class="text-danger"><?= $validation->getError('nama_user') ?></small>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= esc(old('username')) ?>" required>
            <?php if (isset($validation) && $validation->hasError('username')): ?>
                <small class="text-danger"><?= $validation->getError('username') ?></small>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            <?php if (isset($validation) && $validation->hasError('password')): ?>
                <small class="text-danger"><?= $validation->getError('password') ?></small>
            <?php endif; ?>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= site_url('users') ?>" class="btn btn-outline-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
