<?php

session_start();
include '../includes/db.php';
/** @var mysqli $conn */

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    die("Access Denied");
}

$users_result = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$users_data = mysqli_fetch_assoc($users_result);

$products_result = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM products");
$products_data = mysqli_fetch_assoc($products_result);

$messages_result = mysqli_query($conn, "SELECT COUNT(*) AS total_messages FROM messages");
$messages_data = mysqli_fetch_assoc($messages_result);

$ratings_result = mysqli_query($conn, "SELECT COUNT(*) AS total_ratings FROM ratings");
$ratings_data = mysqli_fetch_assoc($ratings_result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">SowetoMarket Admin</span>
        <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">

    <h2 class="mb-4 text-center">Admin Dashboard</h2>

    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h2><?php echo $users_data['total_users']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Total Products</h5>
                    <h2><?php echo $products_data['total_products']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Total Messages</h5>
                    <h2><?php echo $messages_data['total_messages']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Total Ratings</h5>
                    <h2><?php echo $ratings_data['total_ratings']; ?></h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4>Manage Users</h4>
                    <p>View and delete registered users.</p>
                    <a href="../manage-users.php" class="btn btn-primary w-100">
                        View Users
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4>Manage Products</h4>
                    <p>View and delete products on the platform.</p>
                    <a href="../manage-products.php" class="btn btn-success w-100">
                        View Products
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>