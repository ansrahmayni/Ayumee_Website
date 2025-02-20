<?php
session_start();
$order_id = $_GET['order_id'] ?? '';

if (!$order_id) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
</head>
<body>
    <h1>Pembayaran Berhasil!</h1>
    <p>Order ID: <?= htmlspecialchars($order_id); ?></p>
    <p>Terima kasih telah berbelanja.</p>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html>
