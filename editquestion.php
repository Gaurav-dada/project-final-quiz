


<?php

include('connection.php');

$category_id = $_GET['catid'] ?? null;
$question_id = $_GET['id'] ?? null;

if (!$category_id) {
    die("Category ID is missing.");
}

if (!$question_id) {
    die("Question ID is missing.");
}

$category_id = (int)$category_id;
$question_id = (int)$question_id;



// Get question
$sql = "SELECT * FROM questions WHERE id = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("i", $question_id);
$stm->execute();

$result = $stm->get_result();

if ($result->num_rows === 0) {
    die("Question not found.");
}

$questionData = $result->fetch_assoc();


// Get options
$sql = "SELECT * 
        FROM optionss 
        WHERE question_id = ?
        ORDER BY id";

$stm = $conn->prepare($sql);
$stm->bind_param("i", $question_id);
$stm->execute();

$optionsResult = $stm->get_result();

$options = [];

while ($row = $optionsResult->fetch_assoc()) {
    $options[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Question</title>

    <link rel="stylesheet" href="addques.css">
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


<main id="container">

    <form method="POST" action="updatequestion.php?catyid=<?= $category_id ?>">


        <input
            type="hidden"
            name="question_id"
            value="<?= htmlspecialchars($questionData['id']) ?>"
        >


        <label for="question">
            Question:
        </label>

        <br>

        <input
            type="text"
            id="question"
            name="question"
            value="<?= htmlspecialchars($questionData['question']) ?>"
            placeholder="Enter question"
            required
        >

        <br><br>


        <label>
            Options:
        </label>

        <br>

        <div id="options">

           <input
    type="text"
    name="opta"
    class="opt"
    value="<?= htmlspecialchars($options[0]['option_'] ?? '') ?>"
    placeholder="Option A"
    required
>

<input
    type="text"
    name="optb"
    class="opt"
    value="<?= htmlspecialchars($options[1]['option_'] ?? '') ?>"
    placeholder="Option B"
    required
>

<input
    type="text"
    name="optc"
    class="opt"
    value="<?= htmlspecialchars($options[2]['option_'] ?? '') ?>"
    placeholder="Option C"
    required
>

<input
    type="text"
    name="optd"
    class="opt"
    value="<?= htmlspecialchars($options[3]['option_'] ?? '') ?>"
    placeholder="Option D"
    required
>


        </div>

        <br><br>


        <label for="correct">
            Correct Answer:
        </label>

        <br>

        <input
            type="text"
            id="correct"
            name="correct"
            value="<?= htmlspecialchars($questionData['correct'] ?? '') ?>"
            placeholder="Enter correct answer"
            required
        >

        <br><br>


        <button type="submit" name="submit">
            Update Question
        </button>

        <button type="reset">
            Reset
        </button>

    </form>

</main>

</body>
</html>
