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
            <li><a href="order_history.php">Riwayat</a></li>
            <li><a href="logout.php">Logout</a> </li>
        </ul>
        <?php session_start(); ?>
        <div class="cart">
            <a href="cart.php"> <img src="assets/images/Cart.png" alt="Keranjang"></a>
            <span class="cart-badge"><?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span>
        </div>
    </nav>
</body>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins';
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

.nav-links li {
    font-weight: bold;
}

.nav-links a {
    text-decoration: none;
    color: #333;
    font-size: 18px;
}

.cart {
    position: relative;
}

.cart img {
    max-height: 30px; /* Ukuran ikon keranjang */
    width: auto;
}

.cart-badge {
    position: absolute;
    top: -5px;
    right: -10px;
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .nav-links {
        display: none; /* Sembunyikan menu jika layar kecil */
    }
}

</style>
</html>