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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>

</body>



<style>
    /* Reset dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Tampilan utama */
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #fdf6f3, #fcebe5);
}

/* Container form */
.container {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Input fields */
input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

input:focus {
    border-color: #d77a61;
    box-shadow: 0px 0px 5px rgba(215, 122, 97, 0.5);
}

/* Tombol Register */
button {
    background: #d77a61;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #b85c47;
}

</style>
</html>