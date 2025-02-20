<?php
session_start();

require 'includes/config.php';
require 'vendor/autoload.php';

use Midtrans\Config;

Config::$serverKey = 'YOUR_MIDTRANS_SERVER_KEY';
Config::$isProduction = false;

$raw_body = file_get_contents("php://input");
$notification = json_decode($raw_body, true);

$order_id = $notification['order_id'];
$transaction_status = $notification['transaction_status'];
$payment_amount = $notification['gross_amount'];
$transaction_time = $notification['transaction_time'];

$stmt = $pdo->prepare("UPDATE payments SET transaction_status = ?, transaction_time = ?, payment_amount = ? WHERE order_id = ?");
$stmt->execute([$transaction_status, $transaction_time, $payment_amount, $order_id]);

if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
    $stmt = $pdo->prepare("UPDATE orders SET order_status = 'shipped' WHERE id = ?");
    $stmt->execute([$order_id]);
}

// Ambil data dari Midtrans
$transaction_status = $_POST['transaction_status'];

if ($transaction_status == "settlement" || $transaction_status == "capture") {
    // Jika pembayaran sukses, kosongkan sesi keranjang
    unset($_SESSION['cart']);
    unset($_SESSION['total_price']);
}



http_response_code(200);
?>
