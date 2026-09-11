<?php
include("../db/connection.php");
header('Content-Type:application/json');
$userid=$_GET['userid'];
$catid=$_GET['catid'];
$attid=$_GET['attid'];

$st="SELECT question_id,answer FROM user_answer WHERE user_id=? AND attempt_id=? AND category_id=?";
$stm=$conn->prepare($st);
$stm->bind_param("iii",$userid,$attid,$catid);
$stm->execute();
$result=$stm->get_result();
$row=[];
while($data=$result->fetch_assoc()){
    $row[]=$data;
}
$question=[];
$st="SELECT id, question,correct_answer FROM questions WHERE id=? AND catagorie_id=?";
$stm=$conn->prepare($st);

foreach($row as $ro){
    $ques=$ro['question_id'];
    $stm->bind_param("ii",$ques,$catid);
$stm->execute();
$result=$stm->get_result();



while($r=$result->fetch_assoc()){
    $question[]=$r;
}}
echo json_encode([
    "success"=>true,
    "data"=>$row,
    "question"=>$question
]);