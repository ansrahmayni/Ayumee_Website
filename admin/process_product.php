<?php
require '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $series = $_POST['series'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Bersihkan nama series agar tidak ada karakter aneh dalam folder
    $series_folder = preg_replace('/[^A-Za-z0-9_-]/', '', $series);

    // Tentukan direktori upload berdasarkan series
    $upload_dir = "../uploads/" . $series_folder . "/";

    // Buat folder jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Upload file ke dalam folder series
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_path = $upload_dir . $photo_name;
    
    if (move_uploaded_file($photo_tmp, $photo_path)) {
        try {
            // Simpan hanya path relatif ke database
            $relative_photo_path = "uploads/" . $series_folder . "/" . $photo_name;

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
                ':photo' => $relative_photo_path // Simpan path relatif ke database
            ]);

            // Redirect ke products.php setelah berhasil
            header("Location: ../admin/products.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Gagal mengupload file.";
    }
}
?>
