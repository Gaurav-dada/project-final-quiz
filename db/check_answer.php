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

$category_id = $data['category_id'] ?? null;
$question_id = $data['question_id'] ?? null;
$answer = $data['answer'] ?? null;
$attempt_id = $data['attempt_id'] ?? null;

if (
    $category_id === null ||
    $question_id === null ||
    $answer === null ||
    $attempt_id === null
) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data"
    ]);
    exit;
}


// Get correct answer
$sql = "SELECT correct_answer
        FROM questions
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $question_id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

$stmt->close();


// Check question
if (!$row) {
    echo json_encode([
        "success" => false,
        "message" => "Question not found"
    ]);
    exit;
}


// Check answer
$is_correct = ($answer == $row['correct_answer']) ? 1 : 0;


// Insert answer
$sql = "INSERT INTO user_answer
        (user_id, attempt_id, category_id, question_id, answer, is_correct)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "iiiisi",
    $user_id,
    $attempt_id,
    $category_id,
    $question_id,
    $answer,
    $is_correct
);


// Execute insert
if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "is_correct" => $is_correct
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Failed to save answer: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();

?>

