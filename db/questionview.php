<?php
include('connection.php');

// Get category ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid category ID");
}

$category_id = (int) $_GET['id'];

// Get category information
$sql = "SELECT * FROM catagories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();

$category_result = $stmt->get_result();

if ($category_result->num_rows == 0) {
    die("Category not found");
}

$category = $category_result->fetch_assoc();


// Get questions from this category
$sql = "SELECT * FROM questions WHERE catagorie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();

$question_result = $stmt->get_result();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Questions</title>

    <link rel="stylesheet" href="../css/questionview.css">
</head>

<body>

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


<main class="main-content">

    <div class="page-header">
        <div>
            <h1>
                <?= htmlspecialchars($category['catagorie_name']) ?>
            </h1>

            <p>
                <?= htmlspecialchars($category['description']) ?>
            </p>
        </div>
    </div>


    <section class="crud-section">

        <div class="section-header">

            <div>
                <h2>Question List</h2>
            </div>

            <button onclick='addQuestion(
    <?= $category_id ?>,
    <?= json_encode($category['catagorie_name']) ?>
)'>
    Add Question
</button>


        </div>


        <div class="table-container">

            <table border="1">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php

                if ($question_result->num_rows > 0) {

                   while ($row = $question_result->fetch_assoc()) {

    echo "<tr>";

    echo "<td>" . $row['id'] . "</td>";

    echo "<td>" . htmlspecialchars($row['question']) . "</td>";

    // Get options for THIS question
    $sql = "SELECT * FROM optionss WHERE question_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $row['id']);
    $stmt->execute();

    $options_result = $stmt->get_result();

    while ($option = $options_result->fetch_assoc()) {

        echo "<td>" . htmlspecialchars($option['option_']) . "</td>";
    }

    echo "<td>" . htmlspecialchars($row['correct_answer']) . "</td>";

 echo "<td>
        <button onclick='editQuestion(" . $category_id . "," . $row['id'] . ")'>
            Edit
        </button>

        <button onclick='deleteQuestion(" . $row['id'] . ")'>
            Delete
        </button>
      </td>";


    echo "</tr>";
}

                    }

                 else {

                    echo "<tr>";
                    echo "<td colspan='8'>No questions found.</td>";
                    echo "</tr>";
                }

                ?>

                </tbody>

            </table>

        </div>

    </section>

</main>


<script>

function addQuestion(categoryId, categoryName) {
    window.location.href =
        `addques.php?category_id=${categoryId}&category_name=${encodeURIComponent(categoryName)}`;
}


function editQuestion(categoryId,questionId) {
    window.location.href = `editquestion.php?catid=${categoryId}&id=${questionId}`;
}


async function deleteQuestion(questionId) {

    let confirmDelete = confirm(
        "Are you sure you want to delete this question?"
    );

    if (confirmDelete) {

        const response = await fetch(
            `deletequestion.php?id=${questionId}`
        );

        const data = await response.json();

        console.log(data);
        window.location.reload();

        
    }

}

</script>

</body>
</html>
