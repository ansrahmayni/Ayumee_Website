<?php
require 'includes/config.php'; // Koneksi ke database
require 'includes/header.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    // Simpan halaman tujuan setelah login
    $_SESSION['redirect_after_login'] = "product-detail.php?id=" . $_GET['id'];
    header("Location: login.php");
    exit;
}

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

<script>
    

</script>

<body>

<div class="product-detail">
    <div class="image-container">
        <img src="uploads/<?= htmlspecialchars($product['series']) ?>/<?= htmlspecialchars($product['photo']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-info">
        <h2><?= htmlspecialchars($product['name']); ?></h2> <br /><br />
        <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p><br />
        <p class="desc" ><?= htmlspecialchars($product['description']); ?></p>
        
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

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".add-to-cart").addEventListener("click", function () {
        let quantity = parseInt(document.getElementById("quantity").value);
        let productId = <?= json_encode($product['id']); ?>;

        fetch("add_to_cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },      
            body: JSON.stringify({ id: productId, quantity: quantity }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(".cart-badge").textContent = data.total_items;
            } else {
                alert("Gagal menambahkan ke keranjang");
            }
        });
    });
});

</script>

</body>

<style>
    body {
        font-family: 'Rammetto One', cursive;
        background-color: #E0C8C8;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Agar selalu di tengah vertikal */
        margin: 0;
        flex-direction: column; /* Menyusun elemen secara vertikal */
    }

    nav {
        position: fixed; /* Navbar tetap di atas */
        top: 0;
        left: 0;
        width: 100%;
        background-color: #FCEBE5;
        padding: 15px 20px;
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-detail {
        display: flex;
        background: #fff;
        border-radius: 10px;
        width: 80%;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        margin: 0 700px;
        margin-top: 80px; /* Supaya tidak tertutup navbar */
    }

    .image-container{
        flex: 1; /* Biar foto lebih ke kiri */
        display: flex;
        justify-content: flex-start; /* Dorong ke kiri */
    }

    .image-container img {
        width: 500px;
        border-radius: 10px;
    }

    .product-info {
        margin-left: 20px;
        margin-bottom: 120px;
        
    }

    .h2{
        padding-bottom: 150px;
    }

    .desc{
        font-family: 'Poppins';
        background-color: #F4F2F2;
        padding: 10px;
    }


    .price {
        font-size: 20px;
        font-weight: bold;
        color: #d9534f;
    }

    .quantity {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    border: 1px solid black;
    border-radius: 5px;
    padding: 5px;
    width: fit-content;
    background: white;
        margin-top: 50px;
}

.quantity button {
    background: none;
    color: black;
    border: none;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
}

.quantity input {
    width: 30px;
    text-align: center;
    font-size: 16px;
    border: none;
    background: none;
    font-weight: bold;
}

    .add-to-cart {
        background: #7d3c3c;
        font-family: 'Rammetto One';
        margin-top: 30px;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 10px;
    }

    .add-to-cart:hover{
        background:rgb(54, 14, 14);
    }

</style>
</html>
