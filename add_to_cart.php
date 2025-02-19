<?php
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id']) || !isset($data['quantity'])) {
        echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
        exit;
    }

    $id = $data['id'];
    $quantity = (int) $data['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } else {
        $_SESSION['cart'][$id] = $quantity;
    }

    echo json_encode(["success" => true, "total_items" => array_sum($_SESSION['cart'])]);
} else {
    echo json_encode(["success" => false, "message" => "Metode request tidak valid"]);
}
