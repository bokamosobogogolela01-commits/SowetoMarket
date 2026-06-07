<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Total Products */
$product_sql = "SELECT COUNT(*) AS total_products
                FROM products
                WHERE user_id = ?";

$product_stmt = mysqli_prepare($conn, $product_sql);
mysqli_stmt_bind_param($product_stmt, "i", $user_id);
mysqli_stmt_execute($product_stmt);

$product_result = mysqli_stmt_get_result($product_stmt);
$product_data = mysqli_fetch_assoc($product_result);

/* Total Messages */
$message_sql = "SELECT COUNT(*) AS total_messages
                FROM messages
                WHERE receiver_id = ?";

$message_stmt = mysqli_prepare($conn, $message_sql);
mysqli_stmt_bind_param($message_stmt, "i", $user_id);
mysqli_stmt_execute($message_stmt);

$message_result = mysqli_stmt_get_result($message_stmt);
$message_data = mysqli_fetch_assoc($message_result);

/* Average Rating */
$rating_sql = "SELECT AVG(rating) AS average_rating
               FROM ratings
               WHERE seller_id = ?";

$rating_stmt = mysqli_prepare($conn, $rating_sql);
mysqli_stmt_bind_param($rating_stmt, "i", $user_id);
mysqli_stmt_execute($rating_stmt);

$rating_result = mysqli_stmt_get_result($rating_stmt);
$rating_data = mysqli_fetch_assoc($rating_result);

$average_rating = round($rating_data['average_rating'], 1);

?>

<!DOCTYPE html>

<html>
<head>
    <title>SowetoMarket - Dashboard</title>

```
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
```

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">SowetoMarket</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">

```
<div class="text-center mb-4">
    <h2>Welcome, <?php echo $_SESSION['full_name']; ?></h2>
    <p class="text-muted">
        You are logged in as:
        <?php echo $_SESSION['role']; ?>
    </p>
</div>

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5>My Products</h5>
                <h2><?php echo $product_data['total_products']; ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5>Messages Received</h5>
                <h2><?php echo $message_data['total_messages']; ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5>Average Rating</h5>
                <h2>
                    <?php
                    if ($average_rating > 0) {
                        echo $average_rating . "/5";
                    } else {
                        echo "No Ratings";
                    }
                    ?>
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <h4>Post New Item</h4>
                <p>Add a product you want to sell.</p>
                <a href="post-item.php"
                   class="btn btn-success w-100">
                   Post Item
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <h4>My Listings</h4>
                <p>View, edit and delete products.</p>
                <a href="my-listings.php"
                   class="btn btn-primary w-100">
                   My Listings
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <h4>Browse Products</h4>
                <p>See products from other users.</p>
                <a href="products.php"
                   class="btn btn-warning w-100">
                   Browse Products
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <h4>Inbox</h4>
                <p>View messages from buyers.</p>
                <a href="inbox.php"
                   class="btn btn-info w-100">
                   Open Inbox
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <h4>Account Settings</h4>
                <p>Update your profile information.</p>
                <a href="account-settings.php"
                   class="btn btn-secondary w-100">
                   Account Settings
                </a>
            </div>
        </div>
    </div>

</div>
```

</div>

</body>
</html>
