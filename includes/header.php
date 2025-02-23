<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".add-to-cart").addEventListener("click", function () {
        let quantity = parseInt(document.getElementById("quantity").value);
        let productId = <?= json_encode($product['id']); ?>;

        fetch("add_to_cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },      
            body: JSON.stringify({ id: productId, quantity: quantity }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("cart-badge").textContent = data.total_items;
            } else {
                alert("Gagal menambahkan ke keranjang");
            }
        });
    });
});

</script>

<body>
    <nav class="navbar">
        <a href="index.php#home" class="logo">
            <img src="assets/images/logo.png" alt="Ayumee Logo">
        </a>
        <ul class="nav-links">
            <li><a href="index.php#about">Tentang Kami</a></li>
            <li><a href="index.php#product">Produk</a></li>
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                // Jika user sudah login, tampilkan tombol logout
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                // Jika belum login, tampilkan tombol login
            }
            ?>

        </ul>
        <form action="search.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Cari produk..." required>
            <button type="submit">Search</button>
        </form>

        <div class="cart">
            <a href="cart.php"> <img src="assets/images/Cart.png" alt="Keranjang"></a>
        </div>
    </nav>
</body>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

nav{
    z-index: 100000;
    position: fixed; /* Tetap di atas saat scroll */
    left: 0;
    padding: 10px 20px;
    z-index: 1000; /* Biar selalu di atas */
    transition: background 0.3s ease-in-out;

}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #FCEBE5; /* Warna latar navbar */
    padding: 10px 20px;
    height: 80px; /* Sesuaikan tinggi navbar */
    width: 100%;
}

.logo img {
    max-height: 55px; /* Atur tinggi logo agar tidak terlalu besar */
    width: auto;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 100px;
}

.nav-links a {
    text-decoration: none;
    color: #333;
    font-size: 15px;
    font-family: 'Rammetto One';
}

.cart {
    position: relative;
}

.cart img {
    max-height: 40px; /* Ukuran ikon keranjang */
    width: auto;
}

.cart-badge {
    position: absolute;
    font-family: 'Poppins';
    top: -5px;
    right: -10px;
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 1px 6px;
    border-radius: 50%;
}

.search-form {
    display: flex;
    align-items: center;
    gap: 10px;
}

.search-form input {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.search-form button {
    padding: 5px 10px;
    background-color: #791818;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.search-form button:hover {
    background-color: #590D0D;
}

</style>
</html>