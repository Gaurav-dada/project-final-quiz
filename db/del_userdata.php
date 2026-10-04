<?php
include("connection.php");
include("auth.php");
require_admin();

header('Content-Type: application/json');

if (!isset($_GET['userid'])) {
    echo json_encode([
        "success" => false,
        "message" => "User ID missing"
    ]);
    exit;
}

$id = $_GET['userid'];

$conn->begin_transaction();

$success = true;



  $st = "UPDATE users SET is_active =0 WHERE id = ? AND role <> 'admin'";
    $stm = $conn->prepare($st);

    if (!$stm) {
        $success = false;
    }

    $stm->bind_param("i", $id);

    if (!$stm->execute()) {
        $success = false; 
         echo $stm->error;  
    }

    if ($stm->affected_rows === 0) {
        $success = false;
    }

    $stm->close();

if ($success) {
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "User and related data deleted successfully"
    ]);
} else {
    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => "Deletion failed"
    ]);
}
?>