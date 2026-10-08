<?php
session_start();
include("../db/connection.php");
if(!isset($_SESSION['user_id'])){
   header('Location: ../php/login.php');
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
    <link rel="stylesheet" href="../css/stuquizhistory.css">
</head>
<body>
   <!-- Navigation Bar -->
    <nav class="navbar">

        <a class="logo" href="studentpage.php" target="" >QuizMaster</a>

        <ul class="nav-links">
            <li><a href="studentpage.php" target="">Dashboard</a></li>
          
            <li><a href="quizcat.php" target="">Browse Quiz</a></li>
            <li><a href="stuquizhistory.php" target="">Result and Analysis</a></li>
        
        </ul>

        <a href="logout.php" class="logout">Logout</a>

    </nav>

    </nav>
    <div class="container">
        <header id="header">
              <div id="result">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path d="M544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM352 216C352 229.3 341.3 240 328 240L216 240C202.7 240 192 229.3 192 216C192 202.7 202.7 192 216 192L328 192C341.3 192 352 202.7 352 216zM424 296C437.3 296 448 306.7 448 320C448 333.3 437.3 344 424 344L216 344C202.7 344 192 333.3 192 320C192 306.7 202.7 296 216 296L424 296zM288 424C288 437.3 277.3 448 264 448L216 448C202.7 448 192 437.3 192 424C192 410.7 202.7 400 216 400L264 400C277.3 400 288 410.7 288 424z"/>
                    </svg>
                    <a href="#">Quiz History </a>
               </div>
               <div class="category">
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
                    <label for="sortattempt">Sort:</label>
                    <select id="sortattempt">
                        <option value="latest">Latest first</option>
                        <option value="oldest">Oldest first</option>
                    </select>
                    <label for="filterattempt">Filter:</label>
                    <select id="filterattempt">
                        <option value="all">All attempts</option>
                        <option value="passed">Passed (50%+)</option>
                        <option value="failed">Failed (below 50%)</option>
                    </select>
                    <label for="attempt">Attempt:</label>
                    <select id="attempt">
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
            </div>
        </section>
    </div>
    <script >
        document.addEventListener("DOMContentLoaded", () => {
const sel_cat=document.querySelector(".select_cate select");
const section=document.getElementById("section") ;
const scorebox=document.querySelector(".score-box")
const tolques=document.getElementById("tolques");
const attemptno=document.getElementById("attempt");
const sortAttempt=document.getElementById("sortattempt");
const filterAttempt=document.getElementById("filterattempt");
const totalAttempted= document.getElementById("totalatte");
const correctAnswers= document.getElementById("correctans");
const wrongAnswers= document.getElementById("wrongans");
const notans=document.getElementById("notans");
const score=document.getElementById("score");
const analysis = document.querySelector(".analysis");

        // fetch category and display category
async function showcategory(){
    try{
        const res = await fetch("../db/getcategory.php");
        const data = await res.json();
        sel_cat.innerHTML ="";
          const placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.textContent = "Select Category";
            placeholder.disabled = true;
            placeholder.selected = true;
            sel_cat.appendChild(placeholder);
            data.data.forEach(element => {
                const option = document.createElement("option");
                option.value = element.id; 
                option.textContent = element.catagorie_name;
            sel_cat.appendChild(option);
        });

        // open the first category that has attempts
        for (const element of data.data) {
            const r = await fetch(`../db/getstud_quizhistory.php?num=${element.id}`);
            const att = await r.json();
            if (att.data.length > 0) {
                sel_cat.value = element.id;
                await openCategory(element.id);
                break;
            }
        }

    } catch(error){
        console.error("Error", error);
    }
}
showcategory();


    let category_id=null;
    let queslength=null;
let attemptnumm=null;
    sel_cat.addEventListener("change",()=>{
    openCategory(sel_cat.value);
})

async function openCategory(id){
    section.style.display="block";
    scorebox.style.display="none";
    analysis.style.display="none";
    category_id=id;
    await totalques(category_id);
    await attemptnum(category_id);
}



async function totalques(category_id){
    const res=await fetch(`../db/totalques.php?id=${category_id}`);
    const data=await res.json();
    queslength=data.data.length;
    tolques.textContent=`Total Questions:${queslength}`;  
}


async function attemptnum(number) {
    const res = await fetch(`../db/getstud_quizhistory.php?num=${number}`);
    const data = await res.json();
    allAttempts = data.data || [];
    showAttempts();
}

let allAttempts = [];

// filter + sort the attempts and fill the attempt dropdown
function showAttempts() {
    scorebox.style.display = "none";
    analysis.style.display = "none";

    let list = allAttempts.slice();

    // filter
    if (filterAttempt.value === "passed") {
        list = list.filter(e => Number(e.score) * 2 >= Number(e.total_questions));
    } else if (filterAttempt.value === "failed") {
        list = list.filter(e => Number(e.score) * 2 < Number(e.total_questions));
    }

    // sort (latest = highest attempt number)
    if (sortAttempt.value === "oldest") {
        list.sort((a, b) => a.attempt_id - b.attempt_id);
    } else {
        list.sort((a, b) => b.attempt_id - a.attempt_id);
    }

    attemptno.innerHTML = "";
    const placeholder = document.createElement("option");
    placeholder.value = "";
    placeholder.textContent = list.length > 0 ? "Select Attempt" : "No attempts found";
    placeholder.disabled = true;
    placeholder.selected = true;
    attemptno.appendChild(placeholder);

    list.forEach(e => {
        const option = document.createElement("option");
        option.value = e.attempt_id;
        option.textContent = `Attempt ${e.attempt_id} (${e.score}/${e.total_questions})`;
        attemptno.appendChild(option);
    });

    // open the first listed attempt (latest by default) so the page is never blank
    if (list.length > 0) {
        attemptno.selectedIndex = 1;
        openAttempt();
    }
}

sortAttempt.addEventListener("change", showAttempts);
filterAttempt.addEventListener("change", showAttempts);


 attemptno.addEventListener("change",openAttempt)

 function openAttempt(){
    scorebox.style.display="block";
    attemptnumm=attemptno.value
    resultatt(attemptnumm);
    performance(category_id,attemptnumm)
 }
let cor=0;
 async function resultatt(value) {

    try {

        const res = await fetch(
            `../db/get_allattemptdata.php?attempt_id=${value}&category_id=${category_id}`
        );

        if (!res.ok) {
            throw new Error("Failed to fetch result data");
        }

        const data = await res.json();

        console.log("Result data:", data);

        if (!data.success) {
            console.error(data.message);
            return;
        }


        // ==========================================
        // TOTAL QUESTIONS
        // ==========================================

        const totalQuestions = Number(data.total_questions);

        tolques.textContent =
            `Total Questions: ${totalQuestions}`;


        // ==========================================
        // ANSWERED QUESTIONS
        // ==========================================

        const answers = data.data || [];

        const attempted = answers.filter(
            element => element.answer !== "" && element.answer !== null
        ).length;

        totalAttempted.textContent =
            `Attempted Questions: ${attempted}`;


        // ==========================================
        // CORRECT ANSWERS
        // ==========================================

        const correctArr = answers.filter(
            element => Number(element.is_correct) === 1
        );

        const correct = correctArr.length;

        correctAnswers.textContent =
            `Correct Answers: ${correct}`;


        // ==========================================
        // WRONG ANSWERS
        // ==========================================

        const wrongArr = answers.filter(
            element => Number(element.is_correct) === 0 &&
            element.answer !== "" && element.answer !== null
        );

        const wrong = wrongArr.length;

        wrongAnswers.textContent =
            `Wrong Answers: ${wrong}`;


        // ==========================================
        // NOT ANSWERED
        // ==========================================

        const notAnswered = Math.max(
            0,
            totalQuestions - attempted
        );

        notans.textContent =
            `Not Answered: ${notAnswered}`;


        // ==========================================
        // SCORE
        // ==========================================

        const percent = totalQuestions > 0 ? Math.round(correct / totalQuestions * 100) : 0;

        score.textContent =
            `Score: ${correct}/${totalQuestions} (${percent}%)`;

    } catch (error) {

        console.error("Result error:", error);

    }
}


async function performance(cat_id, att_id) {

    analysis.style.display = "block";

    try {

        const res = await fetch(
            `../db/stugetuser_perform.php?catid=${cat_id}&attid=${att_id}`
        );

        if (!res.ok) {
            throw new Error("Failed to fetch performance data");
        }

        const data = await res.json();

        console.log("Performance data:", data);

        if (!data.success) {
            console.error(data.message);
            return;
        }

        const questionnum = data.data || [];
        const answers = data.question || [];

        analysis.innerHTML = "<h2>Performance Analysis</h2>";


        // ==========================================
        // CREATE A MAP OF QUESTIONS
        // ==========================================

        const questionMap = new Map();

        answers.forEach(question => {
            questionMap.set(
                Number(question.id),
                question
            );
        });


        // ==========================================
        // DISPLAY PERFORMANCE
        // ==========================================

        questionnum.forEach((userAnswer, index) => {

            const question = questionMap.get(
                Number(userAnswer.question_id)
            );

            if (!question) {
                return;
            }


            const item = document.createElement("div");
            item.classList.add("analysis-item");


            const p = document.createElement("p");

            p.textContent =
                `Q${index + 1}: ${question.question}`;


            const span = document.createElement("span");


            if (
                userAnswer.answer === "" ||
                userAnswer.answer === null
            ) {

                item.classList.add("wrong");

                span.textContent =
                    `Skipped | Correct Answer: ${question.correct_answer}`;

            } else if (
                userAnswer.answer ===
                question.correct_answer
            ) {

                item.classList.add("correct");

                span.textContent =
                    `Correct ✔ ${userAnswer.answer}`;

            } else {

                item.classList.add("wrong");

                span.textContent =
                    `Wrong ✖ ${userAnswer.answer} | Correct Answer: ${question.correct_answer}`;
            }


            item.appendChild(p);
            item.appendChild(span);

            analysis.appendChild(item);

        });

    } catch (error) {

        console.error("Performance error:", error);

    }
}
        
 });
  
    </script>
</body>
</html>