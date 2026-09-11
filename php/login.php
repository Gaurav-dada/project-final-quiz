<?php
session_start();
include("../db/connection.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

     if (empty($username) || empty($password)) {
        echo "<script>
            alert('Username and password are required');
            window.location.href='../php/login.php';
        </script>";
        exit();
    }


    $st = "SELECT id, username, password FROM users WHERE username=?";
    $sql = $conn->prepare($st);
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if($result->num_rows > 0){

        $users = $result->fetch_assoc();

        if(password_verify($password, $users['password'])){

            $_SESSION['user_id'] = $users['id'];
            $_SESSION['username'] = $users['username'];

            $activity = "login";
            $session_id = session_id();

            $st = "INSERT INTO user_activity(session_id, user_id, activity)
                   VALUES (?, ?, ?)";
            $stm = $conn->prepare($st);
            $stm->bind_param("iis", $session_id, $_SESSION['user_id'], $activity);
            $stm->execute();

             if ($users['username'] === 'admin') {
            header("Location: adminpage.php");
        } else {
            header("Location: studentpage.php");
        }
        exit();
        } else {
            echo "<script>
                alert('Reenter username and password');
                window.location.href='../php/login.php';
            </script>";
        }

    } else {
        echo "<script>
            alert('user not found');
            window.location.href='../php/login.php';
        </script>";
    }
}
?>


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

<div class="login-container">
    <form class="login-box" method="POST" action="">
        <h2>Login</h2>

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>
          
       
        <button name="login" type="submit">Login</button> 
        <a href="../php/signup.php">Create Account</a>
    </form>
</div>

<script></script>
</body>
</html>
