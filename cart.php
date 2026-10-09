
<?php

session_start();

include "config/database.php";

$action = $_GET['action'] ?? '';
$cake_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($cake_id && $cake_id > 0) {

    if ($action === 'add') {

        $check_query = "SELECT cake_id FROM cakes
                        WHERE cake_id = ? AND availability = 1";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "i", $cake_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) === 1) {

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$cake_id])) {
                $_SESSION['cart'][$cake_id]++;
            } else {
                $_SESSION['cart'][$cake_id] = 1;
            }
        }

    } elseif ($action === 'remove') {

        unset($_SESSION['cart'][$cake_id]);

    } elseif ($action === 'decrease') {

        if (isset($_SESSION['cart'][$cake_id])) {
            if ($_SESSION['cart'][$cake_id] > 1) {
                $_SESSION['cart'][$cake_id]--;
            } else {
                unset($_SESSION['cart'][$cake_id]);
            }
        }
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

                   $query = "SELECT * FROM cakes WHERE cake_id = ? AND availability = 1";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $cake_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$cake = mysqli_fetch_assoc($result);

if (!$cake) {
    continue;
}
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