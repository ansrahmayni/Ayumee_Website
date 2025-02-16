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

    // Menangani upload file
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];

    // Pastikan ada file yang diupload
    if (!empty($photo_name)) {
        $file_path = $upload_dir . $photo_name;
        
        if (move_uploaded_file($photo_tmp, $file_path)) {
            $photo_name_db = $photo_name; // Simpan hanya nama file di database
        } else {
            echo "Gagal mengunggah foto.";
            exit();
        }
    } else {
        $photo_name_db = ""; // Jika tidak ada file diupload
    }

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
            ':photo' => $photo_name_db // Simpan hanya nama file
        ]);

        // Redirect ke halaman produk setelah sukses
        header("Location: ../admin/products.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
