<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Ambil data user berdasarkan username
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verifikasi password yang diinput dengan password yang di-hash di database
            if (password_verify($password, $user['password'])) {
                // Login berhasil, simpan data user ke session
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect ke halaman dashboard
                header("Location: ../admin/dashboard.php");
                exit;
            } else {
                // Password salah
                $error = "Incorrect password!";
            }
        } else {
            // User tidak ditemukan
            $error = "User not found!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <img src="../assets/images/logo.png" alt="logo" class="logo"><br>

        <form method="POST" action="">    
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

            <label>Username:</label>
            <input type="text" name="username" required><br><br>

            <label>Password:</label>
            <input type="password" name="password" required><br><br>

            <button type="submit" class="btn-login"><b>LOG IN</b></button>
        </form>
    </div>
</body>

<style> 
    body {
        font-family: 'Poppins';
        background-image: url('../assets/images/login.png');
        display: flex;
        justify-content: center;
        align-items: center;
        height: 700px;
        margin: 0;
    }
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        
    }
    .container img {
        width: 250px;
    }
    form{
        background-color: #FFF4F4;
        padding: 40px 65px;
        border-radius: 15px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
    }
    form label{
        display: block;
        text-align: left;
    }
    form input{
        width: 350px;
        justify-content: center;
        padding: 10px ;
        border: 2px solid #000;
        border-radius: 7px;
    }
    .btn-login  {
        display: inline-block;
        width: 100%;
        padding: 12px;
        background-color: #BB9991;
        color: #fff;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
    }
    .btn-login:hover {
        background-color: #E0C8C8;
        color: #000;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .container{
            width: 100px;
        }
        form {
            width: 200px;
            padding: 30px 20px;
        }
        form label{
            font-size: 12px;
        }
        form input {
            width: 170px; 
        }
        .container img {
            width: 100px; 
            margin-bottom: 15px;
        }
        .btn-login{
            padding: 10px;
            font-size: 12px;
        }
    }
</style>
</html>