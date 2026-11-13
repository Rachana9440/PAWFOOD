
<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

include '../config/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT id, username, password FROM admins WHERE username = ?");

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="how">
    <div class="form-box">
        <h2>🐾 Admin Login</h2>

        <?php if ($error != ""): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username"
                   placeholder="Admin Username" required>

            <input type="password" name="password"
                   placeholder="Password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</section>

</body>
</html>
