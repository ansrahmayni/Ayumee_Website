<?php
require '../includes/config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $series = $_POST['series'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Direktori upload berdasarkan series
    $upload_dir = "../uploads/" . str_replace(' ', '_', $series);

    // Buat folder jika belum ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Menangani upload foto baru jika ada
    $photo = !empty($_FILES['photo']['name']) ? $_FILES['photo']['name'] : $_POST['existing_photo'];

    if (!empty($_FILES['photo']['name'])) {
        $file_path = $upload_dir . '/' . $_FILES['photo']['name'];
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $file_path)) {
            $photo = $_FILES['photo']['name']; // Simpan nama file yang baru
        }
    }

    // Update data di database
    $sql = "UPDATE products SET price = ?, stock = ?, photo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$price, $stock, $photo, $id])) {
        header("Location: products.php?success=1");
        exit();
    } else {
        echo "Error updating record: " . print_r($stmt->errorInfo(), true);
    }
}

// Mengambil data produk berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<ht lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Update Produk</title>
</head>
<body>
    <h1>Product Update Form</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="series" value="<?php echo $product['series']; ?>">
        
        <div class="photo">
            <?php if (!empty($product['photo'])): ?>
                <img src="../uploads/<?php echo str_replace(' ', '_', $product['series']) . '/' . $product['photo']; ?>" width="100"><br>
                <input type="hidden" name="existing_photo" value="<?php echo $product['photo']; ?>">
            <?php endif; ?>
        </div>

        <label>Change Photo:</label>
        <input type="file" name="photo" accept="image/*"><br>

        <div class="container">
            <div class="stock">
                <label>Stok:</label>
                <input type="number" name="stock" value="<?php echo $product['stock']; ?>"><br>
            </div>

            <div class="price">
                <label>Harga:</label>
                <input type="text" name="price" value="<?php echo $product['price']; ?>"><br>
            </div>
        </div>
        <a href="products.php">
            <button class="back" type="button" name="back">Back</button>
        </a>
        <button type="submit" name="update">Update</button>
    </form>
</body>

<style>
    body {
        font-family: 'Poppins';
        background-color: #FFF4F4;
        justify-content: center;
        display: grid;
        height: 100vh;
        margin: 0;
    }

    h1 {
        font-size: 22px;
        margin-bottom: 20px;
        text-align: center;
    }

    form {
        background: #fff;
        padding: 20px 350px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 400px;
        margin-bottom: 10px;
    }

    .photo{
        text-align: center;
    }

    img {
        width: 300px;
        border-radius: 10px;
    }

    label {
        font-weight: 500;
        display: block;
    }

    input[type="file"] {
        width: 95%;
        padding: 10px;
        background: #E0C8C8;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 15px;
        border: 1px solid black; 
    }

    input[type="text"], input[type="number"] {
        width: calc(50% - 5px);
        padding: 10px;
        margin: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
    }

    .container{
        display: flex;
    }

    .container input{
        width: 170px;
    }

    button {
        width: 197px;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        margin-top: 15px;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
    }

    button[type="submit"]:hover {
        background-color:rgb(46, 106, 49);
    }
    
    a{
        text-decoration: none;
    }

    .back {
        background-color: #D9534F;
        color: white;
    }

    .back:hover {
        background-color:rgb(152, 38, 34);
    }

</style>
</html>
