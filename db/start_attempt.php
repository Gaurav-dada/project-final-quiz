<?php
session_start();
include("connection.php");
header('Content-Type:application/json');
$data=json_decode(file_get_contents("php://input"),true);
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}
$category_id=$data['category_id'];

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

