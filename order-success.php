<?php

session_start();

include "config/database.php";

$order_id = $_GET['id'];

$query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Successful - Online Cake Studio</title>

    <link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

    <h1>Online Cake Studio</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="cakes.php">Cakes</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<main>

<section class="cakes-page">

    <h2>Order Placed Successfully!</h2>

    <p>Thank you for ordering from Online Cake Studio.</p>

    <p>
        <strong>Order ID:</strong>
        <?php echo $order['order_id']; ?>
    </p>

    <p>
        <strong>Total Amount:</strong>
        ₹<?php echo $order['total_amount']; ?>
    </p>

    <p>
        <strong>Delivery Date:</strong>
        <?php echo $order['delivery_date']; ?>
    </p>

    <p>
        <strong>Payment Method:</strong>
        <?php echo $order['payment_method']; ?>
    </p>

    <p>
        <strong>Order Status:</strong>
        <?php echo $order['status']; ?>
    </p>

    <br>

    <a href="cakes.php" class="back-button">
        Continue Shopping
    </a>

</section>

</main>

<footer>

    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>