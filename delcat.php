<?php
include('connection.php');
$category_id = $_GET['id'];
 try {

    if (!$category_id) {
        throw new Exception("Category ID is missing");
    }

    $category_id = (int)$category_id;

    $conn->begin_transaction();

    // Delete options
    $stm = $conn->prepare(
        "DELETE FROM optionss WHERE category_id = ?"
    );

    if (!$stm) {
        throw new Exception("Failed to prepare options query");
    }

    $stm->bind_param("i", $category_id);

    if (!$stm->execute()) {
        throw new Exception("Failed to delete options");
    }

    $stm->close();


    // Delete questions
    $stm = $conn->prepare(
        "DELETE FROM questions WHERE catagorie_id = ?"
    );

    if (!$stm) {
        throw new Exception("Failed to prepare questions query");
    }

    $stm->bind_param("i", $category_id);

    if (!$stm->execute()) {
        throw new Exception("Failed to delete questions");
    }

    $stm->close();


    // Delete category
    $stm = $conn->prepare(
        "DELETE FROM catagories WHERE id = ?"
    );

    if (!$stm) {
        throw new Exception("Failed to prepare category query");
    }

    $stm->bind_param("i", $category_id);

    if (!$stm->execute()) {
        throw new Exception("Failed to delete category");
    }

    $stm->close();


    // Everything succeeded
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Category deleted successfully"
    ]);

} catch (Exception $e) {

    // Undo all deletes if anything failed
    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>