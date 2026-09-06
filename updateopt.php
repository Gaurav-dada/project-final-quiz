<?php

include('connection.php');

$question_id = $_GET['id'] ?? null;

if (!$question_id) {
    die("Question ID is missing.");
}

$question_id = (int)$question_id;

$sql = "SELECT * FROM optionss WHERE question_id = ?";

$stm = $conn->prepare($sql);
$stm->bind_param("i", $question_id);
$stm->execute();

$result = $stm->get_result();

$options = [];

while ($row = $result->fetch_assoc()) {
    $options[] = $row['option_text'];
}


?>
