<?php
require '../includes/config.php';
require 'header.php';

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
    <title>Document</title>
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
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><img src="../uploads/<?php echo $product['photo']; ?>" width="100" alt="Product Photo"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['series']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $employee['id']; ?>">View</a> |
                        <a href="edit.php?id=<?php echo $employee['id']; ?>">Edit</a> |
                        <a href="delete.php?id=<?php echo $employee['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../admin/add_product.php" class="tambah">Tambah Karyawan Baru</a>
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

    td img {
        display: block;
        margin: auto;
    }

    tr {
        border-bottom: 1px solid black; /* Menambahkan garis bawah */
    }
    
    .tambah{
        background-color: #E0C8C8;
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
        background-color: #975B5B;
    }


</style>
</html>