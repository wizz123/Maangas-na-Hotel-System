<?php
session_start();

if(
    !isset($_SESSION['id']) ||
    $_SESSION['role'] != 'guest'
){
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../includes/navbar_guest.css">
<title>Dashboard | The Royal Suites</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f5f6fa;
}

/* NAVBAR */

.navbar{
    background:#1d1d1d;
    color:white;
    padding:20px 50px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    font-size:24px;
    font-weight:bold;
}

.user{
    display:flex;
    gap:20px;
    align-items:center;
}

.logout-btn{
    text-decoration:none;
    background:#dc3545;
    color:white;
    padding:10px 15px;
    border-radius:8px;
}

/* HERO */

.hero{
    height:400px;

    background:
    linear-gradient(
        rgba(0,0,0,.4),
        rgba(0,0,0,.4)
    ),
    url('../images/suites/suite0.jpg');

    background-size:cover;
    background-position:center;

    color:white;

    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
}

.hero h1{
    font-size:48px;
    margin-bottom:10px;
}

.hero p{
    font-size:18px;
    margin-bottom:20px;
}

.book-btn{
    background:#c9a86a;
    color:white;
    text-decoration:none;
    padding:15px 25px;
    border-radius:8px;
}

/* CARDS */

.section{
    padding:50px;
}

.section-title{
    margin-bottom:25px;
}

.room-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.room-card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.room-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.room-content{
    padding:15px;
}

.room-content h3{
    margin-bottom:10px;
}

.room-content p{
    color:#666;
    margin-bottom:10px;
}

/* INFO */

.info-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.info-card{
    background:white;
    padding:25px;
    text-align:center;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

/* BOOKINGS */

.booking-card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:15px;
    text-align:left;
}

tr{
    border-bottom:1px solid #eee;
}

.status{
    color:green;
    font-weight:bold;
}

</style>

</head>
<body>

<?php include '../includes/navbar-guest.php'; ?>

<div class="hero">

    <h1>
        Experience Luxury & Comfort
    </h1>

    <p>
        Discover premium accommodations for your stay.
    </p>

    <a
        href="../booking.php"
        class="book-btn">
        Book a Room
    </a>

</div>

<div class="section">

    <h2 class="section-title">
        Featured Rooms
    </h2>

    <div class="room-grid">

        <div class="room-card">
            <img src="../images/suites/suite0.jpg">
            <div class="room-content">
                <h3>Standard Room</h3>
                <p>Perfect for couples.</p>
            </div>
        </div>

        <div class="room-card">
            <img src="../images/suites/suite0.jpg">
            <div class="room-content">
                <h3>Deluxe Room</h3>
                <p>City view and balcony.</p>
            </div>
        </div>

        <div class="room-card">
            <img src="../images/suites/suite0.jpg">
            <div class="room-content">
                <h3>Family Suite</h3>
                <p>Great for families.</p>
            </div>
        </div>

        <div class="room-card">
            <img src="../images/suites/suite0.jpg">
            <div class="room-content">
                <h3>Executive Suite</h3>
                <p>Luxury experience.</p>
            </div>
        </div>

    </div>

</div>

<div class="section">

    <h2 class="section-title">
        Hotel Amenities
    </h2>

    <div class="info-grid">

        <div class="info-card">
            📶<br><br>
            Free WiFi
        </div>

        <div class="info-card">
            🍽️<br><br>
            Restaurant
        </div>

        <div class="info-card">
            🏊<br><br>
            Swimming Pool
        </div>

        <div class="info-card">
            🚗<br><br>
            Parking Area
        </div>

    </div>

</div>

<div class="section">

    <h2 class="section-title">
        My Recent Bookings
    </h2>

    <div class="booking-card">

        <table>

            <tr>
                <th>Booking ID</th>
                <th>Room</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>#1001</td>
                <td>Deluxe Room</td>
                <td class="status">Confirmed</td>
            </tr>

        </table>

    </div>

</div>

</body>
</html>