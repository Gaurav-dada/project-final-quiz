<?php
session_start();
include("connection.php");
include("auth.php");
require_login();
header('Content-Type:application/json');

$category_id = (int)($_GET['num'] ?? 0);
$userId = $_SESSION['user_id'];

// only submitted attempts (quiz_result), latest attempt first
$sql = "SELECT attempt_id, score, total_questions
        FROM quiz_result
        WHERE category_id = ? AND user_id = ?
        ORDER BY attempt_id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $category_id, $userId);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
