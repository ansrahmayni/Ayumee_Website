<?php
session_start();
require 'includes/config.php';

if (!isset($_GET['order_id'])) {
    echo "Order ID tidak ditemukan.";
    exit;
}

$order_id = $_GET['order_id'];


// Cek apakah order milik user dan statusnya masih pending
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id AND order_status = 'Pending'");
$stmt->execute(['order_id' => $order_id, 'user_id' => $_SESSION['user_id']]);

$order = $stmt->fetch();

if (!$order) {
    echo "Orderan kamu sudah dalam pengiriman";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['payment_proof'])) {
    $target_dir = "uploads/payments/";
    $target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
    
    if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
        // Update status order menjadi Shipped setelah bukti diunggah
        $stmt = $pdo->prepare("UPDATE orders SET order_status = 'Shipped', payment_proof = :payment_proof WHERE id = :id");
        $stmt->execute(['payment_proof' => $target_file, 'id' => $order_id]);
        
        header("Location: order_confirmation.php?order_id=$order_id");
        exit;
    } else {
        echo "Terjadi kesalahan saat mengunggah bukti pembayaran.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
</head>
<body>
    <h1>Konfirmasi Pembayaran</h1>
    <p>Silakan unggah bukti pembayaran untuk Order ID: <strong><?= htmlspecialchars($order_id) ?></strong></p>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Unggah Bukti Pembayaran:</label>
        <input type="file" name="payment_proof" required><br>
        <button type="submit">Kirim Bukti Pembayaran</button>
    </form>
    
    <a href="order_confirm.php?id=<?= htmlspecialchars($id) ?>">Kembali ke Order</a>
</body>
</html>
