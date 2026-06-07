<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT messages.*,
               users.full_name,
               users.email
        FROM messages
        JOIN users
        ON messages.sender_id = users.user_id
        WHERE messages.receiver_id = ?
        ORDER BY messages.sent_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html>
<head>
    <title>Inbox</title>

```
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">
```

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

```
    <a href="seller-dashboard.php"
       class="navbar-brand">
       SowetoMarket
    </a>

    <a href="logout.php"
       class="btn btn-danger btn-sm">
       Logout
    </a>

</div>
```

</nav>

<div class="container mt-5">

```
<h2 class="mb-4">
    My Inbox
</h2>

<?php if (mysqli_num_rows($result) == 0) { ?>

    <div class="alert alert-info">
        You do not have any messages yet.
    </div>

<?php } ?>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="card shadow mb-3">

        <div class="card-body">

            <h5>
                From:
                <?php echo $row['full_name']; ?>
            </h5>

            <p class="text-muted">
                Email:
                <?php echo $row['email']; ?>
                |
                Sent:
                <?php echo $row['sent_at']; ?>
            </p>

            <hr>

            <p>
                <?php echo $row['message']; ?>
            </p>

            <div class="mt-3">

                <a href="reply-message.php?receiver_id=<?php echo $row['sender_id']; ?>"
                   class="btn btn-primary btn-sm">
                   Reply
                </a>

            </div>

        </div>

    </div>

<?php } ?>
```

</div>

</body>
</html>
