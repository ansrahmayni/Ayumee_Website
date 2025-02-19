<?php
session_start();
require 'includes/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil semua pesanan user dari database
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembelian</title>
</head>
<body>
    <h1>Riwayat Pembelian</h1>
    
    <?php if (empty($orders)): ?>
        <p>Belum ada riwayat pembelian.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']); ?></td>
                    <td><?= htmlspecialchars($order['created_at']); ?></td>
                    <td>Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($order['order_status']); ?></td>
                    <td><a href="order_confirm.php?order_id=<?= $order['id']; ?>">Lihat</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <a href="index.php">Kembali ke Beranda</a>
</body>
</html>
