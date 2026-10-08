<?php

include("../db/connection.php");
include("../db/auth.php");
require_admin();

header('Content-Type: application/json');

$attempt_id = $_GET['attempt_id'] ?? null;
$userId     = $_GET['id'] ?? null;
$category_id = $_GET['category_id'] ?? null;

try {

    if (!$attempt_id || !$userId || !$category_id) {
        throw new Exception("Attempt ID, User ID or Category ID is missing");
    }

    $attempt_id = (int)$attempt_id;
    $userId     = (int)$userId;
    $category_id = (int)$category_id;


    $sql = "
        SELECT *
        FROM user_answer
        WHERE attempt_id = ?
        AND user_id = ?
        AND category_id = ?
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare answer query");
    }

    $stmt->bind_param("iii", $attempt_id, $userId, $category_id);

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute answer query");
    }

    $result = $stmt->get_result();

    $answers = [];

    while ($data = $result->fetch_assoc()) {
        $answers[] = $data;
    }

    $stmt->close();


  
    // GET QUIZ RESULT
   

    $sql = "
        SELECT total_questions, score
        FROM quiz_result
        WHERE attempt_id = ?
        AND user_id = ?
        AND category_id = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare quiz result query");
    }

    $stmt->bind_param("iii", $attempt_id, $userId, $category_id);

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute quiz result query");
    }

    $result = $stmt->get_result();

    $quizResult = $result->fetch_assoc();

    $stmt->close();


    if (!$quizResult) {
        throw new Exception("Quiz result not found");
    }


    
    // RESPONSE
  

    echo json_encode([
        "success" => true,
        "total_questions" => (int)$quizResult['total_questions'],
        "score" => (int)$quizResult['score'],
        "data" => $answers
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>

