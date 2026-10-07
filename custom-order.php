<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['submit_request'])) {

    $user_id = $_SESSION['user_id'];
    $cake_type = $_POST['cake_type'];
    $cake_size = $_POST['cake_size'];
    $custom_message = $_POST['message'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_address = $_POST['delivery_address'];
    $status = "Pending";

    $query = "INSERT INTO custom_orders
              (user_id, cake_type, cake_size, message, delivery_date, delivery_address, status)
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "issssss",
        $user_id,
        $cake_type,
        $cake_size,
        $custom_message,
        $delivery_date,
        $delivery_address,
        $status
    );

    if (mysqli_stmt_execute($stmt)) {

        $message = "Custom cake request submitted successfully!";

    } else {

        $message = "Request submission failed. Please try again.";

    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Custom Cake Request - Online Cake Studio</title>

    <link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

    <h1>Online Cake Studio</h1>

    <nav>
        <a href="index.php">Home</a>
        <a href="cakes.php">Cakes</a>
        <a href="cart.php">Cart</a>
        <a href="my-orders.php">My Orders</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<main>

<section class="cakes-page">

    <h2>Custom Cake Request</h2>
    <?php echo $message; ?>

    <p>Create a cake according to your requirements.</p>

    <form method="POST">

        <label>Cake Type:</label><br>
        <input type="text" name="cake_type" required>

        <br><br>

        <label>Cake Size:</label><br>
        <select name="cake_size" required>

            <option value="">Select Size</option>
            <option value="1 kg">1 kg</option>
            <option value="2 kg">2 kg</option>
            <option value="3 kg">3 kg</option>
            <option value="4 kg">4 kg</option>

        </select>

        <br><br>

        <label>Custom Message:</label><br>
        <textarea name="message" rows="4" cols="40"
                  placeholder="Describe your cake requirements"></textarea>

        <br><br>

        <label>Delivery Date:</label><br>
        <input type="date" name="delivery_date" required>

        <br><br>

        <label>Delivery Address:</label><br>
        <textarea name="delivery_address" rows="4" cols="40"
                  required></textarea>

        <br><br>

        <button type="submit" name="submit_request">
            Submit Request
        </button>

    </form>

</section>

</main>

<footer>

    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>