<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aset - Sistem Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">Sistem Aset</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/dashboard">Dashboard</a>
                <a class="nav-link" href="/logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Daftar Aset</h1>
        <a href="/assets/create" class="btn btn-primary mb-3">Tambah Aset</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Spesifikasi</th>
                    <th>Jenis Barang</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assets as $asset): ?>
                    <tr>
                        <td><?= $asset['id'] ?></td>
                        <td><?= $asset['nama_barang'] ?></td>
                        <td><?= $asset['spesifikasi'] ?></td>
                        <td><?= $asset['jenis_barang'] ?></td>
                        <td>
                            <?php if ($asset['qr_code']): ?>
                                <img src="/uploads/<?= $asset['qr_code'] ?>" alt="QR Code" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/assets/<?= $asset['id'] ?>" class="btn btn-info btn-sm">Lihat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>