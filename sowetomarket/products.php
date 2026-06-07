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

$search = "";
$category_id = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}

$category_sql = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_sql);

$sql = "SELECT products.*, users.full_name, categories.category_name
        FROM products
        JOIN users ON products.user_id = users.user_id
        LEFT JOIN categories ON products.category_id = categories.category_id
        WHERE 
        (
            products.product_name LIKE ?
            OR products.description LIKE ?
            OR categories.category_name LIKE ?
        )";

if ($category_id != "") {
    $sql .= " AND products.category_id = ?";
}

$sql .= " ORDER BY products.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

$search_term = "%" . $search . "%";

if ($category_id != "") {
    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $search_term,
        $search_term,
        $search_term,
        $category_id
    );
} else {
    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $search_term,
        $search_term,
        $search_term
    );
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html>
<head>
    <title>SowetoMarket - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="seller-dashboard.php" class="navbar-brand">
            SowetoMarket
        </a>

        <div>
            <a href="seller-dashboard.php" class="btn btn-outline-light btn-sm">
                Dashboard
            </a>

            <a href="post-item.php" class="btn btn-success btn-sm">
                Post Item
            </a>

            <a href="logout.php" class="btn btn-danger btn-sm">
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <div class="text-center mb-4">
        <h2>Available Products</h2>
        <p class="text-muted">
            Browse items listed by SowetoMarket users
        </p>
    </div>

    <form method="GET" class="mb-4">

        <div class="row g-2">

            <div class="col-md-6">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search products, descriptions or categories..."
                       value="<?php echo htmlspecialchars($search); ?>">
            </div>

            <div class="col-md-4">
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>

                    <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>

                        <option value="<?php echo $category['category_id']; ?>"
                            <?php if ($category_id == $category['category_id']) { echo "selected"; } ?>>
                            <?php echo $category['category_name']; ?>
                        </option>

                    <?php } ?>

                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    Search
                </button>
            </div>

        </div>

        <div class="mt-2">
            <a href="products.php" class="btn btn-secondary btn-sm">
                Reset
            </a>
        </div>

    </form>

    <div class="row g-4">

        <?php if (mysqli_num_rows($result) > 0) { ?>

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

                            <p class="text-muted">
                                <?php echo timeAgo($row['created_at']); ?>
                            </p>

                            <p>
                                <strong>Category:</strong>
                                <?php echo $row['category_name']; ?>
                            </p>

                            <p>
                                <strong>Status:</strong>

                                <?php if ($row['status'] == 'Available') { ?>
                                    <span class="badge bg-success">Available</span>
                                <?php } ?>

                                <?php if ($row['status'] == 'Reserved') { ?>
                                    <span class="badge bg-warning text-dark">Reserved</span>
                                <?php } ?>

                                <?php if ($row['status'] == 'Sold') { ?>
                                    <span class="badge bg-danger">Sold</span>
                                <?php } ?>
                            </p>

                            <p>
                                <?php echo $row['description']; ?>
                            </p>

                            <p class="text-muted">
                                Seller:
                                <?php echo $row['full_name']; ?>
                            </p>

                            <a href="product-details.php?id=<?php echo $row['product_id']; ?>"
                               class="btn btn-primary w-100">
                                View Item
                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="col-12">

                <div class="alert alert-warning text-center">
                    No products found matching your search.
                </div>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>