
<?php
include '../config/database.php';

$message = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['organization_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";
    } else {

        $check = mysqli_prepare($conn,
            "SELECT id FROM ngos WHERE email = ?");

        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);

        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) > 0) {

            $message = "Email already registered!";

        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($conn,
                "INSERT INTO ngos
                (organization_name, email, phone, address, password)
                VALUES (?, ?, ?, ?, ?)");

            mysqli_stmt_bind_param(
                $stmt, "sssss",
                $name, $email, $phone, $address, $hashedPassword
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NGO Registration - PAWFOOD</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="about">

    <h2>🐾 NGO Registration</h2>

    <form method="POST" class="form-box">

        <input type="text" name="organization_name"
        placeholder="Organization Name" required maxlength="150">

        <input type="email" name="email"
        placeholder="Email Address" required maxlength="150">

        <input type="tel" name="phone"
        placeholder="Phone Number" required maxlength="15">

        <input type="text" name="address"
        placeholder="Organization Address" required maxlength="255">

        <input type="password" name="password"
        placeholder="Password (minimum 8 characters)"
        required minlength="8">

        <button type="submit" name="register" class="main-btn">
            Register NGO
        </button>

    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

    <p>Already registered?
        <a href="login.php">Login here</a>
    </p>

</section>

</body>
</html>
