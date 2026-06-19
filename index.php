<?php
session_start();

include 'includes/db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param(
        $query,
        "s",
        $email
    );

    mysqli_stmt_execute($query);

    $result =
        mysqli_stmt_get_result($query);

    $user =
        mysqli_fetch_assoc($result);

    if(
        $user &&
        password_verify(
            $password,
            $user['password']
        )
    ){

        $_SESSION['id'] =
            $user['id'];

        $_SESSION['fullname'] =
            $user['fullname'];

        $_SESSION['role'] =
            $user['role'];
        

        
        if($user['role'] == 'admin'){

            header(
                "Location: admin/dashboard.php"
            );
            exit();

        }else{

            header(
                "Location: guest/dashboard.php"
            );
            exit();
        }

    }else{

        echo "Invalid email or password.";

    }

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f4f4f4;

    display:flex;
    justify-content:center;
    align-items:center;

    height:100vh;
}

.login-card{
    width:400px;

    background:white;

    padding:40px;

    border-radius:15px;

    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.logo{
    text-align:center;
    margin-bottom:10px;

    font-size:28px;
    font-weight:bold;

    color:#c9a86a;
}

h2{
    text-align:center;
    margin-bottom:30px;
}

.field{
    margin-bottom:20px;
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

.login-btn{
    width:100%;

    padding:14px;

    border:none;

    background:#c9a86a;
    color:white;

    border-radius:8px;

    cursor:pointer;

    font-size:16px;
}

.login-btn:hover{
    opacity:.9;
}

.register-link{
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

<div class="login-card">

    <div class="logo">
        ABC HOTEL
    </div>

    <h2>Welcome Back</h2>

    <form action="index.php" method="POST">

        <div class="field">
            <label>Email</label>

            <input
                type="email"
                name="email"
                required>
        </div>

        <div class="field">
            <label>Password</label>

            <input
                type="password"
                name="password"
                required>
        </div>

        <button
            type="submit"
            class="login-btn">
            Login
        </button>

    </form>

    <div class="register-link">
        Don't have an account?
        <a href="register.php">
            Register
        </a>
    </div>

</div>

</body>
</html>