<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Document</title>
</head>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil nama file dari URL
        let currentPage = window.location.pathname.split("/").pop();

        // Cek halaman dan tambahkan class "active"
        if (currentPage === "dashboard.php") {
            document.getElementById("dashboard").classList.add("active");
        } else if (currentPage === "products.php") {
            document.getElementById("product").classList.add("active");
        }
    });
</script>


<body>
    <div class="sidebar">
        <h2>☰  Administrator</h2>
        <ul>
            <li><a href="dashboard.php" class="menu_item" id="dashboard">Home</a></li>
            <li><a href="products.php" class="menu_item" id="product">Product</a></li>
        </ul> 
        <br /><br /><br /><br /><br />  
        <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        
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
        height: 100vh; /* Pastikan sidebar memenuhi tinggi layar */
        background-color: #E0C8C8; /* Warna soft pink */
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        display: flex;
        flex-direction: column; /* Agar elemen tersusun vertikal */
    }

    .sidebar ul {
        flex-grow: 0.9; /* Mendorong logout ke bawah */
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


    .menu_item {
    text-decoration: none;
    background-color: #E0C8C8;
    padding: 15px 25%;
    color: white;
    font-size: 19px;
    display: block;
    text-align: center;
    font-weight: bold;
}

.menu_item.active {
    background-color: #975B5B !important;
    color: white;
}

    .logout {
        color: white;
        background-color: red;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
        margin: 20px;
        text-align: center;
        padding: 10px 0;
        border-radius: 10px;
    }
    
    .logout:hover{
        color: red;
        background-color: black;
    }
  
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