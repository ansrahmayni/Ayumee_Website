<?php
session_start();
require 'includes/config.php';

$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $cart_items[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
</head>

<script>
    document.getElementById('pay-button').onclick = function () {
    fetch('midtrans_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            order_id: 'ORDER' + Math.floor(Math.random() * 100000),
            gross_amount: <?= $total_price; ?>,
            name: 'John Doe',
            email: 'johndoe@email.com',
            phone: '08123456789'
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Debugging
        snap.pay(data.token);
    })
    .catch(error => console.error('Error:', error));
};

</script>

<body>
    <h1>Keranjang Belanja</h1>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
        <?php 
        $total_price = 0;
        foreach ($cart_items as $item): 
            $subtotal = $item['price'] * $item['quantity'];
            $total_price += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                <td><?= $item['quantity']; ?></td>
                <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td><strong>Rp <?= number_format($total_price, 0, ',', '.'); ?></strong></td>
        </tr>
    </table>
    <!-- <a href="checkout.php">Checkout</a> -->

    <button class="pay-button" id="pay-button">Bayar Sekarang</button>

</body>
</html>
