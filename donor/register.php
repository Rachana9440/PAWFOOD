
<?php
include '../config/database.php';

$message = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";
    } else {
        $check = mysqli_prepare($conn, "SELECT id FROM donors WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) > 0) {
            $message = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($conn,
                "INSERT INTO donors (name, email, phone, password) VALUES (?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "ssss",
                $name, $email, $phone, $hashedPassword);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Registration - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="about">
    <h2>🐾 Donor Registration</h2>

    <form method="POST" class="form-box">

        <input type="text" name="name" placeholder="Full Name"
        required maxlength="100">

        <input type="email" name="email" placeholder="Email Address"
        required maxlength="150">

        <input type="tel" name="phone" placeholder="Phone Number"
        required maxlength="15">

        <input type="password" name="password"
        placeholder="Password (minimum 8 characters)"
        required minlength="8">

        <button type="submit" name="register" class="main-btn">
            Register
        </button>

    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

    <p>Already registered?
        <a href="login.php">Login here</a>
    </p>
</section>

</body>
</html>
