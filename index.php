<?php

declare(strict_types=1);

// Jalankan front controller utama dari folder public tanpa memaksa redirect URL.
// Dengan ini aplikasi tetap dapat diakses dari /sistem-aset/ maupun path deployment lain.
require __DIR__ . '/public/index.php';
