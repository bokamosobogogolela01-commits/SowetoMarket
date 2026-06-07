<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

include('includes/db.php');

$categories = mysqli_query(
    $conn,
    "SELECT * FROM categories"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Product</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

<h1>Add Product</h1>

<p>
Welcome,
<?php echo $_SESSION['fullname']; ?>
</p>

<hr>

<form action="save-product.php"
      method="POST"
      enctype="multipart/form-data">

    <label>Product Name</label>

    <br>

    <input type="text"
           name="name"
           required>

    <br><br>

    <label>Description</label>

    <br>

    <textarea
        name="description"
        rows="5"
        cols="40"
        required></textarea>

    <br><br>

    <label>Price</label>

    <br>

    <input type="number"
           step="0.01"
           name="price"
           required>

    <br><br>

    <label>Category</label>

    <br>

    <select name="category_id" required>

        <option value="">
            Select Category
        </option>

        <?php
        while($cat = mysqli_fetch_assoc($categories))
        {
        ?>

        <option value="<?php echo $cat['category_id']; ?>">
            <?php echo $cat['category_name']; ?>
        </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <label>Product Image</label>

    <br>

    <input type="file"
           name="image"
           required>

    <br><br>

    <button type="submit">
        Save Product
    </button>

</form>

<br>

<a href="seller-dashboard.php">
    Back to Dashboard
</a>

</body>

</html>