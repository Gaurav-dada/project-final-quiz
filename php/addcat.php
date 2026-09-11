<?php

session_start();

include("../db/connection.php");

$username = $_SESSION['username'] ?? null;
$user_id  = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: ../login.php");
    exit;
}


if (isset($_POST['submit'])) {

    $category    = trim($_POST['categoryName']);
    $description = trim($_POST['description']);

    // Basic validation
    if (empty($category) || empty($description)) {
        echo "<script>
                alert('Please fill in all fields.');
                window.history.back();
              </script>";
        exit();
    }

    try {

        // Start transaction
        $conn->begin_transaction();

        // Insert category
        $sql = "INSERT INTO catagories 
                (catagorie_name, description)
                VALUES (?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception($conn->error);
        }

        $stmt->bind_param("ss", $category, $description);

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        // Get inserted category ID
        $category_id = $conn->insert_id;

        // Commit transaction
        $conn->commit();

        echo "<script>
                alert('Category Created Successfully!');
                window.location.href='category.php';
              </script>";
        exit();

    } catch (Exception $e) {

        // Rollback if something goes wrong
        $conn->rollback();

        echo "<script>
                alert('Unsuccessful: " . $e->getMessage() . "');
                window.history.back();
              </script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/addques.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">

        <div class="logo">QuizMaster</div>

        <ul class="nav-links">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#" class="active">Manage Quiz</a></li>
            <li><a href="#">User Management</a></li>
            <li><a href="#">Result</a></li>
            <li><a href="#">Analysis</a></li>
        </ul>

        <a href="#" class="logout">Logout</a>

    </nav>


    <main id="container">

        <form method="POST" action="">

            <label for="categoryName">
                Category Name:
            </label>

            <br>

            <input
                type="text"
                id="categoryName"
                name="categoryName"
                placeholder="Enter category name"
                required
            >

            <br><br>


            <label for="description">
                Description:
            </label>

            <br>

            <textarea
                id="description"
                name="description"
                placeholder="Enter category description"
                rows="4"
                cols="40"
                required
            ></textarea>

            <br><br>

            
            <button type="submit" name="submit">
                Add Category
            </button>

            <button type="reset">
                Clear
            </button>
</form>
</main>
</body>
</html>