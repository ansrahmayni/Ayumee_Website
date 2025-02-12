<?php
require '../includes/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Ambil path foto dari database sebelum menghapus data
        $sql = "SELECT photo FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $photo_path = "../" . $product['photo']; // Path lengkap foto
            
            // Hapus file gambar jika ada
            if (file_exists($photo_path) && is_file($photo_path)) {
                unlink($photo_path);
            }

            // Hapus produk dari database
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            // Redirect ke halaman produk setelah sukses
            header("Location: products.php");
            exit();
        } else {
            echo "Produk tidak ditemukan.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID produk tidak diberikan.";
}
?>
