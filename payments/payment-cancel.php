<?php

require_once __DIR__ . '/../includes/db.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $sql = "UPDATE orders
            SET status = 'Cancelled'
            WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Cancelled</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="alert alert-warning text-center shadow">
        <h2>Payment Cancelled</h2>
        <p>You cancelled the payment process.</p>

        <a href="../products.php" class="btn btn-secondary">
            Back to Products
        </a>
    </div>

</div>

</body>
</html>