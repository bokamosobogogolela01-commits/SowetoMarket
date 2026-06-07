<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];
$seller_id = $_GET['seller_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $sql = "INSERT INTO ratings (seller_id, buyer_id, rating, review)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiis", $seller_id, $buyer_id, $rating, $review);

    if (mysqli_stmt_execute($stmt)) {
        $success = "Rating submitted successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Rate Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="products.php" class="navbar-brand">SowetoMarket</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-warning">
                    <h3>Rate Seller</h3>
                </div>

                <div class="card-body">

                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>

                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select" required>
                                <option value="">Select Rating</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea name="review" class="form-control" rows="4"></textarea>
                        </div>

                        <button class="btn btn-warning w-100">
                            Submit Rating
                        </button>

                    </form>

                    <br>

                    <a href="products.php" class="btn btn-secondary w-100">
                        Back to Products
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>