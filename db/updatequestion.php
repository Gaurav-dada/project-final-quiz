<?php

include('connection.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

// Get form data
$category_id = $_GET['catyid'] ?? null;

$question_id = $_POST['question_id'] ?? null;
$question    = trim($_POST['question'] ?? '');

$opta = trim($_POST['opta'] ?? '');
$optb = trim($_POST['optb'] ?? '');
$optc = trim($_POST['optc'] ?? '');
$optd = trim($_POST['optd'] ?? '');

$correct = trim($_POST['correct'] ?? '');

// Validate IDs
if (!$question_id) {
    die("Question ID is missing.");
}

if (!$category_id) {
    die("Category ID is missing.");
}

$question_id = (int) $question_id;
$category_id = (int) $category_id;

// Validate fields
if (
    $question === '' ||
    $opta === '' ||
    $optb === '' ||
    $optc === '' ||
    $optd === '' ||
    $correct === ''
) {
    die("All fields are required.");
}

// Check correct answer
$options = [$opta, $optb, $optc, $optd];

if (!in_array($correct, $options, true)) {
    die("Correct answer must match one of the four options.");
}

// Start transaction
$conn->begin_transaction();

try {

    // Update question
    $sql = "UPDATE questions
            SET question = ?, correct_answer = ?
            WHERE id = ?";

    $stm = $conn->prepare($sql);

    if (!$stm) {
        throw new Exception($conn->error);
    }

    $stm->bind_param(
        "ssi",
        $question,
        $correct,
        $question_id
    );

    if (!$stm->execute()) {
        throw new Exception($stm->error);
    }

    $stm->close();


    // Get option IDs
    $sql = "SELECT id
            FROM optionss
            WHERE question_id = ?
            ORDER BY id ASC";

    $stm = $conn->prepare($sql);

    if (!$stm) {
        throw new Exception($conn->error);
    }

    $stm->bind_param("i", $question_id);
    $stm->execute();

    $result = $stm->get_result();

    $optionIds = [];

    while ($row = $result->fetch_assoc()) {
        $optionIds[] = (int) $row['id'];
    }

    $stm->close();


    // Make sure 4 options exist
    if (count($optionIds) < 4) {
        throw new Exception("This question does not have four options.");
    }


    // Update options
    $optionValues = [
        $opta,
        $optb,
        $optc,
        $optd
    ];

    $sql = "UPDATE optionss
            SET option_ = ?
            WHERE id = ? AND question_id = ?";

    $stm = $conn->prepare($sql);

    if (!$stm) {
        throw new Exception($conn->error);
    }

    for ($i = 0; $i < 4; $i++) {

        $optionId = $optionIds[$i];
        $optionValue = $optionValues[$i];

        $stm->bind_param(
            "sii",
            $optionValue,
            $optionId,
            $question_id
        );

        if (!$stm->execute()) {
            throw new Exception($stm->error);
        }
    }

    $stm->close();

    // Everything successful
    $conn->commit();

    header("Location: questionview.php?id=" . $category_id);
    exit;

} catch (Exception $e) {

    $conn->rollback();

    die("Update failed: " . $e->getMessage());
}

?>
