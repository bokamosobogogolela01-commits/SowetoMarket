<!DOCTYPE html>
<html>
<head>
    <title>SowetoMarket - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center bg-success text-white">
                    <h3>Create Account</h3>
                </div>

                <div class="card-body">

                    <form action="save-user.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="full_name"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Register
                        </button>

                    </form>

                    <hr>

                    <a href="login.php" class="btn btn-primary w-100">
                        Already Have An Account? Login
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>