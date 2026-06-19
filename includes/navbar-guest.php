<div class="navbar">

    <div class="logo">
        ABC HOTEL
    </div>

    <div class="nav-links">

        <a href="dashboard.php">
            Home
        </a>

        <a href="suites.php">
            Suites
        </a>

        <a href="dining_reservation.php">
            Dining
        </a>

        <a href="about.php">
            About
        </a>

        <a href="profile.php">
            Profile
        </a>

    </div>

    <div class="user-section">

        <a href="../guest/booking.php" class="book-btn">
            Book Now
        </a>

        <span>
            Welcome,
            <strong>
                <?php echo $_SESSION['fullname']; ?>
            </strong>
        </span>

        <a
            href="../logout.php"
            class="logout-btn">
            Logout
        </a>

    </div>

</div>