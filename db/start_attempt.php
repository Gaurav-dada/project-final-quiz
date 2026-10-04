<?php
session_start();
include("connection.php");
include("auth.php");
header('Content-Type:application/json');
require_login();
$data=json_decode(file_get_contents("php://input"),true);
$user_id = $_SESSION['user_id'];
$category_id=(int)($data['category_id'] ?? 0);

$st="SELECT id FROM catagories WHERE id=? AND is_active=1";
$stm=$conn->prepare($st);
$stm->bind_param("i",$category_id);
$stm->execute();
if($stm->get_result()->num_rows===0){
    echo json_encode([
        "success"=>false,
        "message"=>"Category not found"
    ]);
    exit;
}

$st="SELECT MAX(attempt_id) AS attempt_no FROM quiz_attempts WHERE user_id=? AND category_id=?";
$stm=$conn->prepare($st);
$stm->bind_param("ii",$user_id,$category_id);
$stm->execute();
$result=$stm->get_result();
$row = $result->fetch_assoc();
$attempt_no=0;
if($row['attempt_no']==null){
    $attempt_no=1;
}
else{
    $attempt_no=$row['attempt_no']+1;
}

$st="INSERT INTO quiz_attempts(user_id,category_id,attempt_id) VALUES(?,?,?)";
$stm=$conn->prepare($st);
$stm->bind_param("iii",$user_id,$category_id,$attempt_no);
$stm->execute();
echo json_encode([
    "success"=>true,
    "attemptid"=>$attempt_no
]);
