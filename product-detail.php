<?php
require 'includes/config.php'; // Koneksi ke database
require 'includes/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak diberikan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> - Detail Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="product-detail">
    <div class="image-container">
        <img src="uploads/<?= htmlspecialchars($product['series']) ?>/<?= htmlspecialchars($product['photo']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-info">
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
        <p class="desc" ><?= htmlspecialchars($product['description']); ?></p>
        <p class="stock">Tersisa <?= htmlspecialchars($product['stock']); ?> buah</p>
        
        <div class="quantity">
            <button onclick="decreaseQuantity()">-</button>
            <input type="text" id="quantity" value="1" readonly>
            <button onclick="increaseQuantity()">+</button>
        </div>
        
        <button class="add-to-cart">Tambahkan Keranjang</button>
    </div>
</div>

<script>
function decreaseQuantity() {
    let qty = document.getElementById("quantity");
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}

function increaseQuantity() {
    let qty = document.getElementById("quantity");
    qty.value = parseInt(qty.value) + 1;
}
</script>

</body>

<style>
    body{
        font-family: 'Rammetto One', cursive;
        background-color: #E0C8C8;
        display: flex;
        justify-content: center;
        height: 100vh; /* Agar selalu di tengah vertikal */
        margin: 0;
    }

    .product-detail {
        display: flex;
        gap: 20px;
        background: #fff;
        border-radius: 10px;
        width: 80%;
        height: 80%;
        align-items: center;
        justify-content: center;
    }

    .image-container{
        margin-top: 50px;

    }

    .image-container img {
        width: 300px;
        border-radius: 10px;
    }

    .product-info {
        max-width: 400px;
    }

    .price {
        font-size: 20px;
        font-weight: bold;
        color: #d9534f;
    }

    .desc{
        font-family: 'Poppins';
    }

    .quantity {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity button {
        background: #d9534f;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .add-to-cart {
        background: #7d3c3c;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-weight: bold;
    }

</style>
</html>
