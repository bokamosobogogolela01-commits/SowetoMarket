<?php

include('includes/db.php');

$password = password_hash('admin123', PASSWORD_DEFAULT);

$sql = "INSERT INTO users
(role_id, fullname, email, password, phone)

VALUES

(1,
'Administrator',
'admin@sowetomarket.com',
'$password',
'0000000000')";

if(mysqli_query($conn, $sql))
{
    echo "Admin Created";
}
else
{
    echo mysqli_error($conn);
}

?>