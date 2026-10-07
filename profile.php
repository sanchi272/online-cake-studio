<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE user_id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

$message = "";

if (isset($_POST['update_profile'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "UPDATE users
              SET name = ?, phone = ?, address = ?
              WHERE user_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $name,
        $phone,
        $address,
        $user_id
    );

    if (mysqli_stmt_execute($stmt)) {

        $message = "Profile updated successfully!";

        $user['name'] = $name;
        $user['phone'] = $phone;
        $user['address'] = $address;

        $_SESSION['user_name'] = $name;

    } else {

        $message = "Failed to update profile.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile - Online Cake Studio</title>

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

<a href="profile.php">Profile</a>

<a href="logout.php">Logout</a>

</nav>

</header>

<main>

<section class="cakes-page">

<h2>My Profile</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<label>Name:</label>

<br><br>

<input
type="text"
name="name"
value="<?php echo $user['name']; ?>"
required>

<br><br>

<label>Email:</label>

<br><br>

<input
type="email"
value="<?php echo $user['email']; ?>"
readonly>

<br><br>

<label>Phone:</label>

<br><br>

<input
type="text"
name="phone"
value="<?php echo $user['phone']; ?>"
required>

<br><br>

<label>Address:</label>

<br><br>

<textarea
name="address"
rows="4"
cols="40"
required><?php echo $user['address']; ?></textarea>

<br><br>

<button type="submit" name="update_profile">
Update Profile
</button>

</form>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>