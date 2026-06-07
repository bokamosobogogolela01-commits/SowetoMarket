<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Product</title>

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

                <div class="card-header bg-success text-white">
                    <h3>Post a New Product</h3>
                </div>

                <div class="card-body">

                    <form action="save-product.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text"
                                   name="product_name"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="4"
                                      required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>

                            <select name="category_id"
                                    class="form-select"
                                    required>

                                <option value="">Select Category</option>
                                <option value="1">Electronics</option>
                                <option value="2">Clothing</option>
                                <option value="3">Furniture</option>
                                <option value="4">Vehicles</option>
                                <option value="5">Other</option>

                            </select>
                        </div>
                        <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="Available">Available</option>
        <option value="Reserved">Reserved</option>
        <option value="Sold">Sold</option>
    </select>
</div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>

                            <input type="file"
                                   name="image"
                                   class="form-control"
                                   required>
                        </div>

                        <button class="btn btn-success w-100">
                            Post Product
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>