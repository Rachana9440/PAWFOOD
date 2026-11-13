
<?php
session_start();

if (!isset($_SESSION['donor_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$donor_id = $_SESSION['donor_id'];

// Get donor information
$stmt = mysqli_prepare($conn,
    "SELECT name, email, phone FROM donors WHERE id = ?");

mysqli_stmt_bind_param($stmt, "i", $donor_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$donor = mysqli_fetch_assoc($result);

if (!$donor) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - PAWFOOD</title>
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

    <h2>Welcome, <?php echo htmlspecialchars($donor['name']); ?>! 🐾</h2>

    <p>Thank you for helping hungry animals.</p>

</section>

<section class="how">

    <h2>Your Donor Dashboard</h2>

    <div class="steps">

        <div class="step-card">
            <h3>👤 My Profile</h3>
            <p>Name: <?php echo htmlspecialchars($donor['name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($donor['email']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($donor['phone']); ?></p>
        </div>

        <div class="step-card">
            <h3>🍚 Donate Food</h3>
            <p>Help provide food for hungry animals.</p>
            <a href="donate.php" class="main-btn">Donate Now</a>
        </div>

        <div class="step-card">
            <h3>📋 My Donations</h3>
            <p>View your previous food donations.</p>
            <a href="my-donations.php" class="main-btn">View Donations</a>
        </div>

    </div>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
