
<?php

include "config/database.php";

$categories = mysqli_query($conn, "SELECT * FROM categories");

$category_id = isset($_GET['category']) ? (int) $_GET['category'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$query = "
    SELECT cakes.*, categories.category_name
    FROM cakes
    INNER JOIN categories
    ON cakes.category_id = categories.category_id
    WHERE cakes.availability = 1
";

if ($category_id > 0 && $search !== "") {

    $query .= " AND cakes.category_id = ? AND cakes.cake_name LIKE ?";

    $stmt = mysqli_prepare($conn, $query);
    $search_term = "%" . $search . "%";
    mysqli_stmt_bind_param($stmt, "is", $category_id, $search_term);

} elseif ($category_id > 0) {

    $query .= " AND cakes.category_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);

} elseif ($search !== "") {

    $query .= " AND cakes.cake_name LIKE ?";

    $stmt = mysqli_prepare($conn, $query);
    $search_term = "%" . $search . "%";
    mysqli_stmt_bind_param($stmt, "s", $search_term);

} else {

    $stmt = mysqli_prepare($conn, $query);

}

if ($stmt && mysqli_stmt_execute($stmt)) {
    $cakes = mysqli_stmt_get_result($stmt);
} else {
    die("Unable to load cakes. Please try again.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cakes - Online Cake Studio</title>

    <link rel="stylesheet" href="assests/css/style.css">
</head>

<body>

    <header>
        <h1>Online Cake Studio</h1>

        <nav>
            <a href="index.php">Home</a>
            <a href="cakes.php">Cakes</a>
            <a href="#">About Us</a>
            <a href="#">Contact</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>

        <section class="cakes-page">
            <h2>Our Cakes</h2>
            <form method="GET" class="search-form">

    <input 
        type="text" 
        name="search" 
        placeholder="Search cakes..."
    >

    <button type="submit">Search</button>

</form>
            <div class="category-filter">

    <a href="cakes.php">All Cakes</a>

    <?php while ($category = mysqli_fetch_assoc($categories)) { ?>

        <a href="cakes.php?category=<?php echo $category['category_id']; ?>">
            <?php echo $category['category_name']; ?>
        </a>

    <?php } ?>

</div>

            <p>Choose from our delicious cakes for every celebration.</p>

            <?php while ($cake = mysqli_fetch_assoc($cakes)) { ?>

                <div class="cake-card">

                    <img
                        src="assests/images/<?php echo $cake['image']; ?>"
                        alt="<?php echo $cake['cake_name']; ?>"
                        width="250"
                    >

                    <h3>
                        <?php echo $cake['cake_name']; ?>
                    </h3>

                    <p>
                        <strong>Category:</strong>
                        <?php echo $cake['category_name']; ?>
                    </p>

                    <p>
                        <?php echo $cake['description']; ?>
                    </p>

                    <p>
                        <strong>Price:</strong>
                        ₹<?php echo $cake['price']; ?>
                    </p>

                    <a href="cake-details.php?id=<?php echo $cake['cake_id']; ?>">
                        View Details
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