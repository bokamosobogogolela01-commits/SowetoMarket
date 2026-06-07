<?php

session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    die("Access Denied");
}

$user_id = $_GET['id'];

if ($user_id == $_SESSION['user_id']) {
    die("You cannot delete your own admin account.");
}

$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: manage-users.php");
    exit();
} else {
    echo "Error deleting user: " . mysqli_error($conn);
}

?>