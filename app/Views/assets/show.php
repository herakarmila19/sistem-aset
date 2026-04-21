<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset - Sistem Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">Sistem Aset</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/assets">Aset</a>
                <a class="nav-link" href="/logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Detail Aset</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ID: <?= $asset['id'] ?></h5>
                <p class="card-text"><strong>Nama Barang:</strong> <?= $asset['nama_barang'] ?></p>
                <p class="card-text"><strong>Spesifikasi:</strong> <?= $asset['spesifikasi'] ?></p>
                <p class="card-text"><strong>Jenis Barang:</strong> <?= $asset['jenis_barang'] ?></p>
                <?php if ($asset['qr_code']): ?>
                    <p class="card-text"><strong>QR Code:</strong></p>
                    <img src="/uploads/<?= $asset['qr_code'] ?>" alt="QR Code">
                <?php endif; ?>
            </div>
        </div>
        <a href="/assets" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>