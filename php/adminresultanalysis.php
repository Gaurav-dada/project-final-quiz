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
    <link rel="stylesheet" href="../css/result.css">
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
    <div class="container">
        <header id="header">
              <div id="result">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path d="M544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM352 216C352 229.3 341.3 240 328 240L216 240C202.7 240 192 229.3 192 216C192 202.7 202.7 192 216 192L328 192C341.3 192 352 202.7 352 216zM424 296C437.3 296 448 306.7 448 320C448 333.3 437.3 344 424 344L216 344C202.7 344 192 333.3 192 320C192 306.7 202.7 296 216 296L424 296zM288 424C288 437.3 277.3 448 264 448L216 448C202.7 448 192 437.3 192 424C192 410.7 202.7 400 216 400L264 400C277.3 400 288 410.7 288 424z"/>
                    </svg>
                    <a href="#">Result & Analysis</a>
               </div>
               <div class="category">
                    <div class="select_name">
                        <select>
                         
                        </select>
                    </div>
                    <div class="select_cate">
                         <select>
                            
                        </select>
                    </div>
               </div>
        </header>
        <section id="section">
           <div class="result-summary">
                <h2>Quiz Result</h2>
               <div class="attemptnum">
                    <label for="attempt">Attempt:</label>
                    <select id="attempt">
                        <!-- <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option> -->
                    </select>
                </div>
                <div class="score-box">
                    <p id="tolques"></p>
                    <p id="totalatte"></p>
                    <p id="correctans"></p>
                    <p id="wrongans"></p>
                    <p id="notans"></p>
                    <h3 id="score"></h3>
                </div>
            </div>

           
            <div class="analysis">

            </div>
        </section>
    </div>
    <script >
        document.addEventListener("DOMContentLoaded", () => {
    const sel_name=document.querySelector(".select_name select");
const sel_cat=document.querySelector(".select_cate select");
const section=document.getElementById("section") ;
const scorebox=document.querySelector(".score-box")
const tolques=document.getElementById("tolques");
const attemptno=document.getElementById("attempt");
const totalAttempted= document.getElementById("totalatte");
const correctAnswers= document.getElementById("correctans");
const wrongAnswers= document.getElementById("wrongans");
const notans=document.getElementById("notans");
const score=document.getElementById("score");

const analysis = document.querySelector(".analysis");





        // fetch category and display category
    let userid=null;
    async function username(){
        const res=await fetch("../db/user_data.php");
        const data=await res.json();
        sel_name.innerHTML="";
         const placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.textContent = "Select Username";
            placeholder.disabled = true;
            placeholder.selected = true;
            sel_name.appendChild(placeholder);
        data.data.forEach(element=>{
                 const option = document.createElement("option");
           option.value = element.id;
            option.textContent = element.fullname;
         sel_name.appendChild(option);
        })

    }   
    username();
    sel_name.addEventListener("change",()=>{
        userid=sel_name.value;
        section.style.display="none";
        analysis.style.display="none";
        showcategory(userid)
    })
    
async function showcategory(id) {

    try {

        const res = await fetch(`../db/getusercategory.php?id=${id}`);

        if (!res.ok) {
            throw new Error("Failed to fetch categories");
        }

        const data = await res.json();

        console.log(data);

        // Remove duplicate categories
        const arr = [
            ...new Map(
                data.data.map(item => [
                    item.catagorie_id,
                    item
                ])
            ).values()
        ];

        console.log(arr);

        // Clear select
        sel_cat.innerHTML = "";

        // Placeholder
        const placeholder = document.createElement("option");
        placeholder.value ="";
          placeholder.textContent = "Select Category";
        placeholder.disabled = true;
        placeholder.selected = true;
        sel_cat.appendChild(placeholder);
        // Add categories
        arr.forEach(element => {
    console.log(element)
            const option = document.createElement("option");

            option.value = element.id;

            option.textContent = element.catagorie_name;

            sel_cat.appendChild(option);

        });

    } catch (error) {

        console.error("Error loading categories:", error);

    }
}

    let category_id=null;
    
sel_cat.addEventListener("change", async () => {

    category_id = sel_cat.value;

    console.log("Selected user:", userid);
    console.log("Selected category:", category_id);

    section.style.display = "block";
    scorebox.style.display = "none";
    analysis.style.display = "none";

    await attemptnum(userid, category_id);
});


async function attemptnum(userId, categoryId) {

    console.log("attemptnum called with:");
    console.log("userId =", userId);
    console.log("categoryId =", categoryId);

    try {

        const url =
            `../db/admgetstud_quizhistory.php?user_id=${userId}&num=${categoryId}`;

        const res = await fetch(url);

        const data = await res.json();

        console.log("Attempt data:", data);

        attemptno.innerHTML = "";

        const placeholder = document.createElement("option");

        placeholder.value = "";
        placeholder.textContent = "Select Attempt";
        placeholder.disabled = true;
        placeholder.selected = true;

        attemptno.appendChild(placeholder);

        if (!data.success || data.data.length === 0) {
            console.log("No attempts found");
            return;
        }

        const uniqueAttempts = [
            ...new Set(
                data.data.map(e => e.attempt_id)
            )
        ];

        uniqueAttempts.forEach(attempt => {

            const option = document.createElement("option");

            option.value = attempt;
            option.textContent = `Attempt ${attempt}`;

            attemptno.appendChild(option);
        });

    } catch (error) {

        console.error("Attempt error:", error);

    }
}

let queslength=null;
let attemptnumm=null;
async function resultatt(userid, value) {

    analysis.style.display = "none";

    try {

        const res = await fetch(
            `../db/adget_allattemptdata.php?attempt_id=${value}&id=${userid}`
        );

        if (!res.ok) {
            throw new Error("Failed to fetch attempt data");
        }

        const data = await res.json();

        console.log("Attempt data:", data);
        console.log("FULL API RESPONSE:", data);
console.log("TOTAL QUESTIONS:", data.total_questions);



        if (!data.success) {
            console.error(data.message);
            return;
        }

        // =========================
        // TOTAL QUESTIONS
        // =========================

        const totalQuestions = Number(data.total_questions);

        queslength = totalQuestions;

        tolques.textContent =
            `Total Questions: ${totalQuestions}`;


        // =========================
        // ANSWERED QUESTIONS
        // =========================

        const answered = data.data || [];

        const attempted = answered.length;

        totalAttempted.textContent =
            `Attempted Questions: ${attempted}`;


        // =========================
        // CORRECT ANSWERS
        // =========================

        const correctArr = answered.filter(
            element => Number(element.is_correct) === 1
        );

        const correct = correctArr.length;

        correctAnswers.textContent =
            `Correct Answers: ${correct}`;


        // =========================
        // WRONG ANSWERS
        // =========================

        const wrongArr = answered.filter(
            element => Number(element.is_correct) === 0
        );

        const wrong = wrongArr.length;

        wrongAnswers.textContent =
            `Wrong Answers: ${wrong}`;


        // =========================
        // NOT ANSWERED
        // =========================

        const notAnswered = Math.max(
            0,
            totalQuestions - attempted
        );

        notans.textContent =
            `Not Answered: ${notAnswered}`;


        // =========================
        // SCORE
        // =========================

        const scored = correct * 10;

        score.textContent =
            `Score: ${scored}`;

    } catch (error) {

        console.error("Result error:", error);

    }
}



 attemptno.addEventListener("change",async()=>{
    scorebox.style.display="block";
     attemptnumm=attemptno.value;
    await resultatt(userid,attemptnumm);
    await performance(userid,category_id,attemptnumm)
   
 })
let cor=0;
    async function performance(user_id,cat_id,att_id){
        analysis.style.display="block";
        const res=await fetch(`../db/adgetuser_perform.php?userid=${user_id}&catid=${cat_id}&attid=${att_id}`);
        const data=await res.json();
        console.log(data);
        let questionnum=data.data;
        let answers=data.question;
       analysis.innerHTML="";
       analysis.innerHTML = "<h2>Performance Analysis</h2>";

for (let i = 0; i < questionnum.length; i++) {

    if (questionnum[i].question_id === answers[i].id) {

        const item = document.createElement("div");
        item.classList.add("analysis-item");
          
        const p = document.createElement("p");
        const span = document.createElement("span");

        p.textContent = `Q${i + 1}: ${answers[i].question}`;

        if (questionnum[i].answer === answers[i].correct_answer) {
            item.classList.add("correct");
            span.textContent = `Correct ✔ ${questionnum[i].answer}`;
        } else {
            item.classList.add("wrong");
            span.textContent =
                `Wrong ✖ ${questionnum[i].answer} | Correct Answer: ${answers[i].correct_answer}`;
        }

        item.appendChild(p);
        item.appendChild(span);

        analysis.appendChild(item);
    }
}
    }     
 });
//  performance();
  




    </script>
</body>
</html>