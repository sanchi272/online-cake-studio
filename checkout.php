<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$total = 0;

foreach ($_SESSION['cart'] as $cake_id => $quantity) {

    $query = "SELECT * FROM cakes WHERE cake_id = $cake_id";
    $result = mysqli_query($conn, $query);
    $cake = mysqli_fetch_assoc($result);

    $total += $cake['price'] * $quantity;
}
if (isset($_POST['place_order'])) {

    $user_id = $_SESSION['user_id'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_address = $_POST['delivery_address'];
    $payment_method = $_POST['payment_method'];

    $query = "INSERT INTO orders 
              (user_id, total_amount, delivery_date, delivery_address, payment_method, status)
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    $status = "Pending";

    mysqli_stmt_bind_param(
        $stmt,
        "idssss",
        $user_id,
        $total,
        $delivery_date,
        $delivery_address,
        $payment_method,
        $status
    );

    if (mysqli_stmt_execute($stmt)) {

        $order_id = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $cake_id => $quantity) {

            $cake_query = "SELECT price FROM cakes WHERE cake_id = ?";
            $cake_stmt = mysqli_prepare($conn, $cake_query);
            mysqli_stmt_bind_param($cake_stmt, "i", $cake_id);
            mysqli_stmt_execute($cake_stmt);

            $cake_result = mysqli_stmt_get_result($cake_stmt);
            $cake = mysqli_fetch_assoc($cake_result);

            $price = $cake['price'];

            $item_query = "INSERT INTO order_items 
                           (order_id, cake_id, quantity, price)
                           VALUES (?, ?, ?, ?)";

            $item_stmt = mysqli_prepare($conn, $item_query);

            mysqli_stmt_bind_param(
                $item_stmt,
                "iiid",
                $order_id,
                $cake_id,
                $quantity,
                $price
            );

            mysqli_stmt_execute($item_stmt);
        }

        unset($_SESSION['cart']);

        header("Location: order-success.php?id=" . $order_id);
        exit();

    } else {

        echo "Order failed. Please try again.";

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Online Cake Studio</title>
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

    <h2>Checkout</h2>

    <form method="POST">

        <label>Delivery Date:</label><br>
        <input type="date" name="delivery_date" required>
        <br><br>

        <label>Delivery Address:</label><br>
        <textarea name="delivery_address" rows="4" cols="40" required></textarea>
        <br><br>

        <label>Payment Method:</label><br>

        <select name="payment_method" required>
            <option value="">Select Payment Method</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Online Payment">Online Payment</option>
        </select>

        <br><br>

        <h3>Total Amount: ₹<?php echo $total; ?></h3>

        <button type="submit" name="place_order">
            Place Order
        </button>

    </form>

</section>

</main>

<footer>
    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
</footer>

</body>
</html>