<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Aset</title>
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
            transform: translateY(-2px);
        }
        
        .dashboard-welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .dashboard-welcome h1 {
            font-size: 32px;
            font-weight: 700;
        }
        
        .dashboard-welcome p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .menu-card i {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .menu-card h3 {
            color: #333;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .menu-card p {
            color: #666;
            font-size: 14px;
        }
        
        .menu-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .menu-card a:hover {
            color: white;
            transform: scale(1.05);
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
                    <a class="nav-link" href="/assets"><i class="fas fa-list"></i> Data Barang</a>
                    <span class="nav-link">Hai, <?= session('username') ?></span>
                    <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="dashboard-welcome">
            <h1><i class="fas fa-waves"></i> Selamat Datang di Dashboard</h1>
            <p>Kelola aset kantor Anda dengan mudah dan efisien</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="menu-card">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Tambah Barang</h3>
                    <p>Tambahkan barang baru ke sistem aset</p>
                    <a href="/assets/create">Mulai Sekarang</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="menu-card">
                    <i class="fas fa-inbox"></i>
                    <h3>Lihat Semua Barang</h3>
                    <p>Lihat daftar lengkap semua aset kantor</p>
                    <a href="/assets">Lihat Data</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>