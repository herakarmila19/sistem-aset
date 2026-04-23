<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row g-3">
        <!-- Total Barang -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Total Barang</p>
                    <h3 class="stat-value"><?= $total_barang ?></h3>
                </div>
            </div>
        </div>

        <!-- Barang Dipinjam -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Barang Dipinjam</p>
                    <h3 class="stat-value"><?= $barang_dipinjam ?></h3>
                </div>
            </div>
        </div>

        <!-- Data Barang Tidak Ada -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-danger">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Data Barang Tidak Ada</p>
                    <h3 class="stat-value"><?= $data_barang_tidak_ada ?></h3>
                </div>
            </div>
        </div>

        <!-- Barang Tersedia -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <p class="stat-label">Barang Tersedia</p>
                    <h3 class="stat-value"><?= $barang_tersedia ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .stat-card-primary .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card-warning .stat-icon {
        background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
        color: white;
    }

    .stat-card-danger .stat-icon {
        background: linear-gradient(135deg, #FF6B6B 0%, #EE5A52 100%);
        color: white;
    }

    .stat-card-success .stat-icon {
        background: linear-gradient(135deg, #2DBA54 0%, #25A246 100%);
        color: white;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 12px;
        color: #8896a3;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        color: #1f2937;
    }

    .quick-action {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .quick-action h5 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1f2937;
    }

    .quick-action .btn {
        margin-right: 10px;
        margin-bottom: 10px;
        border-radius: 6px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3e8e 100%);
        color: white;
    }

    .btn-secondary {
        background: #e9ecef;
        border: none;
        color: #495057;
    }

    .btn-secondary:hover {
        background: #dee2e6;
        color: #495057;
    }
</style>

<?= $this->endSection() ?>