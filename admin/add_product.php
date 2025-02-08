<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <h2>Add Product Form</h2> <br />
    <form action="process_product.php" method="POST" enctype="multipart/form-data">
        <div class="p1">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" required>

            <label for="photo">Product Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Product Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="p2">
            <label for="series">Product Series:</label>
            <input type="text" id="series" name="series">

            <label for="stock">Product Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="price">Product Price:</label>
            <input type="number" id="price" name="price" required>

            <button type="submit" class="submit-btn">Submit</button>
        </div>
    </form>

</body>

<style>
    body {
        font-family: 'Poppins';
        background-color: #FFF4F4;
        justify-content: center;
        align-items: center;
    }

    h2 {
        text-align: center;
        color: #000;
        margin-bottom: 20px;
        padding-top: 10px;
        font-size: 35px;
    }

    form{
            display: flex;
        }

    .p1{
        background-color: #fff;
        padding: 30px;
        width: 400px;
        margin: 1px auto;
        margin-right: 20px;
        justify-content: space-between;
    }

    
    .p2{
        background-color: #fff;
        padding: 30px;
        width: 400px;
        margin: 1px auto;
        margin-left: 20px;
        justify-content: space-between;
    }


    label {
        display: block;
        font-size: 17px;
        font-weight: bold;
    }

    input, textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .submit-btn {
        background: #42D734;
        color: white;
        border: none;
        width: 40%;
        margin-top: 95px;
        margin-right: -15px;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        float: right;
        border: line;
        font-size: 18px;
        font-weight: bold;
    }

    .submit-btn:hover {
        background: #28a745;
    }


</style>
</html>
