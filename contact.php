<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - SowetoMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="index.php" class="navbar-brand">SowetoMarket</a>
        <div>
            <a href="products.php" class="btn btn-outline-light btn-sm">Products</a>
            <a href="about.php" class="btn btn-outline-light btn-sm">About</a>
            <a href="login.php" class="btn btn-success btn-sm">Login</a>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3>Contact Us</h3>
                </div>

                <div class="card-body">

                    <p>
                        Have a question about SowetoMarket? Send us a message using the form below.
                    </p>

                    <form>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5"></textarea>
                        </div>

                        <button type="button" class="btn btn-primary w-100">
                            Send Message
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>