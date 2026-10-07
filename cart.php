<?php

session_start();

include "config/database.php";
if (isset($_GET['action']) && $_GET['action'] == 'add') {

    $cake_id = $_GET['id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$cake_id])) {
        $_SESSION['cart'][$cake_id]++;
    } else {
        $_SESSION['cart'][$cake_id] = 1;
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'remove') {

    $cake_id = $_GET['id'];

    unset($_SESSION['cart'][$cake_id]);
}
if (isset($_GET['action']) && $_GET['action'] == 'decrease') {

    $cake_id = $_GET['id'];

    if ($_SESSION['cart'][$cake_id] > 1) {
        $_SESSION['cart'][$cake_id]--;
    } else {
        unset($_SESSION['cart'][$cake_id]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart - Online Cake Studio</title>

    <link rel="stylesheet" href="assests/css/style.css">
</head>

<body>

    <header>
        <h1>Online Cake Studio</h1>

        <nav>
            <a href="index.php">Home</a>
            <a href="cakes.php">Cakes</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>

        <section class="cakes-page">

            <h2>Your Shopping Cart</h2>

            <?php
            $total = 0;
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
               
                foreach ($_SESSION['cart'] as $cake_id => $quantity) {

                    $query = "SELECT * FROM cakes WHERE cake_id = $cake_id";

                    $result = mysqli_query($conn, $query);

                    $cake = mysqli_fetch_assoc($result);
            ?>

                    <div class="cake-card">

                        <img
                            src="assests/images/<?php echo $cake['image']; ?>"
                            alt="<?php echo $cake['cake_name']; ?>"
                            width="250"
                        >

                        <h3><?php echo $cake['cake_name']; ?></h3>

                        <p>
                            <strong>Price:</strong>
                            ₹<?php echo $cake['price']; ?>
                        </p>

                        <p>
                            <strong>Quantity:</strong>
                            <?php echo $quantity; ?>
                        </p>
                       <?php
$total += $cake['price'] * $quantity;
?>
                        <a href="cart.php?action=add&id=<?php echo $cake_id; ?>">+</a>
                        <a href="cart.php?action=decrease&id=<?php echo $cake_id; ?>">-</a>
                        <a href="cart.php?action=remove&id=<?php echo $cake_id; ?>">Remove</a>

                    </div>

            <?php
                }

            } else {
            ?>

                <p>Your cart is empty.</p>

            <?php } ?>
<h3>Total Amount: ₹<?php echo $total; ?></h3>
<a href="checkout.php">Proceed to Checkout</a>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
    </footer>

</body>

</html>