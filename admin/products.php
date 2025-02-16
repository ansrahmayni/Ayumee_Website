<?php
require '../includes/config.php';
require 'header.php';

// Ambil semua produk dari database
$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Product List</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Series</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <?php if (!empty($product['photo'])): ?>
                            <img src="../uploads/<?php echo str_replace(' ', '_', $product['series']) . '/' . $product['photo']; ?>" width="100" alt="Product Photo">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['series']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>

                    <td>
                        <a class="update" href="update.php?id=<?php echo $product['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a> |
                        <a class="delete" href="delete.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../admin/add_product.php" class="tambah">Tambah Produk</a>
</body>


<style>
    body{
        margin-left: 220px;
        margin-top: 75px;
        background-color: #FFF4F4;
        font-family: 'Poppins';
    }

    table{
        background-color: #fff;
        border-color: #fff;
        border-style: solid;
        border-collapse: collapse;
        width: 100.5%;
    }      

    td{
        text-align: center;
        vertical-align: middle;
    }

    .td i{
        text-decoration: none;
    }

    .update{
        color: black;
    }

    .delete{
        color: red;
    }

    td img {
        display: block;
        margin: auto;
    }

    tr {
        border-bottom: 1px solid black; /* Menambahkan garis bawah */
    }
    
    .tambah{
        background-color: #975B5B;
        text-decoration: none;
        color: #fff;
        padding: 10px 20px;
        margin-top: 30px;
        margin: 20px;
        float: right;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .tambah:hover{
        background-color: #E0C8C8;
        color: black
    }


</style>
</html>