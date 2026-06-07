<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$status = $_POST['status'];

$sql = "UPDATE products
        SET product_name = ?, description = ?, price = ?, status = ?
        WHERE product_id = ? AND user_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssdsii",
    $product_name,
    $description,
    $price,
    $status,
    $product_id,
    $user_id
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: my-listings.php");
    exit();
} else {
    echo "Error updating product: " . mysqli_error($conn);
}

?>