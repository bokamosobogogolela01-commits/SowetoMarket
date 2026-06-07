<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

$sql = "DELETE FROM products 
        WHERE product_id = ? 
        AND user_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: my-listings.php");
    exit();
} else {
    echo "Error deleting product: " . mysqli_error($conn);
}

?>