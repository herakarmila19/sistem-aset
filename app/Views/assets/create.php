<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sistem Aset</title>
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
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            transition: all 0.3s ease;
            margin-left: 15px;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .form-card h2 {
            color: #333;
            font-weight: 700;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 15px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }
        
        .file-input-label {
            display: block;
            padding: 12px 15px;
            background-color: #f5f7fa;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            color: #667eea;
            font-weight: 600;
        }
        
        .file-input-wrapper:hover .file-input-label {
            border-color: #667eea;
            background-color: #f0f2ff;
        }
        
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 8px;
            display: none;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .btn-cancel {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-cancel:hover {
            background: #d0d0d0;
            color: #333;
        }
        
        .form-text-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
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
                    <a class="nav-link" href="/barang"><i class="fas fa-list"></i> Data Barang</a>
                    <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="form-card">
            <h2><i class="fas fa-plus"></i> Tambah Barang Baru</h2>
            <?php $validation = session('validation') ?? ($validation ?? null); ?>
            <?php if ($validation && $validation->getErrors()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="<?= site_url('barang/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang" class="form-label">Nama Barang <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Contoh: Kamera DSLR" value="<?= old('nama_barang') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="merk_barang" class="form-label">Merk Barang</label>
                            <input type="text" class="form-control" id="merk_barang" name="merk_barang" placeholder="Contoh: Canon" value="<?= old('merk_barang') ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                            <select class="form-select" id="tahun_pengadaan" name="tahun_pengadaan">
                                <option value="">-- Pilih Tahun --</option>
                                <?php foreach (array_reverse($years ?? []) as $year): ?>
                                    <option value="<?= $year ?>" <?= old('tahun_pengadaan') == $year ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_aset" class="form-label">Jenis Aset <span style="color: red;">*</span></label>
                            <select class="form-select" id="jenis_aset" name="jenis_aset" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="aset" <?= old('jenis_aset') === 'aset' ? 'selected' : '' ?>>Aset</option>
                                <option value="non_aset" <?= old('jenis_aset') === 'non_aset' ? 'selected' : '' ?>>Non Aset</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kondisi" class="form-label">Kondisi Barang <span style="color: red;">*</span></label>
                            <select class="form-select" id="kondisi" name="kondisi" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" <?= old('kondisi') === 'baik' ? 'selected' : '' ?>>Baik</option>
                                <option value="rusak_ringan" <?= old('kondisi') === 'rusak_ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                                <option value="rusak_berat" <?= old('kondisi') === 'rusak_berat' ? 'selected' : '' ?>>Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" value="Ada" disabled>
                            <small class="form-text-info"><i class="fas fa-info-circle"></i> Status otomatis diisi dengan "Ada"</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="foto" class="form-label">Foto Barang</label>
                    <div class="file-input-wrapper">
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                        <label for="foto" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i> Klik untuk upload foto atau drag & drop
                        </label>
                    </div>
                    <img id="preview" class="preview-img" alt="Preview">
                    <small class="form-text-info">Format: JPG, PNG. Maksimal 5MB</small>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Simpan Data Barang
                    </button>
                    <a href="/barang" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
