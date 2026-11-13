
<?php
session_start();

if (!isset($_SESSION['donor_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['donation_success'])) {
    header("Location: dashboard.php");
    exit();
}

unset($_SESSION['donation_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thank You - PAWFOOD</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .thankyou-section {
            min-height: 75vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            background: #f8faf7;
        }

        .thankyou-card {
            max-width: 650px;
            width: 100%;
            background: #ffffff;
            padding: 55px 40px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #c49a45;
        }

        .success-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            background: #e8f3ec;
            color: #245c42;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
        }

        .thankyou-card h1 {
            color: #245c42;
            font-size: 32px;
            margin-bottom: 18px;
        }

        .thankyou-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .thankyou-card h3 {
            color: #245c42;
            margin: 25px 0;
            font-size: 19px;
        }

        .thankyou-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .thankyou-buttons a {
            text-decoration: none;
            padding: 13px 22px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        .donation-btn {
            background: #245c42;
            color: white;
        }

        .donation-btn:hover {
            background: #19452f;
            transform: translateY(-2px);
        }

        .dashboard-btn {
            background: #c49a45;
            color: white;
        }

        .dashboard-btn:hover {
            background: #a77f31;
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            .thankyou-card {
                padding: 35px 20px;
            }

            .thankyou-card h1 {
                font-size: 25px;
            }

            .thankyou-buttons {
                flex-direction: column;
            }

            .thankyou-buttons a {
                width: 100%;
                box-sizing: border-box;
            }
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

<section class="thankyou-section">

    <div class="thankyou-card">

        <div class="success-icon">
            ✓
        </div>

        <h1>Thank You for Your Donation!</h1>

        <p>
            Your food donation has been submitted successfully.
        </p>

        <p>
            Your kindness and generosity will help provide
            food for hungry and homeless animals.
        </p>

        <p>
            Our NGO partners will review your donation details
            and coordinate the food collection.
        </p>

        <h3>
            🐾 Every Meal Matters. Every Life Counts. ❤️
        </h3>

        <div class="thankyou-buttons">

            <a href="my-donations.php" class="donation-btn">
                View My Donations
            </a>

            <a href="dashboard.php" class="dashboard-btn">
                Back to Dashboard
            </a>

        </div>

    </div>

</section>

<footer>
    <p>© 2026 PAWFOOD | Made with ❤️ for Animals</p>
</footer>

</body>
</html>
