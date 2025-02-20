<?php
session_start();
require 'includes/config.php';
require 'vendor/autoload.php';

use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = 'SB-Mid-server-KyEQodpgfSe7MJYuf2hATmR3';
Config::$isProduction = false;
Config::$isSanitized = true;
Config::$is3ds = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $total_price = $_POST['total_price'];

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, name, email, phone, address, total_price, snap_token) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([null, $name, $email, $phone, $address, $total_price, null]);
    $order_id = $pdo->lastInsertId();

    // Simpan order_items dari session
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);
    }

    // Midtrans Payload
    $transaction = [
        'transaction_details' => ['order_id' => $order_id, 'gross_amount' => $total_price],
        'customer_details' => ['first_name' => $name, 'email' => $email, 'phone' => $phone]
    ];

    try {
        $snapToken = Snap::getSnapToken($transaction);
        $stmt = $pdo->prepare("UPDATE orders SET snap_token = ? WHERE id = ?");
        $stmt->execute([$snapToken, $order_id]);

        echo json_encode(['snap_token' => $snapToken]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
