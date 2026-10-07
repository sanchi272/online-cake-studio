<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$cake_id = $_GET['id'];

$query = "DELETE FROM cakes WHERE cake_id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $cake_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin-cakes.php");
    exit();
} else {
    echo "Unable to delete this cake.";
}

?>