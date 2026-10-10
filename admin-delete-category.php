
<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$category_id || $category_id < 1) {
    exit("Invalid category ID.");
}

$query = "SELECT * FROM categories WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    exit("Category not found.");
}

$message = "";

if (isset($_POST['delete_category'])) {

    $check_query = "SELECT COUNT(*) AS total
                    FROM cakes
                    WHERE category_id = ?";

    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $category_id);
    mysqli_stmt_execute($check_stmt);

    $check_result = mysqli_stmt_get_result($check_stmt);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {

        $message = "Cannot delete this category because cakes are assigned to it.";

    } else {

        $delete_query = "DELETE FROM categories WHERE category_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "i", $category_id);

        if (mysqli_stmt_execute($delete_stmt)) {
            header("Location: admin-categories.php");
            exit();
        } else {
            $message = "Unable to delete category.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Category - Online Cake Studio</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>

<body>

<header>
    <h1>Online Cake Studio - Admin Panel</h1>

    <nav>
        <a href="admin-dashboard.php">Dashboard</a>
        <a href="admin-cakes.php">Manage Cakes</a>
        <a href="admin-categories.php">Manage Categories</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <section class="cakes-page">

        <h2>Delete Category</h2>

        <?php if ($message !== "") { ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>

        <div class="cake-card">

            <p>
                Are you sure you want to delete this category?
            </p>

            <h3>
                <?php echo htmlspecialchars($category['category_name']); ?>
            </h3>

            <form method="POST">
                <button type="submit" name="delete_category">
                    Confirm Delete
                </button>
            </form>

            <p>
                <a href="admin-categories.php">Cancel and Go Back</a>
            </p>

        </div>

    </section>
</main>

<footer>
    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
</footer>

</body>
</html>
