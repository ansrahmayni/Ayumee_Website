<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="sidebar">
        <h2>☰  Administrator</h2>
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="orders.php">Order</a></li>
            <li><a href="products.php">Product</a></li>
        </ul> 
        <br /><br /><br /><br /><br />  
        <a href="logout.php" class="logout">‎‎‎‎‎‎‎‎‎‎⬅️Logout</a>
    </div>

    <!-- Navbar -->
    <div class="navbar">
        
    </div>
</body>

<Style>
    *{
        font-family: 'Poppins';
    }

    .sidebar {
        width: 220px;
        height: 100%;
        background-color: #E0C8C8; /* Warna soft pink */
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
    }

    .sidebar h2{
        background-color: #E0C8C8;
        font-size: 20px;
        margin-left: 20px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        padding: 55px 20px;
        color: #fff;
        background-color: #E0C8C8;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
    }

    .sidebar ul a{
        text-decoration: none;
        background-color: #E0C8C8;
        padding: 45px 25%;
        color: white;
        font-size: 19px;
    }

    .sidebar a:hover{
        color: #975B5B;
    }

    .logout{
        color: red;
        margin-left: 60px;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
    }

    /* Navbar */
    .navbar {
        height: 75px;
        width: calc(100% - 220px);
        background-color: #E0C8C8;
        position: fixed;
        top: 0;
        left: 220px;
    
}


</style>
</html>