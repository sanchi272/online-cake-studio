<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$query = "SELECT orders.*, users.name, users.email
          FROM orders
          INNER JOIN users
          ON orders.user_id = users.user_id
          ORDER BY orders.order_date DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Orders - Online Cake Studio</title>

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

<h2>Manage Orders</h2>

<p>View customer orders and update order status.</p>

<?php if (mysqli_num_rows($result) > 0) { ?>

<?php while ($order = mysqli_fetch_assoc($result)) { ?>

<div class="cake-card">

<h3>Order #<?php echo $order['order_id']; ?></h3>

<p>
<strong>Customer Name:</strong>
<?php echo $order['name']; ?>
</p>

<p>
<strong>Email:</strong>
<?php echo $order['email']; ?>
</p>

<p>
<strong>Total Amount:</strong>
₹<?php echo $order['total_amount']; ?>
</p>

<p>
<strong>Order Date:</strong>
<?php echo $order['order_date']; ?>
</p>

<p>
<strong>Delivery Date:</strong>
<?php echo $order['delivery_date']; ?>
</p>

<p>
<strong>Delivery Address:</strong>
<?php echo $order['delivery_address']; ?>
</p>

<p>
<strong>Payment Method:</strong>
<?php echo $order['payment_method']; ?>
</p>

<p>
<strong>Status:</strong>
<?php echo $order['status']; ?>
</p>

<a href="admin-update-order.php?id=<?php echo $order['order_id']; ?>">
Update Status
</a>

</div>

<?php } ?>

<?php } else { ?>

<p>No orders found.</p>

<?php } ?>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>