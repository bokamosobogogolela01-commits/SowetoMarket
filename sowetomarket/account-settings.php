<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE users 
                   SET full_name = ?, phone = ?
                   WHERE user_id = ?";

    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssi", $full_name, $phone, $user_id);

    if (mysqli_stmt_execute($update_stmt)) {
        $_SESSION['full_name'] = $full_name;
        $success = "Account updated successfully.";

        $user['full_name'] = $full_name;
        $user['phone'] = $phone;
    } else {
        $error = "Error updating account.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="seller-dashboard.php" class="navbar-brand">SowetoMarket</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-secondary text-white">
                    <h3>Account Settings</h3>
                </div>

                <div class="card-body">

                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="full_name"
                                   class="form-control"
                                   value="<?php echo $user['full_name']; ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   class="form-control"
                                   value="<?php echo $user['email']; ?>"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="<?php echo $user['phone']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text"
                                   class="form-control"
                                   value="<?php echo $user['role']; ?>"
                                   readonly>
                        </div>

                        <button class="btn btn-secondary w-100">
                            Update Account
                        </button>

                    </form>

                    <br>

                    <a href="seller-dashboard.php" class="btn btn-primary w-100">
                        Back to Dashboard
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>