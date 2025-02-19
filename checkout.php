<?php
session_start();
require 'includes/config.php';
require 'includes/midtrans_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    
    // Simpan pesanan ke database (status default: Pending)
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, name, address, payment_method, order_status, total_price, created_at) 
                           VALUES (:user_id, :name, :address, :payment_method, 'Pending', :total_price, NOW())");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'name' => $name,
        'address' => $address,
        'payment_method' => $payment_method,
        'total_price' => $_SESSION['total_price']
    ]);


    // Jika COD, langsung tandai sebagai Shipped
    header("Location: order_confirmation.php?order_id=$order_id");
    exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>
<script>
document.getElementById('checkout-button').onclick = function() {
    fetch('checkout.php', { method: 'POST', body: new FormData(document.getElementById('checkout-form')) })
    .then(response => response.json())
    .then(data => {
        snap.pay(data.snapToken, {
            onSuccess: function(result) {
                window.location.href = "order_confirm.php?order_id=" + result.order_id;
            },
            onPending: function(result) {
                alert('Pembayaran tertunda!');
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
            }
        });
    });
};
</script>


<body>
    <h1>Checkout</h1>
    <form method="POST" action="">
        <label>Nama:</label>
        <input type="text" name="name" required><br>
        
        <label>Alamat:</label>
        <textarea name="address" required></textarea><br>
        
        <label>Metode Pembayaran:</label>
        <select name="payment_method" required>
            <option value="COD">COD</option>
            <option value="BCA">Transfer BCA</option>
            <option value="BNI">Transfer BNI</option>
            <option value="BSI">Transfer BSI</option>
            <option value="Mandiri">Transfer Mandiri</option>
            <option value="QRIS">QRIS</option>
        </select><br>
        
        <button type="submit">Checkout</button>

        
    </form>
</body>
</html>
