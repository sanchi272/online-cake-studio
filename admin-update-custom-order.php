<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$custom_order_id = $_GET['id'];

$query = "SELECT * FROM custom_orders WHERE custom_order_id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $custom_order_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$request = mysqli_fetch_assoc($result);

$message = "";

if (isset($_POST['update_status'])) {

    $status = $_POST['status'];

    $query = "UPDATE custom_orders
              SET status = ?
              WHERE custom_order_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "si", $status, $custom_order_id);

    if (mysqli_stmt_execute($stmt)) {

        $message = "Custom cake request status updated successfully!";

        $request['status'] = $status;

    } else {

        $message = "Failed to update request status.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Update Custom Request - Online Cake Studio</title>

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

<h2>Update Custom Cake Request</h2>

<?php echo $message; ?>

<p>
<strong>Request ID:</strong>
<?php echo $request['custom_order_id']; ?>
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
<strong>Current Status:</strong>
<?php echo $request['status']; ?>
</p>

<form method="POST">

<label>Select Request Status:</label>

<br><br>

<select name="status" required>

<option value="Pending"
<?php echo ($request['status'] == "Pending") ? "selected" : ""; ?>>
Pending
</option>

<option value="Accepted"
<?php echo ($request['status'] == "Accepted") ? "selected" : ""; ?>>
Accepted
</option>

<option value="Preparing"
<?php echo ($request['status'] == "Preparing") ? "selected" : ""; ?>>
Preparing
</option>

<option value="Ready"
<?php echo ($request['status'] == "Ready") ? "selected" : ""; ?>>
Ready
</option>

<option value="Delivered"
<?php echo ($request['status'] == "Delivered") ? "selected" : ""; ?>>
Delivered
</option>

<option value="Cancelled"
<?php echo ($request['status'] == "Cancelled") ? "selected" : ""; ?>>
Cancelled
</option>

</select>

<br><br>

<button type="submit" name="update_status">
Update Status
</button>

</form>

<br>

<a href="admin-custom-orders.php">Back to Custom Requests</a>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>
