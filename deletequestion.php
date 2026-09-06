<?php
include('connection.php');
$question_id=$_GET['id'];
$category_id = $_GET['id'];
 try {

    if (!$question_id) {
        throw new Exception("Question ID is missing");
    }

    $category_id = (int)$category_id;

    $conn->begin_transaction();

    // Delete options
    $stm = $conn->prepare(
        "DELETE FROM optionss WHERE question_id = ?"
    );

    if (!$stm) {
        throw new Exception("Failed to prepare options query");
    }

    $stm->bind_param("i", $question_id);

    if (!$stm->execute()) {
        throw new Exception("Failed to delete options");
    }

    $stm->close();


    // Delete questions
    $stm = $conn->prepare(
        "DELETE FROM questions WHERE id = ?"
    );

    if (!$stm) {
        throw new Exception("Failed to prepare questions query");
    }

    $stm->bind_param("i", $question_id);

    if (!$stm->execute()) {
        throw new Exception("Failed to delete questions");
    }

  


   
    $stm->close();


    // Everything succeeded
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Question deleted successfully"
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