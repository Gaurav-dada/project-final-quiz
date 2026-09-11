<?php
include('connection.php');
$st="SELECT id, fullname,email,username FROM users WHERE is_active=1";
$stm=$conn->prepare($st);
$stm->execute();
$result=$stm->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);
echo json_encode([
    "success"=>true,
    "data"=>$data
]);