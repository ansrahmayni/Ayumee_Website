<?php
session_start();
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah username sudah digunakan
    $checkUser = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $checkUser->execute([$username]);

    if ($checkUser->rowCount() > 0) {
        echo "Username sudah digunakan!";
    } else {
        // Insert user baru dengan role 'user'
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        if ($stmt->execute([$username, $password])) {
            header("Location: login.php");
            exit;
        } else {
            echo "Registrasi gagal.";
        }
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
