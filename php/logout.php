<?php
session_start(); 
include("../db/connection.php");

if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
    $session_id=session_id();
    $activity="logout";
    $st="INSERT INTO user_activity (session_id,user_id,activity) VALUES(?,?,?)";
    $stm=$conn->prepare($st);
    $stm->bind_param("iis",$session_id,$user_id,$activity);
    $stm->execute();
}
session_unset();
session_destroy(); 
header('Location: ../php/login.php');
exit();
?>