<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="assets-container">
    <div class="assets-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Daftar Barang</h2>
            <a href="<?= site_url('barang/create') ?>" class="btn btn-primary btn-add-new">
                <i class="fas fa-plus"></i> Tambah Barang Baru
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <?php if (!empty($assets)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Merk</th>
                        <th>Tahun</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td><strong>#<?= $asset['id'] ?></strong></td>
                            <td><?= $asset['nama_barang'] ?></td>
                            <td><?= $asset['keterangan'] ?: '-' ?></td>
                            <td><?= $asset['merk_barang'] ?? '-' ?></td>
                            <td><?= $asset['tahun_pengadaan'] ?? '-' ?></td>
                            <td><span class="badge bg-secondary"><?= ucfirst(str_replace('_', ' ', $asset['jenis_aset'])) ?></span></td>
                            <td>
                                <?php 
                                $statusClass = match($asset['status']) {
                                    'ada' => 'success',
                                    'dipinjam' => 'warning',
                                    'hilang' => 'danger',
                                    default => 'secondary'
                                };
                                ?>
                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', $asset['status'])) ?></span>
                            </td>
                            <td>
                                <?php 
                                $kondisiClass = match($asset['kondisi']) {
                                    'baik' => 'success',
                                    'rusak_ringan' => 'warning',
                                    'rusak_berat' => 'danger',
                                    default => 'secondary'
                                };
                                ?>
                                <span class="badge bg-<?= $kondisiClass ?>"><?= ucfirst(str_replace('_', ' ', $asset['kondisi'])) ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= site_url('barang/' . $asset['id']) ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= site_url('barang/' . $asset['id'] . '/edit') ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('barang/' . $asset['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3>Belum Ada Data Barang</h3>
            <p>Mulai dengan menambahkan barang pertama Anda ke sistem</p>
            <a href="<?= site_url('barang/create') ?>" class="btn btn-primary mt-3">
                <i class="fas fa-plus"></i> Tambah Barang Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

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
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            transition: all 0.3s ease;
            margin-left: 15px;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-top: 20px;
            margin-bottom: 30px;
            border-radius: 15px;
        }
        
        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .asset-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .asset-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .asset-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }
        
        .asset-body {
            padding: 20px;
        }
        
        .asset-name {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .asset-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
        }
        
        .badge-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            margin-bottom: 10px;
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
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            margin-left: 5px;
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
        
        .qr-code-thumb {
            width: 80px;
            height: 80px;
            display: inline-block;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }
        
        .qr-code-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .asset-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }
        
        .btn-detail, .btn-edit, .btn-delete {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .btn-detail {
            background: #667eea;
            color: white;
        }
        
        .btn-detail:hover {
            background: #5566d2;
            color: white;
        }
        
        .btn-edit {
            background: #28a745;
            color: white;
        }
        
        .btn-edit:hover {
            background: #218838;
            color: white;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            animation: slideDown 0.3s ease;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard"><i class="fas fa-box"></i> Sistem Aset</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="/dashboard"><i class="fas fa-home"></i> Dashboard</a>
                    <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-list"></i> Data Barang</h1>
            <p class="mb-0">Kelola semua aset kantor Anda</p>
        </div>
        
        <a href="/barang/create" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Barang Baru
        </a>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($assets)): ?>
            <div class="row">
                <?php foreach ($assets as $asset): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="asset-card">
                            <?php if ($asset['foto']): ?>
                                <img src="/uploads/<?= $asset['foto'] ?>" alt="<?= $asset['nama_barang'] ?>" class="asset-image">
                            <?php else: ?>
                                <div class="asset-image" style="display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="font-size: 50px; color: #ccc;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="asset-body">
                                <div class="asset-name"><?= $asset['nama_barang'] ?></div>
                                
                                <div class="asset-info">
                                    <span><strong>Keterangan:</strong></span>
                                    <span><?= $asset['keterangan'] ?: '-' ?></span>
                                </div>

                                <div class="asset-info">
                                    <span><strong>Merk:</strong></span>
                                    <span><?= $asset['merk_barang'] ?? '-' ?></span>
                                </div>
                                
                                <div class="asset-info">
                                    <span><strong>Tahun:</strong></span>
                                    <span><?= $asset['tahun_pengadaan'] ?? '-' ?></span>
                                </div>
                                
                                <div class="asset-info">
                                    <span><strong>Jenis:</strong></span>
                                    <span><?= ucfirst(str_replace('_', ' ', $asset['jenis_aset'])) ?></span>
                                </div>
                                
                                <div style="margin-bottom: 10px;">
                                    <span class="badge-status badge-<?= $asset['status'] ?>" title="Status">
                                        <i class="fas fa-circle-info"></i> <?= ucfirst(str_replace('_', ' ', $asset['status'])) ?>
                                    </span>
                                    <span class="badge-kondisi badge-<?= str_replace('_', '-', $asset['kondisi']) ?>" title="Kondisi">
                                        <?= ucfirst(str_replace('_', ' ', $asset['kondisi'])) ?>
                                    </span>
                                </div>
                                
                                <?php if ($asset['qr_code']): ?>
                                    <div style="margin-bottom: 15px; text-align: center;">
                                        <label style="font-weight: 600; font-size: 12px; color: #666; margin-bottom: 5px; display: block;">QR Code</label>
                                        <div class="qr-code-thumb">
                                            <img src="/uploads/<?= $asset['qr_code'] ?>" alt="QR Code">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="asset-actions">
                                    <a href="/barang/<?= $asset['id'] ?>" class="btn-detail">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="/barang/<?= $asset['id'] ?>/edit" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="/barang/<?= $asset['id'] ?>/delete" class="btn-delete" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Belum Ada Data Barang</h3>
                <p>Mulai dengan menambahkan barang pertama Anda</p>
                <a href="/barang/create" class="btn-add" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Tambah Barang Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
