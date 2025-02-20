<?php
session_start();

require 'includes/config.php';
require 'includes/header.php';

// Reset keranjang setelah order dikonfirmasi
unset($_SESSION['cart']);
unset($_SESSION['total_price']);

$order_id = $_GET['order_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM payments WHERE order_id = ?");
$stmt->execute([$order_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pesanan</title>
</head>
<body>
    <div class="overall">
        <h1>Detail Pesanan</h1>
        <p>Order ID: <?= $order['id']; ?></p>
        <p>Nama: <?= $order['name']; ?></p>
        <p>Total Harga: Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></p>
        <p>Status Orderan: Paket sedang dalam pengiriman</p>
    </div>
</body>

<style>
    body {
    font-family: 'Poppins', sans-serif;
    background-color: #fdf6f3;
    margin: 0;
    padding: 0;
}

nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #FCEBE5;
    padding: 15px 20px;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.overall {
    margin: 150px auto 50px auto;
    width: 50%;
    background: white;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 230px;
    text-align: left;
}

h1 {
    font-size: 22px;
    color: #333;
    margin-bottom: 15px;
    border-bottom: 2px solid #000;
}

p {
    font-size: 16px;
    color: #555;
    margin: 5px 0;
}

p strong {
    color: #333;
}

.order-status {
    font-weight: bold;
    color: #d77a61;
    background: #fcebe5;
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-block;
}

</style>

</html>
