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
    
    <header class="header">
        
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/>
        </svg>

        <p>Hello!<br>
           <?php echo $username;?>
        </p>
          </header>

  <aside class="sidebar">
     <div id="dashboard">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/>
        </svg>
        <a href="studentpage.php" target="">My Profile</a>
    </div>

    <div id="create">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M192 576L512 576C529.7 576 544 561.7 544 544C544 526.3 529.7 512 512 512L512 445.3C530.6 438.7 544 420.9 544 400L544 112C544 85.5 522.5 64 496 64L192 64C139 64 96 107 96 160L96 480C96 533 139 576 192 576zM160 480C160 462.3 174.3 448 192 448L448 448L448 512L192 512C174.3 512 160 497.7 160 480zM406.6 272L375 272C373.6 295.1 369 316.2 362.4 333.2C385.1 320.7 401.8 298.4 406.6 272zM233.5 272C238.3 298.4 255 320.7 277.7 333.2C271 316.2 266.5 295.2 265.1 272L233.5 272zM309.9 327C314.4 336.6 318.1 340.8 320.1 342.5C322.1 340.8 325.8 336.7 330.3 327C336.5 313.6 341.4 294.5 343 272L297.2 272C298.8 294.5 303.7 313.6 309.9 327zM297.2 240L343 240C341.4 217.5 336.5 198.4 330.3 185C325.8 175.4 322.1 171.2 320.1 169.5C318.1 171.2 314.4 175.3 309.9 185C303.7 198.4 298.8 217.5 297.2 240zM406.7 240C401.9 213.6 385.2 191.3 362.5 178.8C369.2 195.8 373.7 216.8 375.1 240L406.7 240zM265 240C266.4 216.9 271 195.8 277.6 178.8C254.9 191.3 238.2 213.6 233.4 240L265 240zM192 256C192 185.3 249.3 128 320 128C390.7 128 448 185.3 448 256C448 326.7 390.7 384 320 384C249.3 384 192 326.7 192 256z"/></svg>
        <a href="../php/quizcat.php" target="">Browse Quiz</a>
    </div>

    

    <div id="result">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path d="M544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM352 216C352 229.3 341.3 240 328 240L216 240C202.7 240 192 229.3 192 216C192 202.7 202.7 192 216 192L328 192C341.3 192 352 202.7 352 216zM424 296C437.3 296 448 306.7 448 320C448 333.3 437.3 344 424 344L216 344C202.7 344 192 333.3 192 320C192 306.7 202.7 296 216 296L424 296zM288 424C288 437.3 277.3 448 264 448L216 448C202.7 448 192 437.3 192 424C192 410.7 202.7 400 216 400L264 400C277.3 400 288 410.7 288 424z"/>
        </svg>
        <a href="../php/stuquizhistory.php" target="">Quiz History & Result</a>
    </div>

    <div id="logout">
        <img src="../image/logout.png">
        <a href="../php/logout.php">Logout</a>
    </div>
  </aside>

  
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

          <div class="user" style="background-color:rgb(0, 119, 255)">
              <div class="user-logo">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M128 512C128 547.3 156.7 576 192 576L341.5 576C358.5 576 374.8 569.3 386.8 557.3L493.3 450.7C505.3 438.7 512 422.4 512 405.4L512 128C512 92.7 483.3 64 448 64L192 64C156.7 64 128 92.7 128 128L128 512zM336 517.5L336 424C336 410.7 346.7 400 360 400L453.5 400L336 517.5zM281 169L233 217C223.6 226.4 208.4 226.4 199.1 217C189.8 207.6 189.7 192.4 199.1 183.1L247.1 135.1C256.5 125.7 271.7 125.7 281 135.1C290.3 144.5 290.4 159.7 281 169zM377 201L265 313C255.6 322.4 240.4 322.4 231.1 313C221.8 303.6 221.7 288.4 231.1 279.1L343 167C352.4 157.6 367.6 157.6 376.9 167C386.2 176.4 386.3 191.6 376.9 200.9z"/>
        </svg>
        </div>
        <div>
            <h2 id="stuques"></h2>
                <h1>Total Questions</h1>
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
