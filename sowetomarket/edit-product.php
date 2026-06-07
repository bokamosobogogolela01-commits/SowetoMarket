<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

$sql = "SELECT * FROM products WHERE product_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found or you do not own this product.";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="seller-dashboard.php" class="navbar-brand">SowetoMarket</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header bg-warning">
                    <h3>Edit Product</h3>
                </div>

                <div class="card-body">

                    <form action="update-product.php" method="POST">

                        <input type="hidden"
                               name="product_id"
                               value="<?php echo $product['product_id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text"
                                   name="product_name"
                                   class="form-control"
                                   value="<?php echo $product['product_name']; ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="4"
                                      required><?php echo $product['description']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control"
                                   value="<?php echo $product['price']; ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status"
                                    class="form-select">

                                <option value="Available"
                                    <?php if ($product['status'] == 'Available') echo 'selected'; ?>>
                                    Available
                                </option>

                                <option value="Reserved"
                                    <?php if ($product['status'] == 'Reserved') echo 'selected'; ?>>
                                    Reserved
                                </option>

                                <option value="Sold"
                                    <?php if ($product['status'] == 'Sold') echo 'selected'; ?>>
                                    Sold
                                </option>

                            </select>

                        </div>

                        <button class="btn btn-warning w-100">
                            Update Product
                        </button>

                    </form>

                    <br>

                    <a href="my-listings.php"
                       class="btn btn-secondary w-100">
                        Back to My Listings
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>