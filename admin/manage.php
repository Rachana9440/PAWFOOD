
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

// Get all donors
$donors = mysqli_query($conn,
    "SELECT id, name, email, phone, created_at
     FROM donors ORDER BY id DESC");

// Get all NGOs
$ngos = mysqli_query($conn,
    "SELECT id, organization_name, email, phone, address
     FROM ngos ORDER BY id DESC");

// Get all donations with donor and NGO details
$donations = mysqli_query($conn,
    "SELECT donations.*, donors.name AS donor_name,
     ngos.organization_name
     FROM donations
     JOIN donors ON donations.donor_id = donors.id
     LEFT JOIN ngos ON donations.ngo_id = ngos.id
     ORDER BY donations.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Records - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h2>🐾 PAWFOOD ADMIN</h2>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
        <a href="../logout.php" class="nav-btn">Logout</a>
    </nav>
</header>

<section class="about">
    <h2>Manage PAWFOOD Records</h2>
    <p>View registered donors, NGOs and food donations.</p>
</section>

<section class="how">

    <h2>👤 Registered Donors</h2>

    <div style="overflow-x:auto;">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Registered Date</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($donors)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <br>

    <h2>🏢 Registered NGOs</h2>

    <div style="overflow-x:auto;">
        <table>
            <tr>
                <th>ID</th>
                <th>Organization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($ngos)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['organization_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <br>

    <h2>🍚 All Food Donations</h2>

    <div style="overflow-x:auto;">
        <table>
            <tr>
                <th>ID</th>
                <th>Donor</th>
                <th>Food</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>NGO</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($donations)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['donor_name']); ?></td>
                <td><?php echo htmlspecialchars($row['food_type']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td>
                    <?php echo htmlspecialchars(
                        $row['organization_name'] ?? 'Not Assigned'
                    ); ?>
                </td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
