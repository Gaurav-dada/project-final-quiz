<?php
include("connection.php");
header('Content-Type:application/json');
$id=$_GET['userid'];
$st = "SELECT * FROM users WHERE id = ?";
$stm = $conn->prepare($st);
$stm->bind_param("i", $id);
$stm->execute();
$result = $stm->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode([
    "success" => true,
    "data" => $data
]);
?>



