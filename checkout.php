<?php
session_start();
require 'includes/config.php';

// Ambil item dari session cart
$cart_items = [];
$total_price = 0;
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $cart_items[] = $row;
        $total_price += $row['price'] * $row['quantity'];
    }
}

// Jika form dikirim, buat pesanan dan arahkan ke pembayaran
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Simpan order ke database
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, name, email, phone, address, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $name, $email, $phone, $address, $total_price]);
    $order_id = $pdo->lastInsertId();

    // Simpan item ke order_items
    foreach ($cart_items as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
    }

    // Arahkan ke Midtrans API
    header("Location: midtrans_api.php?order_id=$order_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Jd6vFUkcJrsIfLW2"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .logo {
            margin-left: 5%;
            margin-top: 2%;
            display: flex;
            color: #000;
        }

        .logo img {
            width: 120px;
            height: auto;
        }

        .h2{
            
            margin-right: 40%;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
        }
        .form-section {
            background: #fff;
            padding: 20px;
            margin-right: 55px;
            border-radius: 10px;
        }
        .order-summary {
            background: #fff;
            margin-right: 20px;
            padding: 10px
        }
        .form-section {
            width: 55%;
        }
        .order-summary {
            border: 5px solid #E0C8C8;
            width: 100%;
            max-width: 400px;
        }

        .order-summary h3 {
            border-bottom: 5px solid #E0C8C8;
            color: #000;
            font-weight: bold;
        }

        .order-items {
            background: white;
            border-radius: 8px;
        }

        .order-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #000;
            padding: 10px 0;
        }

        .order-item img {
            border-radius: 5px;
            margin-right: 10px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            display: block;
            font-weight: 500;
            color: #00;
        }

        .item-quantity {
            color: #777;
            font-size: 12px;
        }

        .item-price {
            font-weight: bold;
            color: #333;
            font-size: 15px;
        }

        .order-summary-footer {
            margin-top: 15px;
            background: white;
            padding: 10px;
            border-radius: 8px;
        }

        .order-summary-footer p {
            color: #777;
        }

        .total {
            color: #000;
            font-size: 16px;
            font-weight: bold;
        }

        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .pay-button {
            background: #A21A1A;
            color: white;
            border: none;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            width: 105%;
            margin-top: 20px;
        }
        .pay-button:hover {
            background: #7b2b2a;
        }

        .2{
            display: flex;
        }

        .order-summary-footer p{
            color: #000;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <img src="assets/images/logo.png"> 
            <h2> | Checkout</h2>
        </div> 
    </div>

    <div class="container">
        <div class="form-section">
            <form id="checkout-form">
                <label>Nama Lengkap: <input type="text" name="name" required></label>
                <label>No Telepon: <input type="text" name="phone" required></label>
                <label>Email: <input type="email" name="email" required></label>
                <label>Alamat Lengkap: <textarea name="address" required></textarea></label>
                <input type="hidden" name="total_price" value="<?= $total_price ?>">
            </form>
            <button type="button" id="pay-button" class="pay-button">Bayar Sekarang</button>
        </div>
        <div class="order-summary">
            <h3>Daftar Pesanan</h3>
            <div class="order-items">
                <?php foreach ($cart_items as $item): ?>
                    <div class="order-item">
                        <img src="uploads/<?= str_replace(' ', '_', $item['series']) . '/' . $item['photo']; ?>" width="50">
                        <br />
                        <div class="item-details">
                            <span class="item-name"> <?= htmlspecialchars($item['name']); ?> </span>
                        </div>
                        <div class="2">
                            <span class="item-quantity"> <?= $item['quantity']; ?> pcs </span> |
                            <span class="item-price">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></span>


                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="order-summary-footer">
                <p>Subtotal: <span class="subtotal">Rp <?= number_format($total_price, 0, ',', '.'); ?></span></p>
                <p class="total">Total: <span>Rp <?= number_format($total_price, 0, ',', '.'); ?></span></p>
            </div>
        </div>
    
    <script>
    document.getElementById('pay-button').onclick = function () {
        fetch('midtrans_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(new FormData(document.getElementById('checkout-form')))
        })
        .then(response => response.json())
        .then(data => {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    window.location.href = "order_confirmation.php?order_id=" + result.order_id;
                },
                onPending: function(result) {
                    window.location.href = "order_confirmation.php?order_id=" + result.order_id;
                },
                onError: function(result) {
                    console.log('Pembayaran gagal:', result);
                }
            });
        })
        .catch(error => console.error('Error:', error));
    };
    </script>
</body>
</html>
