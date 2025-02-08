<?php
session_start();
require '../includes/config.php';
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Fetch data pengguna dari database
$stmt = $pdo->query("SELECT id, username FROM admin_users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <h1> Halo <h1>
</body>

<style>
    body{
        margin-left: 250px;
        margin-top: 90px;
        background-color: #FFF4F4;
    }

    
</style>
</html>