<?php

session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];
$status = $_POST['status'];

$image_name = $_FILES['image']['name'];
$temp_name = $_FILES['image']['tmp_name'];

move_uploaded_file(
    $temp_name,
    "uploads/" . $image_name
);

$sql = "INSERT INTO products
(user_id, category_id, product_name, description, price, image, status)
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iissdss",
    $user_id,
    $category_id,
    $product_name,
    $description,
    $price,
    $image_name,
    $status
);

if (mysqli_stmt_execute($stmt)) {
    echo "Product Posted Successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

?>