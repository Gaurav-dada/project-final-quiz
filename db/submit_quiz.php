<?php

session_start();
include("connection.php");

header("Content-Type: application/json");

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$attempt_id = $data['attempt_id'] ?? null;
$category_id = $data['category_id'] ?? null;
$score = $data['score'] ?? null;
$total_questions = $data['total_questions'] ?? null;


// Check received data
if (
    $attempt_id === null ||
    $category_id === null ||
    $score === null ||
    $total_questions === null
) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data"
    ]);
    exit;
}


// Insert final quiz result
$sql = "INSERT INTO quiz_result
        (user_id, attempt_id, category_id, score, total_questions)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "iiiii",
    $user_id,
    $attempt_id,
    $category_id,
    $score,
    $total_questions
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Quiz submitted successfully"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Insert failed: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();

?>
