<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$query = "SELECT custom_orders.*, users.name, users.email
          FROM custom_orders
          INNER JOIN users
          ON custom_orders.user_id = users.user_id
          ORDER BY custom_orders.custom_order_id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Custom Cake Requests - Online Cake Studio</title>

<link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

<h1>Online Cake Studio - Admin Panel</h1>

<nav>

<a href="admin-dashboard.php">Dashboard</a>

<a href="admin-cakes.php">Manage Cakes</a>

<a href="admin-orders.php">Manage Orders</a>

<a href="admin-custom-orders.php">Custom Requests</a>

<a href="logout.php">Logout</a>

</nav>

</header>

<main>

<section class="cakes-page">

<h2>Custom Cake Requests</h2>

<p>View customer requests for customized cakes.</p>

<?php if (mysqli_num_rows($result) > 0) { ?>

<?php while ($request = mysqli_fetch_assoc($result)) { ?>

<div class="cake-card">

<h3>
Request #<?php echo $request['custom_order_id']; ?>
</h3>

<p>
<strong>Customer Name:</strong>
<?php echo $request['name']; ?>
</p>

<p>
<strong>Email:</strong>
<?php echo $request['email']; ?>
</p>

<p>
<strong>Cake Type:</strong>
<?php echo $request['cake_type']; ?>
</p>

<p>
<strong>Cake Size:</strong>
<?php echo $request['cake_size']; ?>
</p>

<p>
<strong>Custom Message:</strong>
<?php echo $request['message']; ?>
</p>

<p>
<strong>Delivery Date:</strong>
<?php echo $request['delivery_date']; ?>
</p>

<p>
<strong>Delivery Address:</strong>
<?php echo $request['delivery_address']; ?>
</p>

<p>
<strong>Status:</strong>
<?php echo $request['status']; ?>
</p>

<a href="admin-update-custom-order.php?id=<?php echo $request['custom_order_id']; ?>">
Update Status
</a>

</div>

<?php } ?>

<?php } else { ?>

<p>No custom cake requests found.</p>

<?php } ?>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>