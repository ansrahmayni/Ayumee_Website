<?php
session_start();
require 'includes/config.php';

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $_SESSION['cart'][$id] = $quantity;
    }

    // Ambil data produk untuk update subtotal
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $subtotal = $product['price'] * $quantity;

    // Hitung ulang total harga keseluruhan
    $total_price = 0;
    foreach ($_SESSION['cart'] as $key => $qty) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$key]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_price += $prod['price'] * $qty;
    }
    $_SESSION['total_price'] = $total_price;

    // Kirim data balik ke JavaScript (JSON format)
    echo json_encode([
        "subtotal" => number_format($subtotal, 0, ',', '.'),
        "total" => number_format($total_price, 0, ',', '.')
    ]);
}
