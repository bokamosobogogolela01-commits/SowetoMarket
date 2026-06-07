<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT products.*, categories.category_name
        FROM products
        LEFT JOIN categories ON products.category_id = categories.category_id
        WHERE products.user_id = ?
        ORDER BY products.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Listings</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="seller-dashboard.php" class="navbar-brand">SowetoMarket</a>

        <div>
            <a href="post-item.php" class="btn btn-success btn-sm">Post Item</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <div class="text-center mb-4">
        <h2>My Listings</h2>
        <p class="text-muted">Manage your products</p>
    </div>

    <div class="row g-4">

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="col-md-4">

                <div class="card shadow h-100">

                    <img src="uploads/<?php echo $row['image']; ?>"
                         class="card-img-top"
                         style="height:220px; object-fit:cover;">

                    <div class="card-body">

                        <h5 class="card-title">
                            <?php echo $row['product_name']; ?>
                        </h5>

                        <p class="text-success fw-bold">
                            R<?php echo $row['price']; ?>
                        </p>

                        <p>
                            <strong>Category:</strong>
                            <?php echo $row['category_name']; ?>
                        </p>

                        <p>
                            <?php echo $row['description']; ?>
                        </p>

                    </div>

                    <div class="card-footer">

                        <a href="product-details.php?id=<?php echo $row['product_id']; ?>"
                           class="btn btn-primary btn-sm">
                            View
                        </a>

                        <a href="edit-product.php?id=<?php echo $row['product_id']; ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="delete-product.php?id=<?php echo $row['product_id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this product?');">
                            Delete
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>