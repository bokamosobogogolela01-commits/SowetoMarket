<!DOCTYPE html>
<html>
<head>
    <title>SowetoMarket - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card">

                <div class="card-header text-center">
                    <h3>SowetoMarket Login</h3>
                </div>

                <div class="card-body">

                    <form action="check-login.php" method="POST">

                        <label>Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               required>

                        <br>

                        <label>Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>

                        <br>

                        <button class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                    <br>

                    <a href="register.php" class="btn btn-success w-100">
                        Create Account
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>