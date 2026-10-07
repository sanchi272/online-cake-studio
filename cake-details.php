<?php
include "config/database.php";

$cake_id = $_GET['id'];

$cake = mysqli_query($conn, "SELECT cakes.*, categories.category_name FROM cakes INNER JOIN categories ON cakes.category_id = categories.category_id WHERE cakes.cake_id = $cake_id AND cakes.availability = 1");

$cake_data = mysqli_fetch_assoc($cake);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cake_data['cake_name']; ?> - Online Cake Studio</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>

<body>

    <header>
        <h1>Online Cake Studio</h1>

        <nav>
            <a href="index.php">Home</a>
            <a href="#">Cakes</a>
            <a href="#">About Us</a>
            <a href="#">Contact</a>
            <a href="#">Login</a>
        </nav>
    </header>

    <main>

        <section class="cake-details">

    <div class="cake-image">
        <img 
            src="assests/images/<?php echo $cake_data['image']; ?>" 
            alt="<?php echo $cake_data['cake_name']; ?>"
        >
    </div>

    <div class="cake-info">

        <h2><?php echo $cake_data['cake_name']; ?></h2>

        <p>
            <strong>Category:</strong>
            <?php echo $cake_data['category_name']; ?>
        </p>

        <p class="cake-description">
            <?php echo $cake_data['description']; ?>
        </p>

        <p class="cake-price">
            ₹<?php echo $cake_data['price']; ?>
        </p>

        <p class="cake-availability">
            <?php echo ($cake_data['availability'] == 1) ? "Available" : "Not Available"; ?>
        </p>
<a href="cart.php?action=add&id=<?php echo $cake_data['cake_id']; ?>" class="back-button">Add to Cart</a>
        <a href="index.php" class="back-button">Back to Cakes</a>

    </div>

</section>

    </main>

    <footer>
        <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
    </footer>

</body>
</html>