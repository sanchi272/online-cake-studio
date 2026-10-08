<?php

session_start();

include "config/database.php";

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE email = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

       if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['admin_name'];

            header("Location: admin-dashboard.php");
            exit();

        } else {

            $message = "Invalid password.";

        }

    } else {

        $message = "Admin not found.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Online Cake Studio</title>

    <link rel="stylesheet" href="assests/css/style.css">

</head>

<body>

<header>

    <h1>Online Cake Studio - Admin</h1>

</header>

<main>

<section class="cakes-page">

    <h2>Admin Login</h2>

    <?php echo $message; ?>

    <form method="POST">

        <label>Email:</label><br>

        <input type="email" name="email" required>

        <br><br>

        <label>Password:</label><br>

        <input type="password" name="password" required>

        <br><br>

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