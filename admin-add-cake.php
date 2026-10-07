<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$categories = mysqli_query($conn, "SELECT * FROM categories");

$message = "";

if (isset($_POST['add_cake'])) {

    $cake_name = $_POST['cake_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $availability = $_POST['availability'];

    $query = "INSERT INTO cakes
              (cake_name, category_id, description, price, image, availability)
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sisdsi",
        $cake_name,
        $category_id,
        $description,
        $price,
        $image,
        $availability
    );

    if (mysqli_stmt_execute($stmt)) {

        $message = "Cake added successfully!";

    } else {

        $message = "Failed to add cake.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Cake - Online Cake Studio</title>

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

    <h2>Add New Cake</h2>

    <?php echo $message; ?>

    <form method="POST">

        <label>Cake Name:</label><br>

        <input type="text" name="cake_name" required>

        <br><br>

        <label>Category:</label><br>

        <select name="category_id" required>

            <option value="">Select Category</option>

            <?php while ($category = mysqli_fetch_assoc($categories)) { ?>

                <option value="<?php echo $category['category_id']; ?>">

                    <?php echo $category['category_name']; ?>

                </option>

            <?php } ?>

        </select>

        <br><br>

        <label>Description:</label><br>

        <textarea name="description" rows="5" cols="40" required></textarea>

        <br><br>

        <label>Price:</label><br>

        <input type="number" name="price" step="0.01" required>

        <br><br>

        <label>Image File Name:</label><br>

        <input type="text" name="image" placeholder="example.jpg" required>

        <br><br>

        <label>Availability:</label><br>

        <select name="availability" required>

            <option value="1">Available</option>

            <option value="0">Not Available</option>

        </select>

        <br><br>

        <button type="submit" name="add_cake">
            Add Cake
        </button>

    </form>

</section>

</main>

<footer>

    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>