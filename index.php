<?php

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

$sql = "SELECT * FROM products
        ORDER BY created_at DESC
        LIMIT 3";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>SowetoMarket</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a href="index.php" class="navbar-brand">
            SowetoMarket
        </a>

        <div>
            <a href="products.php" class="btn btn-outline-light btn-sm">
                Products
            </a>

            <a href="about.php" class="btn btn-outline-light btn-sm">
                About
            </a>

            <a href="contact.php" class="btn btn-outline-light btn-sm">
                Contact
            </a>

            <a href="login.php" class="btn btn-outline-light btn-sm">
                Login
            </a>

            <a href="register.php" class="btn btn-success btn-sm">
                Register
            </a>
        </div>

    </div>
</nav>

<div class="container mt-5">

    <div class="p-5 bg-white rounded shadow text-center">

        <h1 class="display-4">
            Welcome to SowetoMarket
        </h1>

        <p class="lead mt-3">
            A local marketplace where community members can
            buy and sell products safely and conveniently.
        </p>

        <hr>

        <a href="products.php"
           class="btn btn-primary btn-lg">
           Browse Products
        </a>

        <a href="register.php"
           class="btn btn-success btn-lg">
           Create Account
        </a>

    </div>

</div>

<div class="container mt-5">

    <h2 class="text-center mb-4">
        Featured Products
    </h2>

    <div class="row g-4">

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="col-md-4">

                <div class="card shadow h-100">

                    <img src="uploads/<?php echo $row['image']; ?>"
                         class="card-img-top"
                         style="height:220px; object-fit:cover;">

                    <div class="card-body">

                        <h5>
                            <?php echo $row['product_name']; ?>
                        </h5>

                        <p class="text-success fw-bold">
                            R<?php echo $row['price']; ?>
                        </p>

                        <p class="text-muted">
                            <?php echo timeAgo($row['created_at']); ?>
                        </p>

                        <a href="product-details.php?id=<?php echo $row['product_id']; ?>"
                           class="btn btn-primary w-100">
                           View Product
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<footer class="text-center mt-5 mb-3 text-muted">
    <p>
        &copy; 2026 SowetoMarket. All Rights Reserved.
    </p>
</footer>

</body>
</html>