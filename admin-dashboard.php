<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard - Online Cake Studio</title>

<link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

<h1>Online Cake Studio - Admin Panel</h1>

<nav>

<a href="admin-dashboard.php">Dashboard</a>

<a href="admin-cakes.php">Manage Cakes</a>

<a href="logout.php">Logout</a>

</nav>

</header>

<main>

<section class="cakes-page">

<h2>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2>

<p>Welcome to the Online Cake Studio Admin Dashboard.</p>


<div class="cake-card">

<h3>Manage Cakes</h3>

<p>Add, edit and delete cakes.</p>

<a href="admin-cakes.php">Manage Cakes</a>

</div>

<div class="cake-card">

<h3>Manage Categories</h3>

<p>Add, edit and delete cake categories.</p>

<a href="admin-categories.php">Manage Categories</a>

</div>



<div class="cake-card">

<h3>Manage Orders</h3>

<p>View customer orders and update order status.</p>

<a href="admin-orders.php">Manage Orders</a>

</div>


<div class="cake-card">

<h3>Custom Cake Requests</h3>

<p>View customer custom cake requests.</p>

<a href="admin-custom-orders.php">View Requests</a>

</div>


<div class="cake-card">

<h3>Customer Feedback</h3>

<p>View customer feedback and ratings.</p>

<a href="admin-feedback.php">View Feedback</a>

</div>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>