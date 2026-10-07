<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$query = "SELECT cakes.*, categories.category_name
          FROM cakes
          INNER JOIN categories
          ON cakes.category_id = categories.category_id";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Cakes - Online Cake Studio</title>

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

    <h2>Manage Cakes</h2>

    <p>View all cakes available in the system.</p>

    <?php while ($cake = mysqli_fetch_assoc($result)) { ?>

        <div class="cake-card">

            <img
                src="assests/images/<?php echo $cake['image']; ?>"
                alt="<?php echo $cake['cake_name']; ?>"
                width="250"
            >

            <h3>
                <?php echo $cake['cake_name']; ?>
            </h3>

            <p>
                <strong>Category:</strong>
                <?php echo $cake['category_name']; ?>
            </p>

            <p>
                <strong>Price:</strong>
                ₹<?php echo $cake['price']; ?>
            </p>

            <p>
                <strong>Availability:</strong>

                <?php
                echo ($cake['availability'] == 1)
                    ? "Available"
                    : "Not Available";
                ?>

            </p>
            <a href="admin-edit-cake.php?id=<?php echo $cake['cake_id']; ?>">
    Edit Cake
</a>
<a href="admin-delete-cake.php?id=<?php echo $cake['cake_id']; ?>"
   onclick="return confirm('Are you sure you want to delete this cake?');">
    Delete Cake
</a>
        </div>

    <?php } ?>

</section>

</main>

<footer>

    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>