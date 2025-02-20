<?php
session_start();
require 'includes/config.php';

$cart_items = [];
$total_price = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $total_price += $row['subtotal'];
        $cart_items[] = $row;
    }
}

// Simpan total harga ke sesi untuk checkout
$_SESSION['total_price'] = $total_price;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <a href="index.php" class="back-btn"><</a>
        <div class="logo">
            <img src="assets/images/logo.png"> 
            <h2> | Keranjang Belanja</h2>
        </div> 
    </div>

    <div class="container">
        

        <?php if (!empty($cart_items)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td class="product">
                                <img src="uploads/<?= str_replace(' ', '_', $item['series']) . '/' . $item['photo']; ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                                <span><?= htmlspecialchars($item['name']); ?></span>
                            </td>

                            <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                            <td>
                                <div class="quantity-container">
                                    <button class="qty-btn decrease" data-id="<?= $item['id']; ?>">-</button>
                                    <input type="text" class="qty-input" value="<?= $item['quantity']; ?>" data-id="<?= $item['id']; ?>" readonly>
                                    <button class="qty-btn increase" data-id="<?= $item['id']; ?>">+</button>
                                </div>
                            </td>
                            <td class="subtotal" data-id="<?= $item['id']; ?>">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-footer">
                <span class="subtotal">Subtotal :<strong>   Rp <?= number_format($total_price, 0, ',', '.'); ?></strong></span>
                <a href="checkout.php" class="checkout-btn">Checkout</a>
            </div>


            
        <?php else: ?>
            <p class="empty-cart">Keranjang belanja kosong.</p>
        <?php endif; ?>
    </div>

    
</body>

<style>
    /* Reset dasar */
body {
    font-family: 'Poppins';
    margin: 0;
    padding: 0;
    background-color: #fff;
}

/* Container utama */
.container {
    width: 90%;
    margin: 30px auto;
    background: rgb(255, 238, 238);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header */
.header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
}

.logo {
    margin: 0;
    display: flex;
    color: #000;
    margin-left: 60%;
}

.logo img {
    width: 120px;
    height: auto;
}

.back-btn {
    font-family: 'Rammetto One', sans-serif;
    margin-left: 50px;
    text-decoration: none;
    font-size: 50px;
    color: #A21A1A;
}

/* Tabel keranjang */
.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th, .cart-table td {
    text-align: center;
    border-bottom: 1px solid #000;
    padding: 15px;
}

.cart-table th {
    background: #fff;
    color: black;
    font-weight: bold;
    border-bottom: 2px solid black;
}

/* Baris produk */
.cart-table tr {
    background: #ffeeee;
    border-left: 1px solid #000;
    border-right: 1px solid #000;
}

/* Produk */
.product {
    display: flex;
    align-items: center;
    gap: 15px;
    text-align: left;
}

.product img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    background: white;
    padding: 5px;
}

/* Tombol jumlah */
.quantity-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    border: 1px solid black;
    border-radius: 5px;
    padding: 5px;
    width: fit-content;
    background: white;
}

.quantity-container button {
    background: none;
    color: black;
    border: none;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
}

.quantity-container input {
    width: 30px;
    text-align: center;
    font-size: 16px;
    border: none;
    background: none;
    font-weight: bold;
}

/* Hapus border bawah di baris terakhir */
.cart-table tr:last-child td {
    border-bottom: none;
}

/* Footer - Subtotal & Checkout */
.cart-footer {
    display: flex;
    justify-content: space-between; /* Subtotal di kiri, tombol di kanan */
    align-items: center; /* Biar vertikal sejajar di tengah */
    background: #e0c8c8;
    padding: 30px 20px ;
    width: 97%;
}

/* Subtotal */
.subtotal {
    font-size: 18px;
    font-weight: bold;
    color: black;
}

.subtotal strong {
    font-size: 20px;
    color: red;
}

/* Tombol Checkout */
.checkout-btn {
    background: #791818;
    color: white;
    border: none;
    padding: 12px 55px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
}

.checkout-btn:hover {
    background: #5c1e1e;
}

/* Pesan jika keranjang kosong */
.empty-cart {
    text-align: center;
    font-size: 18px;
    color: #7b2b2a;
    font-weight: bold;
    padding: 20px;
}

/* Responsif */
@media (max-width: 768px) {
    .container {
        width: 95%;
    }

    .cart-table th, .cart-table td {
        padding: 10px;
        font-size: 14px;
    }

    .checkout-btn {
        font-size: 16px;
        padding: 12px;
    }

    .cart-footer {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}

</style>

</html>
