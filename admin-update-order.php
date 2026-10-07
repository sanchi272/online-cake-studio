<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$order_id = $_GET['id'];

$query = "SELECT * FROM orders WHERE order_id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $order_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$order = mysqli_fetch_assoc($result);

$message = "";

if (isset($_POST['update_status'])) {

    $status = $_POST['status'];

    $query = "UPDATE orders SET status = ? WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "si", $status, $order_id);

    if (mysqli_stmt_execute($stmt)) {

        $message = "Order status updated successfully!";

        $order['status'] = $status;

    } else {

        $message = "Failed to update order status.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Update Order - Online Cake Studio</title>

<link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

<h1>Online Cake Studio - Admin Panel</h1>

<nav>

<a href="admin-dashboard.php">Dashboard</a>

<a href="admin-cakes.php">Manage Cakes</a>

<a href="admin-orders.php">Manage Orders</a>

<a href="logout.php">Logout</a>

</nav>

</header>

<main>

<section class="cakes-page">

<h2>Update Order Status</h2>

<?php echo $message; ?>

<p>
<strong>Order ID:</strong>
<?php echo $order['order_id']; ?>
</p>

<p>
<strong>Total Amount:</strong>
₹<?php echo $order['total_amount']; ?>
</p>

<p>
<strong>Current Status:</strong>
<?php echo $order['status']; ?>
</p>

<form method="POST">

<label>Select Order Status:</label>

<br><br>

<select name="status" required>

<option value="Pending"
<?php echo ($order['status'] == "Pending") ? "selected" : ""; ?>>
Pending
</option>

<option value="Confirmed"
<?php echo ($order['status'] == "Confirmed") ? "selected" : ""; ?>>
Confirmed
</option>

<option value="Preparing"
<?php echo ($order['status'] == "Preparing") ? "selected" : ""; ?>>
Preparing
</option>

<option value="Out for Delivery"
<?php echo ($order['status'] == "Out for Delivery") ? "selected" : ""; ?>>
Out for Delivery
</option>

<option value="Delivered"
<?php echo ($order['status'] == "Delivered") ? "selected" : ""; ?>>
Delivered
</option>

<option value="Cancelled"
<?php echo ($order['status'] == "Cancelled") ? "selected" : ""; ?>>
Cancelled
</option>

</select>

<br><br>

<button type="submit" name="update_status">
Update Status
</button>

</form>

<br>

<a href="admin-orders.php">Back to Orders</a>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>