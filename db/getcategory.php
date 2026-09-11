<?php
include("connection.php");

header('Content-Type: application/json');

$st = "SELECT id, catagorie_name ,description FROM catagories WHERE is_active=1";
$stm = $conn->prepare($st);

if (!$stm) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}

$stm->execute();
$result = $stm->get_result();

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
?>