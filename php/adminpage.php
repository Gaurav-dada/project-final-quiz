<?php
session_start();

include("../db/connection.php");

$username = $_SESSION['username'] ?? null;
$user_id  = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/admin1.css">
        

</head>
<body>
   <div class="container">
    
        <nav class="navbar">

        <div class="logo">QuizMaster</div>

        <ul class="nav-links">
            <li><a href="adminpage.php" target="">Dashboard</a></li>
            <li><a href="category.php" target="">Manage Quiz</a></li>
            <li><a href="usermanage.php" target="">User Management</a></li>
            <li><a href="adminresultanalysis.php" target="">Result and Analysis</a></li>
        
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
            <h1>Quiz Stats</h1>
            
        </div>
        <div class="users">
            <div class="user">
                <div class="user-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/>
            </svg>
            </div>
            <div >
                <h2 id="users" ></h3>
                <h1>Total Users</h1>
            </div>
            </div>

            <div class="user" style="background-color:rgb(0, 119, 255)">
                <div class="user-logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M128 512C128 547.3 156.7 576 192 576L341.5 576C358.5 576 374.8 569.3 386.8 557.3L493.3 450.7C505.3 438.7 512 422.4 512 405.4L512 128C512 92.7 483.3 64 448 64L192 64C156.7 64 128 92.7 128 128L128 512zM336 517.5L336 424C336 410.7 346.7 400 360 400L453.5 400L336 517.5zM281 169L233 217C223.6 226.4 208.4 226.4 199.1 217C189.8 207.6 189.7 192.4 199.1 183.1L247.1 135.1C256.5 125.7 271.7 125.7 281 135.1C290.3 144.5 290.4 159.7 281 169zM377 201L265 313C255.6 322.4 240.4 322.4 231.1 313C221.8 303.6 221.7 288.4 231.1 279.1L343 167C352.4 157.6 367.6 157.6 376.9 167C386.2 176.4 386.3 191.6 376.9 200.9z"/>
            </svg>
            </div>
            <div>
                <h2 id="quesnum"></h2>
                    <h1>Total Questions</h1>
            </div>
            
</div>
            
             <div style=" color:white ; display:flex; gap:10px;  align-item:center;width:385px; height:100px; padding:20px 0px 20px 25px; ; border-radius:10px; background-color:pink">
                <p style="heigth:40px; width:40px; font-size:30px;">📖 </p>
                <div>
             <h2 id="catnum"  ></h2>
                    <h1 style="font-size: 16px;
    font-weight: 600;">Total Category</h1>
    </div
            </div>
        </div>
  </main>

</div>
<script>
   const quesnum = document.getElementById("quesnum");
    const usernum = document.getElementById("users");
    const catnum = document.getElementById("catnum");


    // Get total users and total questions
    async function ques_usernum() {

        try {

            const res = await fetch('../db/admin1.php');
            const rescat =await fetch('../db/getcategory.php');
            if (!res.ok) {
                throw new Error("Failed to fetch dashboard data");
            }

            const data = await res.json();
            const countcat=await rescat.json();
            console.log(countcat)
            // Total questions
            quesnum.textContent = data.data.length;

            // Total users
            usernum.textContent = data.user.length;

            //Total category
            catnum.textContent =countcat.data.length;
        } catch (error) {

            console.error("Dashboard error:", error);

        }

    }


    // Load dashboard statistics
    ques_usernum();

</script>
</body>
</html>