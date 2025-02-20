<?php
require 'vendor/autoload.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-KyEQodpgfSe7MJYuf2hATmR3';  // Ganti dengan server key dari Midtrans
\Midtrans\Config::$isProduction = false;          // Ubah ke true jika sudah live
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
