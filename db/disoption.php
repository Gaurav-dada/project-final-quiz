<?php
include("connection.php");
header('Content-Type: application/json');
$category_id=$_GET['id'];
if(!$category_id){
    echo json_encode([
        "success"=>false,
        "message"=>"category_id is required"
    ]);
    exit;
}
$sql="SELECT option_,is_correct,question_id FROM optionss WHERE category_id=?";

$st=$conn->prepare($sql);

if(!$st){
       echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}

$st->bind_param("i",$category_id);
$st->execute();

$result=$st->get_result();
$data=$result->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    "success"=>true,
    "data"=>$data
]);
exit;









