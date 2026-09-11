<?php

include('connection.php');

header('Content-Type: application/json');

$question_id = $_GET['id'] ?? null;

try {

    // Validate question ID
    if (!$question_id || !is_numeric($question_id)) {
        throw new Exception("Valid Question ID is required");
    }

    $question_id = (int) $question_id;

    // Start transaction
    $conn->begin_transaction();

    // Soft delete question
    $stmt = $conn->prepare(
        "UPDATE questions
         SET is_active = 0
         WHERE id = ?"
    );

    if (!$stmt) {
        throw new Exception("Failed to prepare questions query");
    }

    $stmt->bind_param("i", $question_id);

    if (!$stmt->execute()) {
        throw new Exception("Failed to deactivate question");
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Question not found");
    }

    $stmt->close();

    // Do NOT delete options.
    // They may be needed for previous student attempts.

    // Everything succeeded
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Question deactivated successfully"
    ]);

} catch (Exception $e) {

    // Rollback transaction
    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
