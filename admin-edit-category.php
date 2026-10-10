
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

$message = "";

$query = "SELECT * FROM categories WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    exit("Category not found.");
}


if (isset($_POST['update_category'])) {

    $category_name = trim($_POST['category_name']);

    $description = trim($_POST['description']);

    if ($category_name === "") {
        $message = "Please enter a category name.";
    } else {

        $check_query = "SELECT category_id FROM categories
                        WHERE category_name = ? AND category_id != ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param(
            $check_stmt,
            "si",
            $category_name,
            $category_id
        );
        mysqli_stmt_execute($check_stmt);

        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $message = "This category name already exists.";
        } else {

            $update_query = "UPDATE categories
                             SET category_name = ?, description = ?
                             WHERE category_id = ?";

            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param(
                $update_stmt,
                "ssi",
                $category_name,
                $description,
                $category_id
            );

            if (mysqli_stmt_execute($update_stmt)) {
                header("Location: admin-categories.php");
                exit();
            } else {
                $message = "Unable to update category.";
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
    <title>Edit Category - Online Cake Studio</title>
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

        <h2>Edit Category</h2>

        <?php if ($message !== "") { ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>

        <div class="cake-card">

            <form method="POST">

                <label>Category Name:</label><br>
                <input
                    type="text"
                    name="category_name"
                    value="<?php echo htmlspecialchars($category['category_name']); ?>"
                    required
                >
                <br><br>

                <label>Description:</label><br>
                <textarea name="description" rows="4" required><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
                <br><br>

                <button type="submit" name="update_category">
                    Update Category
                </button>

            </form>

        </div>

        <p><a href="admin-categories.php">Back to Categories</a></p>

    </section>
</main>

<footer>
    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
</footer>

</body>
</html>
