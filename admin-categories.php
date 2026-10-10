
<?php

session_start();

include "config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$message = "";

if (isset($_POST['add_category'])) {

    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);

    if ($category_name !== "") {

        $check_query = "SELECT category_id FROM categories
                        WHERE category_name = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $category_name);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {

            $message = "This category already exists.";

        } else {

            $query = "INSERT INTO categories (category_name, description)
                      VALUES (?, ?)";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param(
                $stmt,
                "ss",
                $category_name,
                $description
            );

            if (mysqli_stmt_execute($stmt)) {
                $message = "Category added successfully.";
            } else {
                $message = "Unable to add category.";
            }
        }

    } else {
        $message = "Please enter a category name.";
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Online Cake Studio</title>
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

        <h2>Manage Categories</h2>

        <?php if ($message !== "") { ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>

        <div class="cake-card">
            <h3>Add New Category</h3>

            <form method="POST">
                <label>Category Name:</label><br>
                <input type="text" name="category_name" required>
                <br><br>

                <label>Description:</label><br>
                <textarea name="description" rows="3" cols="40"></textarea>
                <br><br>

                <button type="submit" name="add_category">
                    Add Category
                </button>
            </form>
        </div>

        <h3>Existing Categories</h3>

        <?php while ($category = mysqli_fetch_assoc($categories)) { ?>

            <div class="cake-card">
                <h3>
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($category['description'] ?? ''); ?>
                </p>

                <p>
                    Category ID:
                    <?php echo (int) $category['category_id']; ?>
                </p>
                
<a href="admin-edit-category.php?id=<?php echo (int) $category['category_id']; ?>">
    Edit Category
</a>
<br><br>

<a href="admin-delete-category.php?id=<?php echo (int) $category['category_id']; ?>">
    Delete Category
</a>

            </div>

        <?php } ?>

    </section>
</main>

<footer>
    <p>&copy; 2026 Online Cake Studio. All Rights Reserved.</p>
</footer>

</body>
</html>
