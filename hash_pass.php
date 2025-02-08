<?php
require 'includes/config.php';

try {
    // Password yang ingin di-hash
    $password = 'abcde'; 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password di database untuk user tertentu
    $stmt = $pdo->prepare("UPDATE admin_users SET password = :password WHERE username = :username");
    $stmt->execute(['password' => $hashedPassword, 'username' => 'admin']);

    echo "Password berhasil diperbarui untuk user admin!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

