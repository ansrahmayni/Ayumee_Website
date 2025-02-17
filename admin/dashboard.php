<?php
session_start();
require '../includes/config.php';
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../admin/dashboard");
    exit;
}

$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <?php foreach ($products as $product) : ?>
            <div class="card">
                <img src="../uploads/<?php echo str_replace(' ', '_', $product['series']) . '/' . $product['photo']; ?>" width="100" alt="Product Photo">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                <div class="actions">
                    <a href="update.php?id=<?= $product['id']; ?>" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="delete.php?id=<?= $product['id']; ?>" class="delete"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

<style>
     <style>
        body {
            box-sizing: border-box;
            font-family: 'Poppins';
            background-color: #000;
            display: flex;
        }

        .container {
            gap: 90px;
            flex-wrap: wrap;
            display: flex;
            margin-left: 250px;
            margin-top: 95px;
        }

        .card {
            background: white;
            border-radius: 10px;
            width: 250px;
            padding: 15px;
            text-align: center;
            border: 1px solid #000;
            background-color: white;
        }

        .card img {
            width: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .card h3 {
            font-size: 14px;
            font-weight: 900;
            color: #000;
        }

        .card .price {
            font-size: 14px;
            color: red;
            font-weight: 900;
        }

        .card .actions {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .card .actions a {
            text-decoration: none;
            font-size: 18px;
            color: black;
        }

        .card .actions a.delete {
            color: red;
        }
    </style>

    
</style>
</html>