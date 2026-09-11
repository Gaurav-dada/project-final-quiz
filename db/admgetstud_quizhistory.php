<?php

include("../db/connection.php");

header('Content-Type: application/json');

$category_id = $_GET['num'] ?? null;
$userId = $_GET['user_id'] ?? null;

if (!$category_id || !$userId) {
    echo json_encode([
        "success" => false,
        "message" => "Missing user_id or category_id",
        "data" => []
    ]);
    exit;
}

$sql = "SELECT
            id,
            user_id,
            category_id,
            attempt_id,
            score,
            total_questions
        FROM quiz_result
        WHERE category_id = ?
        AND user_id = ?
        ORDER BY attempt_id ASC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error,
        "data" => []
    ]);
    exit;
}

$stmt->bind_param("ii", $category_id, $userId);

$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();

echo json_encode([
    "success" => true,
    "data" => $data
]);

?>
