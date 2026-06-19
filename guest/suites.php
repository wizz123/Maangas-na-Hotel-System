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
<title>Suites | The Royal Suites</title>

<link rel="stylesheet" href="../includes/navbar-guest.css">

<style>

body{
    margin:0;
    background:#f5f6fa;
    font-family:Arial,sans-serif;
}

.page-header{
    background:#1d1d1d;
    color:white;
    padding:60px 30px;
    text-align:center;
}

.page-header h1{
    margin:0;
    font-size:42px;
}

.page-header p{
    margin-top:10px;
    opacity:.8;
}

.container{
    max-width:1200px;
    margin:auto;
    padding:50px 20px;
}

.suite-grid{
    display:grid;
    grid-template-columns:repeat(2, minmax(350px, 500px));
    justify-content:center;
    gap:30px;
}

@media(max-width:768px){

    .suite-grid{
        grid-template-columns:1fr;
    }

}

.suite-card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 3px 15px rgba(0,0,0,.08);
    transition:.3s;
}

.suite-card:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 25px rgba(0,0,0,.15);
}

.suite-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.suite-content{
    padding:20px;
}

.suite-content h3{
    margin-top:0;
    margin-bottom:10px;
}

.capacity{
    color:#666;
    margin-bottom:10px;
}

.price{
    font-size:22px;
    font-weight:bold;
    color:#c9a86a;
    margin:15px 0;
}

.book-btn{
    display:block;
    text-align:center;
    text-decoration:none;
    background:#c9a86a;
    color:white;
    padding:12px;
    border-radius:8px;
}

.book-btn:hover{
    opacity:.9;
}

</style>
</head>

<body>

<?php include '../includes/navbar-guest.php'; ?>

<div class="page-header">

    <h1>Luxury Suites</h1>

    <p>
        Discover comfort, elegance and premium hospitality.
    </p>

</div>

<div class="container">

    <div class="suite-grid">

        <!-- 1 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Standard Room</h3>
                <p class="capacity">👤 2 Guests</p>
                <p>Comfortable room with modern amenities.</p>
                <div class="price">₱3,500/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 2 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Deluxe Room</h3>
                <p class="capacity">👤 2 Adults • 1 Child</p>
                <p>Spacious room with balcony and city view.</p>
                <div class="price">₱4,500/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 3 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Family Suite</h3>
                <p class="capacity">👤 4 Guests</p>
                <p>Perfect for family vacations.</p>
                <div class="price">₱6,000/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 4 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Executive Suite</h3>
                <p class="capacity">👤 4 Guests</p>
                <p>Luxury living with lounge access.</p>
                <div class="price">₱8,000/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 5 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Junior Suite</h3>
                <p class="capacity">👤 2 Guests</p>
                <p>Elegant room with premium furnishings.</p>
                <div class="price">₱5,500/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 6 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Ocean View Suite</h3>
                <p class="capacity">👤 3 Guests</p>
                <p>Relax with breathtaking ocean scenery.</p>
                <div class="price">₱9,500/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 7 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Presidential Suite</h3>
                <p class="capacity">👤 6 Guests</p>
                <p>Ultimate luxury and exclusivity.</p>
                <div class="price">₱18,000/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

        <!-- 8 -->
        <div class="suite-card">
            <img src="../images/suites/suite0.jpg">
            <div class="suite-content">
                <h3>Royal Suite</h3>
                <p class="capacity">👤 8 Guests</p>
                <p>Our finest suite with premium amenities.</p>
                <div class="price">₱25,000/night</div>
                <a href="../booking.php" class="book-btn">
                    Learn More
                </a>
            </div>
        </div>

    </div>

</div>

</body>
</html> 