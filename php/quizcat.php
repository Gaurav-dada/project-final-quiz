<?php

session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quiz Categories</title>
  <link rel="stylesheet" href="../css/quizcat.css">
</head>
<body>

  <!-- Navigation Bar -->
    <nav class="navbar">

        <div class="logo">QuizMaster</div>

        <ul class="nav-links">
            <li><a href="studentpage.php" target="">Dashboard</a></li>
          
            <li><a href="quizcat.php" target="">Browse Quiz</a></li>
            <li><a href="stuquizhistory.php" target="">Result and Analysis</a></li>
        
        </ul>

        <a href="logout.php" class="logout">Logout</a>

    </nav>

<div class="container">

  <h1 class="title">Choose Quiz Category</h1>
  <p class="subtitle">Select a category to start your quiz challenge</p>

  <div class="grid">
  </div>

</div>

<script >
    
const grid=document.querySelector(".grid");


async function fetchcategory(){
    const res=await fetch('../db/getcategory.php');
    const data=await res.json();
   console.log(data);
     display_category(data);
}



async function display_category(data) {
    grid.innerHTML = "";
console.log(data)
    data.data.forEach(element => {
        const div = document.createElement("div");
        div.className = "card";
        div.dataset.id = element.id;


        const h = document.createElement("h3");
        const p = document.createElement("p");

       h.textContent = `${element.catagorie_name} - ${element.totalques} Questions`;
        p.textContent = element.description;

        div.appendChild(h);
        div.appendChild(p);

        div.addEventListener("click", async () => {
           
           currentCategory=div.dataset.id
            window.location.href = `../php/quiz.php?id=${div.dataset.id}`;
        });
        grid.appendChild(div);
    });
}


async function init(){
    await fetchcategory();
}
init();
</script>


</body>
</html>
