<?php

session_start();
include("connection.php");
include("auth.php");

header("Content-Type: application/json");

require_login();

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);

$attempt_id = $data['attempt_id'] ?? null;
$category_id = $data['category_id'] ?? null;


// Check received data
if (
    $attempt_id === null ||
    $category_id === null
) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data"
    ]);
    exit;
}

$attempt_id = (int)$attempt_id;
$category_id = (int)$category_id;


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


// Calculate score from saved answers
$sql = "SELECT COUNT(*) AS score
        FROM user_answer
        WHERE user_id = ? AND category_id = ? AND attempt_id = ? AND is_correct = 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("iii", $user_id, $category_id, $attempt_id);

$stmt->execute();

$row = $stmt->get_result()->fetch_assoc();

$score = (int)$row['score'];

$stmt->close();


// Count total questions of the category
$sql = "SELECT COUNT(*) AS total
        FROM questions
        WHERE catagorie_id = ? AND is_active = 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $category_id);

$stmt->execute();

$row = $stmt->get_result()->fetch_assoc();

$total_questions = (int)$row['total'];

$stmt->close();


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
        "message" => "Quiz submitted successfully",
        "score" => $score
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
