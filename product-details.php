<?php

session_start();
include 'includes/db.php';

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $difference = time() - $time;

    if ($difference < 60) {
        return "Posted just now";
    } elseif ($difference < 3600) {
        return "Posted " . floor($difference / 60) . " minutes ago";
    } elseif ($difference < 86400) {
        return "Posted " . floor($difference / 3600) . " hours ago";
    } else {
        return "Posted " . floor($difference / 86400) . " days ago";
    }
}

$product_id = $_GET['id'];

$sql = "SELECT products.*, users.full_name, categories.category_name
        FROM products
        JOIN users ON products.user_id = users.user_id
        LEFT JOIN categories ON products.category_id = categories.category_id
        WHERE product_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

$seller_id = $product['user_id'];

$rating_sql = "SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews
               FROM ratings
               WHERE seller_id = ?";

$rating_stmt = mysqli_prepare($conn, $rating_sql);
mysqli_stmt_bind_param($rating_stmt, "i", $seller_id);
mysqli_stmt_execute($rating_stmt);

$rating_result = mysqli_stmt_get_result($rating_stmt);
$rating_data = mysqli_fetch_assoc($rating_result);

$average_rating = round($rating_data['average_rating'], 1);
$total_reviews = $rating_data['total_reviews'];

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['product_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="products.php" class="navbar-brand">SowetoMarket</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="card shadow">

        <div class="row g-0">

            <div class="col-md-5">
                <img src="uploads/<?php echo $product['image']; ?>"
                     class="img-fluid rounded-start"
                     style="width:100%; height:100%; object-fit:cover;">
            </div>

            <div class="col-md-7">

                <div class="card-body">

                    <h2><?php echo $product['product_name']; ?></h2>

                    <h3 class="text-success">
                        R<?php echo $product['price']; ?>
                    </h3>

                    <p class="text-muted">
                        <?php echo timeAgo($product['created_at']); ?>
                    </p>

                    <hr>

                    <p>
                        <strong>Category:</strong>
                        <?php echo $product['category_name']; ?>
                    </p>

                    <p>
                        <strong>Status:</strong>

                        <?php if ($product['status'] == 'Available') { ?>
                            <span class="badge bg-success">Available</span>
                        <?php } ?>

                        <?php if ($product['status'] == 'Reserved') { ?>
                            <span class="badge bg-warning text-dark">Reserved</span>
                        <?php } ?>

                        <?php if ($product['status'] == 'Sold') { ?>
                            <span class="badge bg-danger">Sold</span>
                        <?php } ?>
                    </p>

                    <p>
                        <strong>Seller:</strong>
                        <?php echo $product['full_name']; ?>
                    </p>

                    <p>
                        <strong>Seller Rating:</strong>

                        <?php if ($total_reviews > 0) { ?>
                            ⭐ <?php echo $average_rating; ?>/5
                            (<?php echo $total_reviews; ?> reviews)
                        <?php } else { ?>
                            No ratings yet
                        <?php } ?>
                    </p>

                    <p>
                        <strong>Description:</strong>
                    </p>

                    <p>
                        <?php echo $product['description']; ?>
                    </p>

                    <a href="messages.php?receiver_id=<?php echo $product['user_id']; ?>"
                       class="btn btn-primary">
                        Message Seller
                    </a>

                    <a href="rate-seller.php?seller_id=<?php echo $product['user_id']; ?>"
                       class="btn btn-warning">
                        Rate Seller
                    </a>

                    <a href="products.php"
                       class="btn btn-secondary">
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>