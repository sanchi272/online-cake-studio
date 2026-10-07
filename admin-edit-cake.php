<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$cake_id = $_GET['id'];

$query = "SELECT * FROM cakes WHERE cake_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $cake_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$cake = mysqli_fetch_assoc($result);

$categories = mysqli_query($conn, "SELECT * FROM categories");

$message = "";

if (isset($_POST['update_cake'])) {

    $cake_name = $_POST['cake_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $availability = $_POST['availability'];

    $query = "UPDATE cakes
              SET cake_name = ?,
                  category_id = ?,
                  description = ?,
                  price = ?,
                  image = ?,
                  availability = ?
              WHERE cake_id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sisdsii",
        $cake_name,
        $category_id,
        $description,
        $price,
        $image,
        $availability,
        $cake_id
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Cake updated successfully!";

        $query = "SELECT * FROM cakes WHERE cake_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $cake_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $cake = mysqli_fetch_assoc($result);
    } else {
        $message = "Failed to update cake.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Cake - Online Cake Studio</title>

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

<h2>Edit Cake</h2>

<?php echo $message; ?>

<form method="POST">

<label>Cake Name:</label><br>

<input type="text"
       name="cake_name"
       value="<?php echo $cake['cake_name']; ?>"
       required>

<br><br>

<label>Category:</label><br>

<select name="category_id" required>

<?php while ($category = mysqli_fetch_assoc($categories)) { ?>

<option value="<?php echo $category['category_id']; ?>"
<?php echo ($category['category_id'] == $cake['category_id']) ? "selected" : ""; ?>>

<?php echo $category['category_name']; ?>

</option>

<?php } ?>

</select>

<br><br>

<label>Description:</label><br>

<textarea name="description"
          rows="5"
          cols="40"
          required><?php echo $cake['description']; ?></textarea>

<br><br>

<label>Price:</label><br>

<input type="number"
       name="price"
       step="0.01"
       value="<?php echo $cake['price']; ?>"
       required>

<br><br>

<label>Image File Name:</label><br>

<input type="text"
       name="image"
       value="<?php echo $cake['image']; ?>"
       required>

<br><br>

<label>Availability:</label><br>

<select name="availability" required>

<option value="1"
<?php echo ($cake['availability'] == 1) ? "selected" : ""; ?>>
Available
</option>

<option value="0"
<?php echo ($cake['availability'] == 0) ? "selected" : ""; ?>>
Not Available
</option>

</select>

<br><br>

<button type="submit" name="update_cake">
Update Cake
</button>

</form>

</section>

</main>

<footer>

<p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>

</footer>

</body>

</html>