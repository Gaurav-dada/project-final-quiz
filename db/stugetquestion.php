<?php
session_start();
include("connection.php");

header('Content-Type: application/json');
if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}
$userid=$_SESSION['user_id'];
$questionIds = [];


// Get question IDs
$stmt = $conn->prepare("SELECT id FROM questions");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $questionIds[] = $row['id'];
}

// Get user IDs
$stmt = $conn->prepare("SELECT id FROM users");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $userIds[] = $row['id'];
}

echo json_encode([
    "success" => true,
    "data"    => $questionIds,
    "user"    => $userIds
]);
?>