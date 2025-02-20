<?php
require 'includes/config.php';
require 'includes/header.php';

session_start();

$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped_products = [];
foreach ($products as $product) {
    $grouped_products[$product['series']][] = $product;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <section class="home" id="home">
        <div class="core">
            <img src="assets/images/logo.png">
            <p>Siap membantu kulit mu menjadi lebih Ayu</p>
        </div>
    </section>
    
    <section class="about" id="about">
        <div class="overlay">
            <img src="assets/images/logo.png">
            <p>Ayumee hadir untuk membantu merawat dan mempercantik kulit Anda. Kami siap membantu kulitmu menjadi lebih Ayu, Ayumee menghadirkan produk perawatan kulit berkualitas, berbahan alami, dan aman untuk semua jenis kulit.</p><br />

            <p>Setiap produk Ayumee diformulasikan dengan teknologi inovatif untuk memberikan hasil optimal. Kami berkomitmen menghadirkan perawatan yang aman, efektif, dan terpercaya, agar kulit sehat dan bercahaya bukan sekadar impian.</p><br />

            <p>Rasakan manfaat perawatan terbaik bersama Ayumee dan tampil lebih percaya diri setiap hari!</p>
        </div>
    </section>

    <section class="product" id="product">
        <div class="container">
            <?php if (!empty($grouped_products['Pink'])) : ?>
                <h4 class="pink-title">Brightening Series:</h4>
                <br />
                <div class="series-container">
                    <?php foreach ($grouped_products['Pink'] as $product) : ?>
                        <a href="product-detail.php?id=<?= htmlspecialchars($product['id']); ?>" class="card-link">
                            <div class="card">
                                <img src="uploads/Pink/<?= htmlspecialchars($product['photo']); ?>" width="100" alt="Product Photo">
                                <h3 class="pink"><?= htmlspecialchars($product['name']); ?></h3>
                                <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($grouped_products['Green'])) : ?>
                <h4 class="green-title">Acne Care Series:</h4>
                <div class="series-container">
                    <?php foreach ($grouped_products['Green'] as $product) : ?>
                        <a href="product-detail.php?id=<?= htmlspecialchars($product['id']); ?>" class="card-link">
                            <div class="card">
                                <img src="uploads/Green/<?= htmlspecialchars($product['photo']); ?>" width="100" alt="Product Photo">
                                <h3 class="green"><?= htmlspecialchars($product['name']); ?></h3>
                                <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($grouped_products['Purple'])) : ?>
                <h4 class="purple-title">Anti Aging Series:</h4>
                <div class="series-container">
                    <?php foreach ($grouped_products['Purple'] as $product) : ?>
                        <a href="product-detail.php?id=<?= htmlspecialchars($product['id']); ?>" class="card-link">
                            <div class="card">
                                <img src="uploads/Purple/<?= htmlspecialchars($product['photo']); ?>" width="100" alt="Product Photo">
                                <h3 class="purple"><?= htmlspecialchars($product['name']); ?></h3>
                                <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="product2" id="product2"></section>

    <footer class="footer">
        <p>&copy; 2025 | Lavie Nies</p>
    </footer>

</body>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

    
    body{
        font-family: 'Rammetto One', cursive;
        justify-content: center;
        align-items: center;
        background-color: #CEC5C5;
    }

    .home{
        background-image: url(assets/images/bg.png);
        background-repeat: no-repeat;
        width: 100%;
        height: 800px;
        display: block;
        background-size: cover;
        background-position: center;
        text-align: center;
    }

    .core img{
        margin-top: 150px;
        margin-bottom: 30px;
    }

    .core p{
        color: #791818;
        font-size: 22px;
    }

    .about{
        background-image: url(assets/images/bg2.png);
        background-repeat: no-repeat;
        width: 100%;
        height: 800px;
        display: block;
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .overlay {
        position: absolute;
        text-align: center;
        color: #791818;
        font-size: 16px;
        margin-top: 130px;
        padding: 20px;
        border-radius: 10px;
    }

    .overlay img{
        width: 250px;
        margin-bottom: 35px;
    }

    .overlay p{
        padding-top: 20px;
        margin-left: 50px;
        margin-right: 50px;
        
    }

    .product{
        background-image: url(assets/images/bg3.png);
        background-repeat: no-repeat;
        width: 100%;
        height: 800px;
        background-size: cover;
        background-position: center;
        justify-content: center;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .pink-title{
        color: #590D0D;
        margin-right: 80%;
    }

    .green-title{
        color: #0D5918;     
        margin-top: 20px;
        margin-right: 85%;
    }

    .purple-title{
        color:rgb(89, 13, 88);     
        margin-top: 20px;
        margin-right: 85%;
    }

    .container {
        position: absolute;
        gap: 30px;
        justify-content: center;
        margin-top: 90px;
        margin-left: 40px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        margin-bottom: 10px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .series-container{
        display: flex;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        flex-wrap: wrap;
        justify-content: center;
    }

    .card {
        background: white;
        border-radius: 10px;
        width: 230px;
        padding: 15px;
        border: 1px solid #000;
        background-color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        margin-right: 50px;
        justify-content: center;
    }

    .card:hover{
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .card img {
        width: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    .card-link{
        text-decoration: none;

    }

    .pink{
        color: #BB9991;
    }

    .green{
        color: #91BBAB;
    }

    .purple{
        color:rgb(180, 145, 187);
    }

    .card h3 {
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 30px;
    }

    .card .price {
        font-size: 14px;
        color: red;
        font-weight: 900;
    }

    .product2{
        background-image: url(assets/images/bg4.png);
        background-repeat: no-repeat;
        width: 100%;
        height: 800px;
        display: block;
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .footer {
        background: rgba(121, 24, 24, 0.79); /* Gradasi warna coklat */
        color: white;
        text-align: center;
        padding: 20px 0;
        font-weight: bold;
        font-size: 14px;
        width: 100%;
        font-family: 'Poppins';
        bottom: 0;
    }

</style>
</html>