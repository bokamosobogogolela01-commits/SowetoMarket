<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['receiver_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (sender_id, receiver_id, message)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $sender_id, $receiver_id, $message);

    if (mysqli_stmt_execute($stmt)) {
        $success = "Reply sent successfully.";
    } else {
        $error = "Error sending reply.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reply Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="inbox.php" class="navbar-brand">SowetoMarket Inbox</a>
        <a href="seller-dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h3>Reply to Message</h3>
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
                            <label class="form-label">Your Reply</label>
                            <textarea name="message"
                                      class="form-control"
                                      rows="5"
                                      required></textarea>
                        </div>

                        <button class="btn btn-primary w-100">
                            Send Reply
                        </button>

                    </form>

                    <br>

                    <a href="inbox.php" class="btn btn-secondary w-100">
                        Back to Inbox
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>