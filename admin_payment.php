<?php
require 'includes/config.php';

// Ambil data pembayaran pending
$stmt = $pdo->query("SELECT payments.*, orders.status AS order_status FROM payments JOIN orders ON payments.order_id = orders.id WHERE payments.status = 'Pending'");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['payment_id'];
    $order_id = $_POST['order_id'];

    // Update status pembayaran menjadi "Confirmed"
    $pdo->prepare("UPDATE payments SET status = 'Confirmed' WHERE id = ?")->execute([$payment_id]);

    // Update status pesanan menjadi "Shipped"
    $pdo->prepare("UPDATE orders SET status = 'Shipped' WHERE id = ?")->execute([$order_id]);

    header("Location: admin_payments.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
</head>
<body>
    <h2>Konfirmasi Pembayaran</h2>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Metode Pembayaran</th>
            <th>Bukti</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= htmlspecialchars($payment['order_id']); ?></td>
                <td><?= htmlspecialchars($payment['payment_method']); ?></td>
                <td><img src="uploads/payments/<?= htmlspecialchars($payment['proof_image']); ?>" width="100"></td>
                <td><?= htmlspecialchars($payment['status']); ?></td>
                <td>
                    <form action="admin_payments.php" method="POST">
                        <input type="hidden" name="payment_id" value="<?= $payment['id']; ?>">
                        <input type="hidden" name="order_id" value="<?= $payment['order_id']; ?>">
                        <button type="submit">Konfirmasi</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
