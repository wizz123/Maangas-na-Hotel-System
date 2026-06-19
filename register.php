<?php

include 'includes/db.php';

$message = "";

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password != $confirm){

        $message = "Passwords do not match.";

    }else{

        $check = mysqli_query(
            $conn,
            "SELECT * FROM users
             WHERE email='$email'"
        );

        if(mysqli_num_rows($check) > 0){

            $message = "Email already exists.";

        }else{

            $hashedPassword =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

            mysqli_query(
                $conn,
                "INSERT INTO users
                (
                    fullname,
                    email,
                    phone,
                    password,
                    role
                )
                VALUES
                (
                    '$fullname',
                    '$email',
                    '$phone',
                    '$hashedPassword',
                    'guest'
                )"
            );

            header("Location: index.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register | The Royal Suites</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f4f4f4;

    display:flex;
    justify-content:center;
    align-items:center;

    min-height:100vh;
}

.register-card{
    width:450px;

    background:white;

    padding:40px;

    border-radius:15px;

    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.logo{
    text-align:center;

    font-size:28px;
    font-weight:bold;

    color:#c9a86a;

    margin-bottom:10px;
}

h2{
    text-align:center;
    margin-bottom:25px;
}

.field{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

input{
    width:100%;

    padding:12px;

    border:1px solid #ccc;
    border-radius:8px;

    box-sizing:border-box;
}

.register-btn{
    width:100%;

    padding:14px;

    border:none;

    background:#c9a86a;
    color:white;

    border-radius:8px;

    font-size:16px;

    cursor:pointer;
}

.register-btn:hover{
    opacity:.9;
}

.login-link{
    text-align:center;
    margin-top:20px;
}

a{
    color:#c9a86a;
    text-decoration:none;
}

</style>
</head>
<body>

<div class="register-card">

    <div class="logo">
        ABC HOTEL
    </div>

    <h2>Create Account</h2>

    <?php
        if($message != ""){
            echo "<p>$message</p>";
        }
    ?>

    <form action="" method="POST">

        <div class="field">
            <label>Full Name</label>

            <input
                type="text"
                name="fullname"
                required>
        </div>

        <div class="field">
            <label>Email Address</label>

            <input
                type="email"
                name="email"
                required>
        </div>

        <div class="field">
            <label>Mobile Number</label>

            <input
                type="text"
                name="phone"
                required>
        </div>

        <div class="field">
            <label>Password</label>

            <input
                type="password"
                name="password"
                required>
        </div>

        <div class="field">
            <label>Confirm Password</label>

            <input
                type="password"
                name="confirm_password"
                required>
        </div>

        <button
            type="submit"
            name="register"
            class="register-btn">

            Create Account

        </button>

    </form>

    <div class="login-link">
        Already have an account?
        <a href="index.php">
            Login
        </a>
    </div>

</div>

</body>
</html>