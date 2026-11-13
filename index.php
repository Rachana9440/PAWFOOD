
<?php
include 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAWFOOD | Every Meal Makes a Difference</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVIGATION -->
<header>
    <nav class="navbar">
        <h2>🐾 PAWFOOD</h2>

        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">Our Mission</a></li>
            <li><a href="#how">How It Works</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

        <a href="donor/register.php" class="nav-btn">
            Donate Food →
        </a>
    </nav>
</header>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">

        <span class="hero-tag">A LITTLE FOOD. A LOT OF LOVE.</span>

        <h1>
            Every Paw<br>
            Deserves a <span>Full Bowl.</span>
        </h1>

        <p>
            Good food should never go to waste when hungry animals
            are waiting for a meal. PAWFOOD connects generous donors
            with animal welfare organizations to make every donation count.
        </p>

        <div class="hero-buttons">
            <a href="donor/register.php" class="main-btn">
                Make a Donation →
            </a>

            <a href="#how" class="secondary-btn">
                Discover How It Works
            </a>
        </div>

        <div class="hero-note">
            <span>🐾</span>
            <p>Small acts of kindness create a better world for animals.</p>
        </div>

    </div>

    <div class="hero-visual">
        <div class="hero-image-card">
            <div class="hero-image-symbol">🐕</div>

            <div class="hero-image-caption">
                <span>THE POWER OF SHARING</span>
                <h3>One meal can change a life.</h3>
            </div>
        </div>

        <div class="floating-card">
            <span>💚</span>
            <div>
                <strong>Share Kindness</strong>
                <p>Feed. Care. Repeat.</p>
            </div>
        </div>
    </div>
</section>

<!-- INTRODUCTION -->
<section class="intro-strip">
    <div>
        <strong>01</strong>
        <span>Donate surplus food</span>
    </div>

    <div>
        <strong>02</strong>
        <span>Connect with NGOs</span>
    </div>

    <div>
        <strong>03</strong>
        <span>Help feed animals</span>
    </div>
</section>

<!-- ABOUT -->
<section class="about" id="about">
    <span class="section-label">WHO WE ARE</span>

    <h2>Kindness Should Reach Every Corner.</h2>

    <p>
        PAWFOOD is an animal food donation and management platform
        designed to connect food donors with animal welfare
        organizations. Our goal is to make food donations easier
        to manage and help provide meals to hungry and homeless animals.
    </p>

    <div class="about-highlight">
        <span>🐾</span>
        <p>
            We believe that every animal deserves care, compassion
            and access to food.
        </p>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="how">
    <span class="section-label">SIMPLE PROCESS</span>

    <h2>How PAWFOOD Works</h2>

    <p class="section-description">
        Three simple steps can help turn surplus food into meaningful care.
    </p>

    <div class="steps">

        <div class="step-card">
            <div class="step-icon">🍚</div>
            <span class="step-number">01</span>
            <h3>Donate Food</h3>
            <p>
                Register as a donor and share details about
                the food available for donation.
            </p>
        </div>

        <div class="step-card">
            <div class="step-icon">🤝</div>
            <span class="step-number">02</span>
            <h3>NGO Accepts</h3>
            <p>
                Registered animal welfare organizations can
                view available donations and accept collections.
            </p>
        </div>

        <div class="step-card">
            <div class="step-icon">🐕</div>
            <span class="step-number">03</span>
            <h3>Feed Animals</h3>
            <p>
                Accepted food donations are collected and
                distributed to animals in need.
            </p>
        </div>

    </div>
</section>

<!-- CONTACT / CALL TO ACTION -->
<section class="contact" id="contact">
    <span class="section-label">BE PART OF THE CHANGE</span>

    <h2>Be the Reason a Bowl Is Never Empty.</h2>

    <p>
        Your contribution, no matter how small, can bring
        comfort and nourishment to an animal.
    </p>

    <a href="donor/register.php" class="main-btn">
        Become a Donor →
    </a>
</section>

<!-- FOOTER -->
<footer>
    <h3>🐾 PAWFOOD</h3>

    <p>Connecting generous hearts with animals in need.</p>

    <p>© 2026 PAWFOOD | Animal Food Donation and Management System</p>

    <p>Made with ❤️ for Animals</p>
</footer>

</body>
</html>
