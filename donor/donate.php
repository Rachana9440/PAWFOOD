
<?php
session_start();

if (!isset($_SESSION['donor_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

$message = "";

if (isset($_POST['donate'])) {

    $donor_id = $_SESSION['donor_id'];
    $food_type = trim($_POST['food_type']);
    $quantity = trim($_POST['quantity']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);

    $image_name = NULL;

    if (
        empty($food_type) ||
        empty($quantity) ||
        empty($location)
    ) {
        $message = "Please fill all required fields.";
    } else {

        // Optional food photograph upload
        if (
            isset($_FILES['food_image']) &&
            $_FILES['food_image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['food_image']['error'] !== UPLOAD_ERR_OK) {
                $message = "Image upload failed.";
            } elseif ($_FILES['food_image']['size'] > 2 * 1024 * 1024) {
                $message = "Image must be smaller than 2 MB.";
            } else {

                $allowed = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($_FILES['food_image']['tmp_name']);

                if (!isset($allowed[$mime])) {
                    $message = "Only JPG, PNG and WEBP images are allowed.";
                } else {

                    $image_name = bin2hex(random_bytes(16))
                                . "." . $allowed[$mime];

                    $upload_path = "../uploads/" . $image_name;

                    if (!move_uploaded_file(
                        $_FILES['food_image']['tmp_name'],
                        $upload_path
                    )) {
                        $message = "Unable to save the image.";
                    }
                }
            }
        }

        if (empty($message)) {

            $stmt = mysqli_prepare($conn,
                "INSERT INTO donations
                (donor_id, food_type, quantity, location, description, image)
                VALUES (?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                $message = "Database error: " . mysqli_error($conn);
            } else {

                mysqli_stmt_bind_param(
                    $stmt,
                    "isssss",
                    $donor_id,
                    $food_type,
                    $quantity,
                    $location,
                    $description,
                    $image_name
                );

                if (mysqli_stmt_execute($stmt)) {

                    $_SESSION['donation_success'] = true;

                    header("Location: thank-you.php");
                    exit();

                } else {

                    $message = "Donation submission failed: "
                             . mysqli_stmt_error($stmt);
                }

                mysqli_stmt_close($stmt);
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
    <title>Donate Food - PAWFOOD</title>
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

    <h2>🍚 Donate Food for Animals</h2>

    <p>Your small donation can make a big difference!</p>

    <form method="POST" enctype="multipart/form-data"
          class="form-box">

        <label>Food Type *</label>

        <select name="food_type" required>
            <option value="">Select Food Type</option>
            <option value="Dog Food">Dog Food</option>
            <option value="Cat Food">Cat Food</option>
            <option value="Rice">Rice</option>
            <option value="Biscuits">Biscuits</option>
            <option value="Other">Other</option>
        </select>

        <label>Food Quantity *</label>

        <input type="text" name="quantity"
               placeholder="Example: 5 kg" required maxlength="100">

        <label>Pickup Location *</label>

        <input type="text" name="location"
               placeholder="Enter your location" required maxlength="255">

        <label>Additional Description</label>

        <textarea name="description"
                  placeholder="Enter additional details"
                  rows="4"></textarea>

        <label>Upload Food Photograph (Optional)</label>

        <input type="file" name="food_image"
               accept=".jpg,.jpeg,.png,.webp">

        <button type="submit" name="donate" class="main-btn">
            Submit Donation
        </button>

    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
