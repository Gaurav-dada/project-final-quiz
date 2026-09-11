<?php
// session_start();
include("connection.php");
header('Content-Type:application/json');
$id=$_GET['id'];
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(["error" => "Not logged in"]);
//     exit();
// }

// $userId = $_SESSION['user_id'];

$sql = "SELECT category_id FROM user_answer WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sql = "SELECT catagorie_name,id FROM catagories WHERE id = ?";
$stmt = $conn->prepare($sql);
$da = [];
foreach($data as $dat){
    $id=$dat['category_id'];
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();


while ($ro = $res->fetch_assoc()) {
    $da[] = $ro;
}
}


echo json_encode([
    "success"=>true,
    "data"=>$da
]);