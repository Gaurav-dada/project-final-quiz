<?php
session_start();

include("../db/connection.php");

$username = $_SESSION['username'] ?? null;
$user_id  = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

if(isset($_POST['save'])){
 $id = $_POST['id'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$user_name = $_POST['username'];
$pass = $_POST['password'];
$confpass = $_POST['confirm_password'];

if($pass!=$confpass){
    echo "password didnot match";
    exit();
}

    $hash_pass=password_hash($pass,PASSWORD_DEFAULT);
    $st="UPDATE users SET  fullname=?,email=?,username=?,password=? WHERE id=?";
    $stm=$conn->prepare($st);
    $stm->bind_param("ssssi",$fullname,$email,$user_name,$hash_pass,$id);
   if( $stm->execute()){
        header('Location:../html/usermanage.html');
        exit();
    }
    else{
        echo "Updation Failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/edituser.css">
</head>
<body>
    <div>
     <form class="edit-box" method="POST" action="">
        <h2>Edit Account</h2>

        <div class="input-boxname">
            <input type="text" name="fullname" placeholder="Full Name" required>
        </div>

        <div class="input-boxemai">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-boxuser">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-boxpas">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-boxcon">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        </div>

        <button type="submit" name="save" class="signup-btn">Save</button>

       <input type="hidden" name="id" id="id" value="id">
    </form>
    </div> 
    <script src="../js/admin1.js"></script>
</body>
</html>