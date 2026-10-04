<?php
include('connection.php');
include('auth.php');
$role=require_login();
if($role==='admin'){
    $st="SELECT id, fullname,email,username FROM users WHERE is_active=1 AND role <> 'admin'";
    $stm=$conn->prepare($st);
}
else{
    $st="SELECT id, fullname,email,username FROM users WHERE is_active=1 AND id=?";
    $stm=$conn->prepare($st);
    $stm->bind_param("i",$_SESSION['user_id']);
}
$stm->execute();
$result=$stm->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
echo json_encode([
    "success"=>true,
    "data"=>$data
]);