<?php
require 'includes/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['id'];
$quantity = $data['quantity'];

// Ambil stok produk dari database
$stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product && $product['stock'] >= $quantity) {
    $_SESSION['cart'][$product_id] = $quantity;
    echo json_encode(["success" => true, "total_items" => array_sum($_SESSION['cart'])]);
} else {
    echo json_encode(["success" => false, "message" => "Stok tidak mencukupi"]);
}
