<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - Sistem Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 20px;
        }
        
        .detail-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .detail-card h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 15px;
        }
        
        .detail-image {
            max-width: 300px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .detail-info {
            background: #f5f7fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 700;
            color: #667eea;
            min-width: 150px;
        }
        
        .badge-status {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }
        
        .badge-ada {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-dipinjam {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-hilang {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-kondisi {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            margin-left: 10px;
        }
        
        .badge-baik {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-rusak-ringan {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-rusak-berat {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .qr-code-section {
            background: #f5f7fa;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>"><i class="fas fa-box"></i> Sistem Aset</a>
        </div>
    </nav>
    
    <div class="container">
        <?php if ($asset): ?>
            <div class="detail-card">
                <h1><i class="fas fa-info-circle"></i> Detail Barang</h1>
                
                <div class="row">
                    <div class="col-md-6">
                        <?php if ($asset['foto']): ?>
                            <img src="<?= base_url('uploads/' . $asset['foto']) ?>" alt="<?= $asset['nama_barang'] ?>" class="detail-image">
                        <?php else: ?>
                            <div class="detail-image" style="display: flex; align-items: center; justify-content: center; background: #f0f0f0;">
                                <i class="fas fa-image" style="font-size: 80px; color: #ccc;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-info">
                            <div class="info-row">
                                <span class="info-label">ID:</span>
                                <span><?= $asset['id'] ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Nama Barang:</span>
                                <span><?= $asset['nama_barang'] ?></span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Keterangan:</span>
                                <span><?= $asset['keterangan'] ?: '-' ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Merk:</span>
                                <span><?= $asset['merk_barang'] ?? '-' ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Tahun:</span>
                                <span><?= $asset['tahun_pengadaan'] ?? '-' ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Jenis Aset:</span>
                                <span><?= ucfirst(str_replace('_', ' ', $asset['jenis_aset'])) ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Kondisi:</span>
                                <span class="badge-kondisi badge-<?= str_replace('_', '-', $asset['kondisi']) ?>">
                                    <?= ucfirst(str_replace('_', ' ', $asset['kondisi'])) ?>
                                </span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="badge-status badge-<?= $asset['status'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $asset['status'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ($asset['qr_code']): ?>
                    <div class="qr-code-section">
                        <h3>QR Code</h3>
                        <img src="<?= base_url('uploads/' . $asset['qr_code']) ?>" alt="QR Code" style="width: 250px; height: 250px;">
                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <a href="<?= base_url('uploads/' . $asset['qr_code']) ?>" download class="btn btn-success">
                                <i class="fas fa-download"></i> Download QR
                            </a>
                            <button type="button" class="btn btn-secondary" onclick="window.print()">
                                <i class="fas fa-print"></i> Print QR
                            </button>
                            <a href="<?= site_url('scan/' . $asset['id']) ?>" class="btn btn-primary" target="_blank">
                                <i class="fas fa-link"></i> Buka Halaman Scan
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <a href="<?= site_url('barang') ?>" class="btn-back">Kembali ke Daftar</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
