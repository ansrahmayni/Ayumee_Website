<?php
require '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $series = $_POST['series'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Upload file
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $upload_dir = "../uploads/";
    move_uploaded_file($photo_tmp, $upload_dir . $photo_name);

    try {
        // Query Insert menggunakan PDO
        $sql = "INSERT INTO products (id, name, description, series, stock, price, photo) 
                VALUES (:id, :name, :description, :series, :stock, :price, :photo)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':series' => $series,
            ':stock' => $stock,
            ':price' => $price,
            ':photo' => $photo_name
        ]);

        // Redirect ke product.php setelah berhasil
        header("Location: ../admin/products.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
