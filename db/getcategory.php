<?php
include("connection.php");
include("auth.php");
require_login();

header('Content-Type: application/json');

$st = "SELECT c.id, c.catagorie_name, c.description,
        (SELECT COUNT(*) FROM questions q WHERE q.catagorie_id = c.id AND q.is_active = 1) AS totalques
        FROM catagories c WHERE c.is_active = 1";
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