
<?php
session_start();
include '../config/database.php';

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT id, name, password FROM donors WHERE email = ?");

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $donor = mysqli_fetch_assoc($result);

    if ($donor && password_verify($password, $donor['password'])) {

        session_regenerate_id(true);

        $_SESSION['donor_id'] = $donor['id'];
        $_SESSION['donor_name'] = $donor['name'];

        header("Location: dashboard.php");
        exit();

    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Login - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="about">

    <h2>🐾 Donor Login</h2>

    <form method="POST" class="form-box">

        <input type="email" name="email"
        placeholder="Email Address" required>

        <input type="password" name="password"
        placeholder="Password" required>

        <button type="submit" name="login" class="main-btn">
            Login
        </button>

    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

    <p>New donor?
        <a href="register.php">Register here</a>
    </p>

</section>

</body>
</html>
