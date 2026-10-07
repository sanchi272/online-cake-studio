<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Orders - Online Cake Studio</title>

    <link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

    <h1>Online Cake Studio</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="cakes.php">Cakes</a>
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<main>

<section class="cakes-page">

    <h2>My Orders</h2>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($order = mysqli_fetch_assoc($result)) { ?>

            <div class="cake-card">

                <h3>
                    Order #<?php echo $order['order_id']; ?>
                </h3>

                <p>
                    <strong>Order Date:</strong>
                    <?php echo $order['order_date']; ?>
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
                    <strong>Status:</strong>
                    <?php echo $order['status']; ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p>You have not placed any orders yet.</p>

    <?php } ?>

</section>

</main>

<footer>

    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>