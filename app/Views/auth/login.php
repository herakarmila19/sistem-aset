<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="header-brand">
                    <img src="<?= base_url('assets/img/logo-kominfotik.svg') ?>" alt="Logo Kominfotik" class="header-logo">
                    <div>
                        <h1 class="brand-title">Sistem Barang</h1>
                        <p class="brand-subtitle">Suku Dinas Kominfotik Jakarta Selatan</p>
                    </div>
                </div>
            </div>
            <div class="login-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('login') ?>" method="post">
                    <div class="form-group">
                        <label for="username" class="form-label"><i class="fas fa-user"></i> Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>

<<<<<<< HEAD
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-barcode"></i> Captcha</label>
                        <input type="text" class="form-control text-center" id="captcha_display" disabled="" style="margin-bottom: 10px; font-weight: bold; font-size: 20px; letter-spacing: 3px;">
                        <div class="captcha-input-row">
                            <input type="text" name="captcha" id="captcha_confirm" class="form-control" placeholder="Masukkan kode di atas" inputmode="numeric" required="">
                            <div class="captcha-icon" id="captcha-refresh" title="Refresh Captcha">
                                <span class="fas fa-redo"></span>
                            </div>
                        </div>
=======
                    <div class="captcha-box">
                        <label for="captcha-confirm" class="form-label">Captcha</label>
                        <div class="input-group">
                            <input type="text" id="captcha-code" name="captcha_code" hidden>
                            <input type="text" id="captcha-display" class="form-control captcha-input" disabled>
                            <input type="number" class="form-control captcha-confirm" id="captcha-confirm" name="captcha_confirm" placeholder="Isi captcha" required>
                            <span class="input-group-text captcha-icon">
                                <i class="fas fa-barcode"></i>
                            </span>
                        </div>
                        <button type="button" class="captcha-refresh" id="captcha-refresh">Muat ulang captcha</button>
>>>>>>> 2dcfdaf5adf4aef9b0c77d0d5a12b2eb4b0afbc6
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadCaptcha() {
            fetch('<?= site_url('login/captcha') ?>', { cache: 'no-store' })
                .then(response => response.text())
                .then(data => {

                });
        }

        // Load captcha on page load
        window.addEventListener('load', loadCaptcha);

        // Refresh captcha on icon click
        document.getElementById('captcha-refresh').addEventListener('click', function(e) {
            e.preventDefault();
            loadCaptcha();
        });
    </script>
</body>
</html>
