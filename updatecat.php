<?php

include('connection.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$category = $data['category'] ?? null;
$description = $data['description'] ?? null;

try {

    if (!$id || $category === null || $description === null) {
        throw new Exception("Missing required data");
    }

    $conn->begin_transaction();

    $sql = "UPDATE catagories 
            SET catagorie_name = ?, description = ? 
            WHERE id = ?";

    $stm = $conn->prepare($sql);

    if (!$stm) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stm->bind_param("ssi", $category, $description, $id);

    if (!$stm->execute()) {
        throw new Exception("Update unsuccessful: " . $stm->error);
    }

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Category updated successfully"
    ]);

} catch (Exception $e) {

    $conn->rollback();

    
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
