
<?php
session_start();

if (!isset($_SESSION['ngo_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$ngo_id = (int) $_SESSION['ngo_id'];
$message = "";
$message_type = "success";

// Accept donation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept_id'])) {

    $donation_id = (int) $_POST['accept_id'];

    $stmt = mysqli_prepare($conn,
        "UPDATE donations
         SET status = 'Accepted', ngo_id = ?
         WHERE id = ? AND status = 'Pending' AND ngo_id IS NULL");

    mysqli_stmt_bind_param($stmt, "ii", $ngo_id, $donation_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $message = "Donation accepted successfully!";
    } else {
        $message = "This donation is no longer available.";
        $message_type = "error";
    }
}

// Update donation status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {

    $donation_id = (int) $_POST['donation_id'];
    $new_status = $_POST['new_status'];

    if ($new_status === 'Collected') {

        $stmt = mysqli_prepare($conn,
            "UPDATE donations
             SET status = 'Collected'
             WHERE id = ? AND ngo_id = ? AND status = 'Accepted'");

        mysqli_stmt_bind_param($stmt, "ii", $donation_id, $ngo_id);

    } elseif ($new_status === 'Distributed') {

        $stmt = mysqli_prepare($conn,
            "UPDATE donations
             SET status = 'Distributed'
             WHERE id = ? AND ngo_id = ? AND status = 'Collected'");

        mysqli_stmt_bind_param($stmt, "ii", $donation_id, $ngo_id);

    } else {
        $stmt = null;
    }

    if ($stmt !== null) {
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $message = "Donation status updated successfully!";
        } else {
            $message = "Unable to update donation status.";
            $message_type = "error";
        }
    }
}

// Fetch donations
$stmt = mysqli_prepare($conn,
    "SELECT donations.*,
            donors.name AS donor_name,
            donors.phone AS donor_phone
     FROM donations
     JOIN donors ON donations.donor_id = donors.id
     WHERE donations.status = 'Pending'
        OR donations.ngo_id = ?
     ORDER BY donations.created_at DESC");

mysqli_stmt_bind_param($stmt, "i", $ngo_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Donation Tracking - PAWFOOD</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .donation-section {
            padding: 35px 3%;
        }

        .donation-section h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .donation-section > p {
            text-align: center;
            margin-bottom: 25px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .donation-table {
            width: 100%;
            min-width: 1250px;
            border-collapse: collapse;
            background: white;
            font-size: 15px;
        }

        .donation-table th {
            background: #245c42;
            color: white;
            padding: 16px 12px;
            text-align: center;
            border: 1px solid #d5ded8;
            white-space: nowrap;
        }

        .donation-table td {
            padding: 15px 12px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #d5ded8;
            line-height: 1.6;
        }

        .donation-table tbody tr:nth-child(even) {
            background: #f0f7f2;
        }

        .donation-table tbody tr:hover {
            background: #e1f0e5;
        }

        .donation-table td.description-cell {
            min-width: 180px;
            max-width: 250px;
            overflow-wrap: anywhere;
        }

        .donation-table td.location-cell {
            min-width: 190px;
            max-width: 230px;
            overflow-wrap: anywhere;
        }

        .donation-table a {
            color: #075db5;
            font-weight: bold;
        }

        .directions-link {
            display: inline-block;
            margin-top: 8px;
            color: #087b45 !important;
        }

        .donation-table button {
            padding: 9px 13px;
            border: none;
            border-radius: 5px;
            background: #28764e;
            color: white;
            cursor: pointer;
            font-weight: bold;
            margin: 3px;
        }

        .donation-table button:hover {
            background: #185536;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-pending {
            background: #fff0c2;
            color: #805600;
        }

        .status-accepted {
            background: #dceaff;
            color: #174d91;
        }

        .status-collected {
            background: #e8defc;
            color: #57358b;
        }

        .status-distributed {
            background: #d8f3df;
            color: #176b34;
        }

        .message {
            text-align: center;
            padding: 12px;
            margin: 15px auto;
            max-width: 600px;
            border-radius: 6px;
            font-weight: bold;
        }

        .message.success {
            background: #d8f3df;
            color: #176b34;
        }

        .message.error {
            background: #ffe0e0;
            color: #a52222;
        }

        .no-donations {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 8px;
        }
    </style>
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

<section class="donation-section">

    <h2>Food Donations 🐾</h2>

    <p>Accept donations, collect food and distribute it to animals.</p>

    <?php if ($message != ""): ?>

        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>

        <div class="table-container">

            <table class="donation-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Food</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Donor</th>
                        <th>Phone</th>
                        <th>Collection Location</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                    <?php
                    $is_my_donation = (
                        !empty($row['ngo_id']) &&
                        (int)$row['ngo_id'] === $ngo_id
                    );
                    ?>

                    <tr>

                        <td>
                            <?php echo (int)$row['id']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['food_type']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['quantity']); ?>
                        </td>

                        <td class="description-cell">
                            <?php echo htmlspecialchars($row['description'] ?? ''); ?>
                        </td>

                        <td>
                            <?php
                            echo $is_my_donation
                                ? htmlspecialchars($row['donor_name'])
                                : "Hidden until acceptance";
                            ?>
                        </td>

                        <td>
                            <?php
                            echo $is_my_donation
                                ? htmlspecialchars($row['donor_phone'])
                                : "Hidden until acceptance";
                            ?>
                        </td>

                        <td class="location-cell">

                            <?php if ($is_my_donation): ?>

                                <?php echo htmlspecialchars($row['location']); ?>

                                <br>

                                <?php
                                $maps_url = "https://www.google.com/maps/dir/?api=1&destination="
                                          . urlencode($row['location']);
                                ?>

                                <a class="directions-link"
                                   href="<?php echo htmlspecialchars($maps_url); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    📍 Get Directions
                                </a>

                            <?php else: ?>

                                Hidden until acceptance

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if (!empty($row['image'])): ?>

                                <a href="../uploads/<?php
                                    echo rawurlencode(basename($row['image']));
                                ?>" target="_blank" rel="noopener noreferrer">
                                    View Image
                                </a>

                            <?php else: ?>

                                No Image

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php
                            $status_class = [
                                'Pending' => 'status-pending',
                                'Accepted' => 'status-accepted',
                                'Collected' => 'status-collected',
                                'Distributed' => 'status-distributed'
                            ];

                            $current_status = $row['status'];
                            ?>

                            <span class="status <?php
                                echo $status_class[$current_status] ?? '';
                            ?>">
                                <?php echo htmlspecialchars($current_status); ?>
                            </span>

                        </td>

                        <td>

                            <?php if ($row['status'] == 'Pending'): ?>

                                <form method="POST">

                                    <input type="hidden"
                                           name="accept_id"
                                           value="<?php echo (int)$row['id']; ?>">

                                    <button type="submit">
                                        Accept Donation
                                    </button>

                                </form>

                            <?php elseif ($is_my_donation && $row['status'] == 'Accepted'): ?>

                                <form method="POST">

                                    <input type="hidden"
                                           name="donation_id"
                                           value="<?php echo (int)$row['id']; ?>">

                                    <input type="hidden"
                                           name="new_status"
                                           value="Collected">

                                    <button type="submit" name="update_status">
                                        Mark Collected
                                    </button>

                                </form>

                            <?php elseif ($is_my_donation && $row['status'] == 'Collected'): ?>

                                <form method="POST">

                                    <input type="hidden"
                                           name="donation_id"
                                           value="<?php echo (int)$row['id']; ?>">

                                    <input type="hidden"
                                           name="new_status"
                                           value="Distributed">

                                    <button type="submit" name="update_status">
                                        Mark Distributed
                                    </button>

                                </form>

                            <?php elseif ($row['status'] == 'Distributed'): ?>

                                <strong>Completed</strong>

                            <?php else: ?>

                                Accepted by another NGO

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <div class="no-donations">
            <h3>No donations are available.</h3>
            <p>Please check again later.</p>
        </div>

    <?php endif; ?>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
