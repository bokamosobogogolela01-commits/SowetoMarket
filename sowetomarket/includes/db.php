<?php

$conn = mysqli_connect("localhost", "root", "", "sowetomarket");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>