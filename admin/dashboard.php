
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$donors = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM donors")
);

$ngos = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM ngos")
);

$donations = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM donations")
);

$pending = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM donations WHERE status = 'Pending'")
);

$distributed = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM donations WHERE status = 'Distributed'")
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h2>🐾 PAWFOOD ADMIN</h2>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="manage.php">Manage Records</a></li>
        </ul>
        <a href="../logout.php" class="nav-btn">Logout</a>
    </nav>
</header>

<section class="about">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>
    <p>Manage the PAWFOOD Animal Food Donation System.</p>
</section>

<section class="how">
    <h2>Admin Dashboard</h2>

    <div class="steps">

        <div class="step-card">
            <h3>👤 Total Donors</h3>
            <h2><?php echo $donors['total']; ?></h2>
        </div>

        <div class="step-card">
            <h3>🏢 Total NGOs</h3>
            <h2><?php echo $ngos['total']; ?></h2>
        </div>

        <div class="step-card">
            <h3>🍚 Total Donations</h3>
            <h2><?php echo $donations['total']; ?></h2>
        </div>

        <div class="step-card">
            <h3>⏳ Pending Donations</h3>
            <h2><?php echo $pending['total']; ?></h2>
        </div>

        <div class="step-card">
            <h3>❤️ Distributed Donations</h3>
            <h2><?php echo $distributed['total']; ?></h2>
        </div>

    </div>
</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
