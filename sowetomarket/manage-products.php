<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    die("Access Denied");
}

$sql = "SELECT products.*, users.full_name, categories.category_name
        FROM products
        JOIN users ON products.user_id = users.user_id
        LEFT JOIN categories ON products.category_id = categories.category_id
        ORDER BY products.created_at DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="admin/admin-dashboard.php" class="navbar-brand">SowetoMarket Admin</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">

    <h2 class="mb-4">Manage Products</h2>

    <table class="table table-bordered table-striped shadow">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Category</th>
                <th>Seller</th>
                <th>Date Posted</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>
                        <img src="uploads/<?php echo $row['image']; ?>"
                             width="80">
                    </td>

                    <td>
                        <?php echo $row['product_name']; ?>
                    </td>

                    <td>
                        R<?php echo $row['price']; ?>
                    </td>

                    <td>
                        <?php echo $row['category_name']; ?>
                    </td>

                    <td>
                        <?php echo $row['full_name']; ?>
                    </td>

                    <td>
                        <?php echo $row['created_at']; ?>
                    </td>

                    <td>
                        <a href="delete-admin-product.php?id=<?php echo $row['product_id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this product?');">
                           Delete
                        </a>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>