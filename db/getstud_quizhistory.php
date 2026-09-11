<?php
session_start();
include("connection.php");
header('Content-Type:application/json');
$category_id=$_GET['num'];
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM user_answer WHERE category_id=? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $category_id,$userId);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "success"=>true,
    "data"=>$data
]);