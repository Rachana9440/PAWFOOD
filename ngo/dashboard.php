
<?php
session_start();

if (!isset($_SESSION['ngo_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$ngo_id = $_SESSION['ngo_id'];

$stmt = mysqli_prepare($conn,
    "SELECT organization_name, email, phone, address
     FROM ngos WHERE id = ?");

mysqli_stmt_bind_param($stmt, "i", $ngo_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$ngo = mysqli_fetch_assoc($result);

if (!$ngo) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Count pending donations
$count_result = mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM donations WHERE status = 'Pending'");

$count = mysqli_fetch_assoc($count_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Dashboard - PAWFOOD</title>
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

    <h2>Welcome, <?php echo htmlspecialchars($ngo['organization_name']); ?>! 🐾</h2>

    <p>Thank you for supporting hungry animals.</p>

</section>

<section class="how">

    <h2>NGO Dashboard</h2>

    <div class="steps">

        <div class="step-card">
            <h3>🏢 Organization Profile</h3>
            <p><?php echo htmlspecialchars($ngo['organization_name']); ?></p>
            <p><?php echo htmlspecialchars($ngo['email']); ?></p>
            <p><?php echo htmlspecialchars($ngo['phone']); ?></p>
            <p><?php echo htmlspecialchars($ngo['address']); ?></p>
        </div>

        <div class="step-card">
            <h3>🍚 Available Donations</h3>
            <h2><?php echo $count['total']; ?></h2>
            <p>Pending food donations</p>
            <a href="donations.php" class="main-btn">
                View Donations
            </a>
        </div>

    </div>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
