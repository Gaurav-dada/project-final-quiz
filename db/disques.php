<?php
include("connection.php");

header('Content-Type: application/json');

$category_id = $_GET['id'] ;

if (!$category_id) {
    echo json_encode([
        "success" => false,
        "message" => "catagorie_name is required"
    ]);
    exit;
}

$sql = "SELECT id,question, correct_answer FROM questions WHERE catagorie_id = ? AND is_active = 1;";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $category_id);

$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}
$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    "success" => true,
    "data" => $data
]);

exit;