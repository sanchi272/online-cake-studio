<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['submit_feedback'])) {

    $user_id = $_SESSION['user_id'];
    $feedback_message = $_POST['message'];
    $rating = $_POST['rating'];
    $status = "Pending";

    $query = "INSERT INTO feedback
              (user_id, message, rating, status)
              VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "isis",
        $user_id,
        $feedback_message,
        $rating,
        $status
    );

    if (mysqli_stmt_execute($stmt)) {

        $message = "Feedback submitted successfully!";

    } else {

        $message = "Failed to submit feedback.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Feedback - Online Cake Studio</title>

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

<a href="custom-order.php">Custom Cake</a>

<a href="feedback.php">Feedback</a>

<a href="logout.php">Logout</a>

</nav>

</header>

<main>

<section class="cakes-page">

<h2>Customer Feedback</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<label>Your Feedback:</label>

<br><br>

<textarea
name="message"
rows="5"
cols="40"
placeholder="Write your feedback..."
required></textarea>

<br><br>

<label>Rating:</label>

<br><br>

<select name="rating" required>

<option value="">Select Rating</option>

<option value="5">5 - Excellent</option>

<option value="4">4 - Very Good</option>

<option value="3">3 - Good</option>

<option value="2">2 - Average</option>

<option value="1">1 - Poor</option>

</select>

<br><br>

<button type="submit" name="submit_feedback">
Submit Feedback
</button>

</form>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>