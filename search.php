<?php
require 'includes/config.php';
require 'includes/header.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']);

    $sql = "SELECT * FROM products WHERE name LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['query' => "%$query%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
</head>
<body>
    <h2>Hasil Pencarian untuk: "<?= htmlspecialchars($query); ?>"</h2>
    <div class="container">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <a href="product-detail.php?id=<?= htmlspecialchars($product['id']); ?>" class="card-link">
                    <div class="card">
                        <img src="uploads/<?= htmlspecialchars($product['series']); ?>/<?= htmlspecialchars($product['photo']); ?>" width="100" alt="Product Photo">
                        <h3><?= htmlspecialchars($product['name']); ?></h3>
                        <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Tidak ada produk yang ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.card-link {
    text-decoration: none;
    color: inherit;
}

.card {
    display: flex;
    align-items: center;
    gap: 15px;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.card img {
    width: 100px;
    height: auto;
    border-radius: 5px;
}

.card h3 {
    font-size: 18px;
    margin: 0;
    color: #444;
}

.price {
    font-size: 16px;
    font-weight: bold;
    color: #791818;
}

p {
    text-align: center;
    color: #777;
}

</style>
</html>
