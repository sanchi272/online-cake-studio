<?php
include "config/database.php";

$message = "";

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password, phone, address)
              VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $name,
        $email,
        $hashed_password,
        $phone,
        $address
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Registration successful!";
    } else {
        $message = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - Online Cake Studio</title>

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
            <a href="register.php">Register</a>
            <a href="#">Login</a>
        </nav>
    </header>

    <main>

        <section>
            <h2>Create Your Account</h2>

            <?php if ($message != "") { ?>
                <p><?php echo $message; ?></p>
            <?php } ?>

            <form method="POST">

                <p>
                    <label>Name</label><br>
                    <input type="text" name="name" required>
                </p>

                <p>
                    <label>Email</label><br>
                    <input type="email" name="email" required>
                </p>

                <p>
                    <label>Password</label><br>
                    <input type="password" name="password" required>
                </p>

                <p>
                    <label>Phone</label><br>
                    <input type="text" name="phone" required>
                </p>

                <p>
                    <label>Address</label><br>
                    <textarea name="address" rows="4" required></textarea>
                </p>

                <button type="submit" name="register">
                    Register
                </button>

            </form>

        </section>

    </main>

    <footer>
        <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
    </footer>

</body>
</html>