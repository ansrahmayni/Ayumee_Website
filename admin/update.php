<?php
require '../includes/config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $series = $_POST['series']; // Nama series produk
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Direktori upload berdasarkan nama series
    $upload_dir = "../uploads/" . str_replace(' ', '_', $series);

    // Jika folder belum ada, buat foldernya
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Menangani upload foto
    $photo = !empty($_FILES['photo']['name']) ? $_FILES['photo']['name'] : $_POST['existing_photo'];

    if (!empty($_FILES['photo']['name'])) {
        $file_path = $upload_dir . '/' . $_FILES['photo']['name'];
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $file_path)) {
            $photo = $_FILES['photo']['name']; // Simpan nama file yang baru
        } else {
            echo "Gagal mengunggah foto.";
            exit;
        }
    }

    // Update data di database
    $sql = "UPDATE products SET price = ?, stock = ?, photo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$price, $stock, $photo, $id])) {
        header("Location: products.php?success=1");
        exit;
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
<html lang="id">
<head>
    <title>Edit Produk</title>
</head>
<body>
    <h1>Edit Produk</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="series" value="<?php echo $product['series']; ?>">
        
        <label>Harga:</label> 
        <input type="text" name="price" value="<?php echo $product['price']; ?>"><br>

        <label>Stok:</label> 
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>"><br>

        <label>Foto Produk:</label><br>
        <?php if (!empty($product['photo'])): ?>
            <img src="../uploads/<?php echo str_replace(' ', '_', $product['series']) . '/' . $product['photo']; ?>" width="100" alt="Product Photo"><br>
            <input type="hidden" name="existing_photo" value="<?php echo $product['photo']; ?>">
        <?php endif; ?>
        <input type="file" name="photo" accept="image/*"><br>


        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
