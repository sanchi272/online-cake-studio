<?php
include "config/database.php";
?>
<?php
$cakes = mysqli_query($conn, "SELECT * FROM cakes WHERE availability = 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Cake Studio</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>

<body>

    <header>
        <h1>Online Cake Studio</h1>

        <nav>
            <a href="index.php">Home</a>
            <a href="index.php">Cakes</a>
            <a href="cakes.php">All Cakes</a>
<a href="profile.php">Profile</a>
<a href="my-orders.php">My Orders</a>
            <a href="about.php">About Us</a>
<a href="contact.php">Contact</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>

        <section>
            <h2>Fresh Cakes for Every Celebration</h2>
            <p>
                Order delicious and beautiful cakes online for birthdays,
                weddings and special occasions.
            </p>

            <a href="#cakes">View Cakes</a>
        </section>

       <section id="cakes">
    <h2>Our Cakes</h2>

    <?php while ($cake = mysqli_fetch_assoc($cakes)) { ?>

        <div>
            <img src="assests/images/<?php echo $cake['image']; ?>" alt="<?php echo $cake['cake_name']; ?>" width="250">
            <h3><?php echo $cake['cake_name']; ?></h3>

            <p><?php echo $cake['description']; ?></p>

            <p>Price: ₹<?php echo $cake['price']; ?></p>
            <a href="cake-details.php?id=<?php echo $cake['cake_id']; ?>">View Details</a>
        </div>

    <?php } ?>

</section>

    </main>

    <footer>
        <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
    </footer>

</body>
</html>
