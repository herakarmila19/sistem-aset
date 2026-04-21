<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            background: #f1f3f5;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 24px;
        }

        .login-container {
            width: 100%;
            max-width: 520px;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: #ffffff;
            color: #1f2937;
            padding: 24px 30px;
            border-bottom: 1px solid #eef0f3;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo {
            width: 52px;
            height: 52px;
            object-fit: contain;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .brand-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 14px;
            color: #4b5563;
            margin: 0;
        }

        .login-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .captcha-box {
            background: #f5f7fa;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .captcha-question {
            font-size: 20px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .captcha-refresh {
            border: none;
            background: transparent;
            color: #667eea;
            font-size: 13px;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            margin-top: 8px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
        }
    </style>
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

                    <div class="captcha-box">
                        <div class="captcha-question" id="captcha-question">Loading...</div>
                        <label for="captcha" class="form-label" style="margin-top: 10px;">Jawaban Captcha</label>
                        <button type="button" class="captcha-refresh" id="captcha-refresh">Muat ulang captcha</button>
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="captcha" name="captcha" placeholder="Masukkan jawaban" required>
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadCaptcha() {
            fetch('<?= site_url('captcha') ?>', { cache: 'no-store' })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('captcha-question').textContent = data;
                });
        }
        loadCaptcha();

        document.getElementById('captcha-refresh').addEventListener('click', loadCaptcha);
    </script>
</body>
</html>
