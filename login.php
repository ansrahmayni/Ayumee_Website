<?php
session_start();
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data dari database
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="container">
        <h2>Login</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Bikin dulu dong..</a></p>
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

/* Container utama */
.container {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
}

/* Judul */
h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Form login */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

label {
    font-size: 14px;
    color: #555;
    text-align: left;
    font-weight: 500;
}

/* Input fields */
input {
    padding: 10px;
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

/* Tombol login */
button {
    background: #d77a61;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #b85c47;
}

/* Link registrasi */
p {
    font-size: 14px;
    margin-top: 12px;
}

a {
    color: #d77a61;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}


</style>
</html>
