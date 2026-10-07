<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$query = "SELECT feedback.*, users.name, users.email
          FROM feedback
          INNER JOIN users
          ON feedback.user_id = users.user_id
          ORDER BY feedback.feedback_id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Customer Feedback - Online Cake Studio</title>

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

<a href="admin-feedback.php">Feedback</a>

<a href="logout.php">Logout</a>

</nav>

</header>

<main>

<section class="cakes-page">

<h2>Customer Feedback</h2>

<p>View customer feedback and ratings.</p>

<?php if (mysqli_num_rows($result) > 0) { ?>

<?php while ($feedback = mysqli_fetch_assoc($result)) { ?>

<div class="cake-card">

<h3>
Feedback #<?php echo $feedback['feedback_id']; ?>
</h3>

<p>
<strong>Customer Name:</strong>
<?php echo $feedback['name']; ?>
</p>

<p>
<strong>Email:</strong>
<?php echo $feedback['email']; ?>
</p>

<p>
<strong>Feedback:</strong>
<?php echo $feedback['message']; ?>
</p>

<p>
<strong>Rating:</strong>
<?php echo $feedback['rating']; ?> / 5
</p>

<p>
<strong>Status:</strong>
<?php echo $feedback['status']; ?>
</p>

</div>

<?php } ?>

<?php } else { ?>

<p>No feedback found.</p>

<?php } ?>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>