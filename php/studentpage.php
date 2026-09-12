<?php

session_start();

include("../db/connection.php");
if(!isset($_SESSION['user_id'])){
   header('Location: /../php/login.php');
    exit();
}
$username=$_SESSION['username'];
$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/student.css">
        

</head>
<body>
   <div class="container">
   
        <nav class="navbar">

        <div class="logo">QuizMaster</div>

        <ul class="nav-links">
            <li><a href="studentpage.php" target="">Dashboard</a></li>
            
            <li><a href="quizcat.php" target="">Browse Quiz</a></li>
            <li><a href="stuquizhistory.php" target="">Result and Analysis</a></li>
        
        </ul>
        <div class="main-profile">
        <div class="profile">
            <div class="profimg">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/>
        </svg>
        <p style="width:115px; font-size:13px; white-space:nowrap;">
    <?php echo $username; ?>
</p>
            </div>
        <a href="logout.php" class="logout">Logout</a>
</div>
</div>
    </nav>

  
  <main class="content">
    <div class="stats">
        <h1>My DashBoard</h1>
    </div>
    <div class="users">
        <div class="user">
            <div class="user-logo">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/>
        </svg>
        </div>
        <div>
            <h2></h2>
            <h1>Total Quizes Completed</h1>
        </div>
        </div>

         
        </div>
    </div>
  </main>
  
</div>
<script >
    const studques=document.getElementById("stuques");
const attemptno=document.getElementById("attempt");
async function studquesno(){
    const res=await fetch('../db/stugetquestion.php');
    const data=await res.json();
    if(!data.success){
        header('Location: ../php/login.php');
    }
    let queslength=data.data.length;
    studques.textContent=queslength;
}
studquesno();
</script>
</body>
</html>
