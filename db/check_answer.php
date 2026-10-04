<?php

session_start();
include("connection.php");
include("auth.php");

header("Content-Type: application/json");

require_login();

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);

$category_id = $data['category_id'] ?? null;
$question_id = $data['question_id'] ?? null;
$answer = $data['answer'] ?? null;
$attempt_id = $data['attempt_id'] ?? null;

if (
    $category_id === null ||
    $question_id === null ||
    $answer === null ||
    $attempt_id === null ||
    !is_string($answer)
) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data"
    ]);
    exit;
}


$category_id = (int)$category_id;
$question_id = (int)$question_id;
$attempt_id = (int)$attempt_id;


// Check attempt belongs to this user
$sql = "SELECT id
        FROM quiz_attempts
        WHERE user_id = ? AND category_id = ? AND attempt_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("iii", $user_id, $category_id, $attempt_id);

$stmt->execute();

if ($stmt->get_result()->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid attempt"
    ]);
    exit;
}

$stmt->close();


// Check quiz is not already submitted
$sql = "SELECT id
        FROM quiz_result
        WHERE user_id = ? AND category_id = ? AND attempt_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("iii", $user_id, $category_id, $attempt_id);

$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Quiz already submitted"
    ]);
    exit;
}

$stmt->close();


// Check question is not already answered
$sql = "SELECT id
        FROM user_answer
        WHERE user_id = ? AND category_id = ? AND attempt_id = ? AND question_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("iiii", $user_id, $category_id, $attempt_id, $question_id);

$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Question already answered"
    ]);
    exit;
}

$stmt->close();


// Get correct answer
$sql = "SELECT correct_answer
        FROM questions
        WHERE id = ? AND catagorie_id = ? AND is_active = 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ii", $question_id, $category_id);

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
$is_correct = ($answer !== "" && $answer === $row['correct_answer']) ? 1 : 0;


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

