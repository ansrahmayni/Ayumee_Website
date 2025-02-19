<?php
session_start();
require 'includes/config.php'; // Koneksi ke database

if (!isset($_GET['order_id'])) {
    die("Order ID tidak ditemukan.");
}

$order_id = $_GET['order_id'];

// Ambil data pesanan dari database
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Pesanan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan</title>
</head>
<body>
    <h1>Konfirmasi Pesanan</h1>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']); ?></p>
    <p><strong>Nama:</strong> <?= htmlspecialchars($order['name']); ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($order['address']); ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($order['payment_method']); ?></p>
    <p><strong>Total:</strong> Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['order_status']); ?></p>
    
    <?php if ($order['payment_method'] != 'COD' && $order['order_status'] == 'Pending'): ?>
    <?php endif; ?>
    
    
    <p><a href="payment_confirmation.php?order_id=<?= htmlspecialchars($order_id); ?>">Konfirmasi Pembayaran</a></p>

    <a href="index.php">Kembali ke Beranda</a>
</body>
</html>
