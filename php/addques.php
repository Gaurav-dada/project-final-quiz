<?php
session_start();

include("../db/connection.php");

$username = $_SESSION['username'] ?? null;
$user_id  = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location:login.php");
    exit;
}
$user_id=$_SESSION['user_id'];
if (isset($_POST['submit'])) {
    $category_name=(string) $_GET['category_name'];
    $category_id = (int) $_GET['category_id'];
    $question    = $_POST['question'];
    $opt_a       = $_POST['opta'];
    $opt_b       = $_POST['optb'];
    $opt_c       = $_POST['optc'];
    $opt_d       = $_POST['optd'];
    $correct     = $_POST['correct'];
           // Check duplicate question in same category
    $check = "SELECT id FROM questions 
              WHERE catagorie_id = ? AND question = ?";

    $checkStmt = $conn->prepare($check);
    $checkStmt->bind_param("is", $category_id, $question);
    $checkStmt->execute();

    if ($checkStmt->get_result()->num_rows > 0) {
        echo "<script>
                alert('This question already exists in this category.');
                history.back();
              </script>";
        exit;
    }
      
    // Check that all options are different
    $options = [$opt_a, $opt_b, $opt_c, $opt_d];

    if (count(array_unique($options)) !== 4) {
        echo "<script>
                alert('All four options must be different.');
                history.back();
              </script>";
        exit;
    }
       // Correct answer must be one of the options
    if (!in_array($correct, $options, true)) {
        echo "<script>
                alert('Correct answer must match one of the options.');
                history.back();
              </script>";
        exit;
    }
    try {
          $conn->begin_transaction();
 
        // Insert question
        $st = "INSERT INTO questions
               (catagorie_id, question, correct_answer, category_name)
               VALUES (?, ?, ?, ?)";

        $sql = $conn->prepare($st);

        if (!$sql) {
            throw new Exception($conn->error);
        }

        $sql->bind_param(
            "isss",
            $category_id,
            $question,
            $correct,
            $category_name
        );

        $sql->execute();

        $question_id = $conn->insert_id;


        // Insert options
        $options = [
            $opt_a,
            $opt_b,
            $opt_c,
            $opt_d
        ];

        $st = "INSERT INTO optionss
               (category_name, category_id, option_, is_correct, question_id)
               VALUES (?, ?, ?, ?, ?)";

        $stm = $conn->prepare($st);

        if (!$stm) {
            throw new Exception($conn->error);
        }

        foreach ($options as $option) {

            $is_correct = ($option === $correct) ? 1 : 0;

            $stm->bind_param(
                "sisii",
                $category_name,
                $category_id,
                $option,
                $is_correct,
                $question_id
            );
            $stm->execute();
        }

// Increase total question count
$update = "UPDATE catagories
           SET totalques = totalques + 1
           WHERE id = ?";

$updateStmt = $conn->prepare($update);

if (!$updateStmt) {
    throw new Exception($conn->error);
}

$updateStmt->bind_param("i", $category_id);
$updateStmt->execute();
        // Everything succeeded
        $conn->commit();

        echo "<script>
                alert('Question Added Successfully');
                
              </script>";
               header("Location: questionview.php?id=" . $category_id);
        exit();

    } catch (Exception $e) {

        $conn->rollback();

        echo "<script>
                alert('Unsuccessful: " . addslashes($e->getMessage()) . "');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Category</title>

    <link rel="stylesheet" href="../css/addques.css">
</head>

<body>

  
    <!-- Navigation Bar -->
    <nav class="navbar">

        <div class="logo">QuizMaster</div>

        <ul class="nav-links">
            <li><a href="adminpage.php" target="">Dashboard</a></li>
            <li><a href="category.php" target="">Manage Quiz</a></li>
            <li><a href="usermanage.php" target="">User Management</a></li>
            <li><a href="adminresultanalysis.php" target="">Result and Analysis</a></li>
        
        </ul>

        <a href="logout.php" class="logout">Logout</a>

    </nav>


    <main id="container">

        <form method="POST" action="">

            <label for="question">
                Question:
            </label>

            <br>

            <input
                type="text"
                id="question"
                name="question"
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
                    placeholder="Option A"
                    required
                >

                <input
                    type="text"
                    name="optb"
                    class="opt"
                    placeholder="Option B"
                    required
                >

                <input
                    type="text"
                    name="optc"
                    class="opt"
                    placeholder="Option C"
                    required
                >

                <input
                    type="text"
                    name="optd"
                    class="opt"
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
                placeholder="Enter correct answer"
                required
            >

            <br><br>


            <button type="submit" name="submit">
                Add Question
            </button>

            <button type="reset">
                Clear
            </button>

        </form>

    </main>

</body>
</html>
