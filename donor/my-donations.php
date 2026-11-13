
<?php
session_start();

if (!isset($_SESSION['donor_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$donor_id = $_SESSION['donor_id'];

$stmt = mysqli_prepare($conn,
    "SELECT * FROM donations WHERE donor_id = ? ORDER BY created_at DESC");

mysqli_stmt_bind_param($stmt, "i", $donor_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Donations - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h2>🐾 PAWFOOD</h2>

        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
        </ul>

        <a href="../logout.php" class="nav-btn">Logout</a>
    </nav>
</header>

<section class="about">

    <h2>📋 My Food Donations</h2>

    <p>Here you can view all your submitted donations.</p>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <div class="table-container">
        <table class="donation-table">

            <tr>
                <th>ID</th>
                <th>Food Type</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Status</th>
                <th>Date</th>
                <th>Photo</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <tr>
                <td><?php echo $row['id']; ?></td>

                <td><?php echo htmlspecialchars($row['food_type']); ?></td>

                <td><?php echo htmlspecialchars($row['quantity']); ?></td>

                <td><?php echo htmlspecialchars($row['location']); ?></td>

                <td><?php echo htmlspecialchars($row['status']); ?></td>

                <td><?php echo htmlspecialchars($row['created_at']); ?></td>

                <td>
                    <?php if (!empty($row['image'])) { ?>
                        <img src="../uploads/<?php echo rawurlencode($row['image']); ?>"
                             width="70" alt="Food donation">
                    <?php } else { ?>
                        No Image
                    <?php } ?>
                </td>
            </tr>

            <?php } ?>

        </table>
        </div>

    <?php } else { ?>

        <h3>No donations submitted yet.</h3>

    <?php } ?>

    <br>

    <a href="donate.php" class="main-btn">Donate More Food</a>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
