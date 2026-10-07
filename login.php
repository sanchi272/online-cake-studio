<?php
session_start();
include "config/database.php";

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
$_SESSION['user_name'] = $user['name'];
            header("Location: checkout.php");
exit();
        } else {
            $message = "Invalid password.";
        }

    } else {
        $message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Online Cake Studio</title>

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
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>

        <section>

            <h2>Login to Your Account</h2>

            <?php if ($message != "") { ?>
                <p><?php echo $message; ?></p>
            <?php } ?>

            <form method="POST">

                <p>
                    <label>Email</label><br>
                    <input type="email" name="email" required>
                </p>

                <p>
                    <label>Password</label><br>
                    <input type="password" name="password" required>
                </p>

                <button type="submit" name="login">
                    Login
                </button>

            </form>

        </section>

    </main>

    <footer>
        <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
    </footer>

</body>

</html>