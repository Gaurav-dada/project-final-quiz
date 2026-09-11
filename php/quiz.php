<?php

session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}
$username = $_SESSION['username'];
$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="../css/quiz.css">
</head>

<body>

<div class="header">

    <div class="cate">
        <select id="category"></select>
    </div>

    <div class="timer-box">
    Time: <span id="timer">60</span>
</div>

    <div class="score-box">
        Score: <span id="score">0</span>
    </div>

    <div class="head">
        <h1>Quiz System</h1>
    </div>

</div>

<div class="main">

    <div class="container">

        <div class="head">
            <h2></h2>
        </div>
    

        <div id="question">
            <h1></h1>
        </div>

        <div id="options">
            <ul></ul>
        </div>

        <div class="button">
            <button id="start">Start Quiz</button>
            <button name="nex" style="display:none;" id="nex">Next</button>
            <button name ="ski" style="display:none;" id="ski">Skip</button>
            <button id="sub" name="submit" style="display:none;">Submit</button>
        </div>

    </div>

</div>

<script >
    

const science = 
   [ {
        question: "Which planet is closest to the sun?",
        correct_answer: "Mercury",
        options: ["Venus", "Mercury", "Mars", "Earth"]
    },
    {
        question: "How many bones do we have in an ear?",
        correct_answer: "3",
        options: ["1", "2", "3", "4"]
    },
    {
        question: "What is the chemical element with the symbol Fe?",
        correct_answer: "Iron",
        options: ["Gold", "Iron", "Silver", "Copper"]
    },
    {
        question: "What is the smallest unit of matter?",
        correct_answer: "Atom",
        options: ["Cell", "Molecule", "Atom", "Electron"]
    },
    {
        question: "What is the process by which a liquid changes into a gas?",
        correct_answer: "Evaporation",
        options: ["Condensation", "Freezing", "Evaporation", "Melting"]
    },
    {
    question: "Which planet has the most moons?",
    correct_answer: "Saturn",
    options: ["Jupiter", "Saturn", "Mars", "Neptune"]
    },
    {
        question: "Where is the strongest human muscle located?",
        correct_answer: "Jaw",
        options: ["Arm", "Leg", "Jaw", "Back"]
    },
    {
        question: "Which is the only body part that is fully grown from birth?",
        correct_answer: "Eyes",
        options: ["Nose", "Ears", "Eyes", "Hands"]
    },
    {
        question: "What is the outermost layer of the Earth’s atmosphere called?",
        correct_answer: "Exosphere",
        options: ["Stratosphere", "Mesosphere", "Thermosphere", "Exosphere"]
    },
    {
        question: "What is the process by which plants convert sunlight to energy?",
        correct_answer: "Photosynthesis",
        options: ["Respiration", "Photosynthesis", "Transpiration", "Fermentation"]
    },
    {
        question: "What scientific theory proposed that Earth revolves around the sun?",
        correct_answer: "Heliocentrism",
        options: ["Geocentrism", "Heliocentrism", "Relativity", "Evolution"]
    }]  
;

const math = [
  {
    question: "What is 9 * 6?",
    correct_answer: "54",
    options: ["48", "52", "54", "56"]
  },
  {
    question: "What is half of 250?",
    correct_answer: "125",
    options: ["100", "120", "125", "150"]
  },
  {
    question: "What is 15 + 27?",
    correct_answer: "42",
    options: ["40", "41", "42", "43"]
  },
  {
    question: "How many sides does an octagon have?",
    correct_answer: "Eight",
    options: ["Six", "Seven", "Eight", "Nine"]
  },
  {
    question: "What is 100 ÷ 4?",
    correct_answer: "25",
    options: ["20", "25", "30", "35"]
  },
  {
    question: "What is 10% of 80?",
    correct_answer: "8",
    options: ["6", "7", "8", "10"]
  },
  {
    question: "What is 7 squared?",
    correct_answer: "49",
    options: ["42", "48", "49", "56"]
  },
  {
    question: "What is the value of π rounded to two decimals?",
    correct_answer: "3.14",
    options: ["3.12", "3.13", "3.14", "3.15"]
  }
];
const ques_no=document.querySelector(".head h2");
const ques=document.querySelector("#question h1");
const category=document.querySelector("#category");
const list=document.querySelector("#options ul");
const next=document.querySelector("#nex");
const skip=document.querySelector("#ski");
const star=document.querySelector("#start");
const score=document.getElementById("score");
const submit=document.getElementById("sub") ;
const container=document.querySelector(".container")




const timerDisplay = document.getElementById("timer");

let timeLeft = 60;
let timerInterval = null;
function startTimer() {
    // Prevent multiple timers
    if (timerInterval !== null) {
        return;
    }

    timeLeft = 60;
    timerDisplay.textContent = timeLeft;

    timerInterval = setInterval(() => {

        timeLeft--;

        timerDisplay.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerInterval = null;

            alert("Time is up!");

            submitQuiz();
        }

    }, 1000);
}


function stopTimer() {
    if (timerInterval !== null) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

//store question in database
async function storeCatagory(course) {
   try{
        const response = await fetch("../php/catagori.php", {
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify({
                category: course,
            
            })
        });
        const result = await response.json();
        console.log(result);
        
        return result.category_id;
    }
    catch(error){
        console.error("Error",error);
    }      
}

// store question in database
let question_id;
async function storeQues(category_id,course ,questionList) {

    console.log(category_id)
   try{
        const response = await fetch(
            "/gauravproj/quiz/php/insertquestion.php",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    category_id:category_id,
                    name:course,
                    questions:questionList
                })
            });

        const data= await response.json();
        question_id=data.question_id;
        console.log(question_id);
    }
    catch(error){
        console.error("Error",error);
    }
}

//store option in database
async function storeoption(question_id,category_id,optionList,course){
    try{
        const response=await fetch("/gauravproj/quiz/php/insertoption.php",{
            method:"POST",
            headers:{
                "Content-type":"application/json"
            },
            body:JSON.stringify({
            question_id:question_id,
            category_id:category_id,
                category_name:course,  
                options:optionList
            })
        })
        const  data=await response.text();
        console.log(data);
   }

    catch(error){
        console.error("Error",error)
    }
}
// storeoption();
 
let count=0;
let currentCategory = "";
let attempt_id=null;
let next_option=null;
let ques_next=null;
let quesno=0;
let answered=false;



async function startQuiz(category_id){
    const res = await fetch("../db/start_attempt.php", {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify({
            category_id:category_id
        })
    });
    const data = await res.json();  
    attempt_id = data.attemptid; 
     
    start.style.display = "none";

    
    next.style.display = "inline-block";
    skip.style.display = "inline-block";
}


let currentId = new URLSearchParams(window.location.search).get("id");
star.addEventListener("click",async ()=>{
    star.style.display="none";
    next.style.display="block";
    skip.style.display="block";
   await getques(currentId);
   await startQuiz(currentId);
   startTimer(); 
})


//fetch question from database

async function getques(id){
    try{      
        const response= await fetch(`../db/disques.php?id=${id}`);
        const data=await response.json();
        console.log(data);
        quizdata=data;
        
        showques(data);
    }
    catch(error){
        console.error("Error",error);
    }
}


//display question to frontend

function showques(dat){
        answered=false;
        ques_next=dat;
       
        ques_no.innerHTML=`Queston NO ${quesno+1}/${dat.data.length}`;
        ques.innerHTML=dat.data[quesno].question;
        getoption(currentId);
          if (quesno >= dat.data.length - 1) {
        skip.style.display = "none";
        next.style.display = "none";
        submit.style.display = "block";
    } 
    else {
        skip.style.display = "block";
        next.style.display = "block";
        submit.style.display = "none";
    }
}


//fetch option from database
async function getoption(id){
    try{
    const res=await fetch(`../db/disoption.php?id=${id}`);
    const data=await res.json();
   console.log(data);
    showoption(data);
    }
    catch(error){
        console.error("Error",error);
    }
}


//display option to frontend


function showoption(data) {
        list.innerHTML = "";
        next_option = data;
        const arr = data.data;
        console.log(arr);
        arr.forEach((element) => {
            if (element.question_id == ques_next.data[quesno].id) {
                const li = document.createElement("li");
                li.textContent = element.option_;
                li.addEventListener("click", () => {
                    if (answered) return;
                    answered = true;
                    const question_id = ques_next.data[quesno].id;
                    const answer = element.option_;
                    const category_id = currentId;
                    async function submitAnswer() {
                    const res = await fetch("../db/check_answer.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            question_id,
                            answer,
                            category_id,
                            attempt_id
                        })
                    });
                    const result = await res.text();
                    console.log(result) ;  
                }
                    submitAnswer();
                    if (element.is_correct == 1) {
                        li.style.background = "green";
                        count++;
                        score.textContent = count;
                    } else {
                        li.style.background = "red";
                    }
                });

                list.appendChild(li);
            }
        });
}

//display next question 

function next_ques(){
   if(!answered){
        alert("must choose ");
        return;
    }
    quesno++;
   if(quesno>=ques_next.data.length){
        alert("quiz completed");
        return;
    }
    else{
        answered=false
    showques(ques_next);
    
    }
}


//skip  question
function skip_tonext(){
    answered=false;
    quesno++;
    if(quesno>=ques_next.data.length){
        alert("quiz completed");
        return;
    }
    else{
    showques(ques_next);
   
    }
}

async function submitQuiz() {

    // Stop timer
    stopTimer();

    try {

        const res = await fetch("../db/submit_quiz.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                attempt_id: attempt_id,
                score: count,
                total_questions: ques_next.data.length,
                category_id: currentId
            })
        });

        const result = await res.json();

        console.log("Submit response:", result);

        if (result.success === true) {

            container.innerHTML = `
                <div class="quiz-result">
                    <h2>Quiz Completed!</h2>
                    <h3>Score: ${count}/${ques_next.data.length}</h3>
                     <a href="quizcat.php" class="category-link">
                        Go to Categories
                    </a>
                </div>
            `;

            next.style.display = "none";
            skip.style.display = "none";
            submit.style.display = "none";

        } else {

            alert("Quiz submission failed: " + result.message);
        }

    } catch (error) {

        console.error("Submit error:", error);

        alert("Quiz submission failed.");
    }
}

submit.addEventListener("click", async () => {
    if (!answered && quesno < ques_next.data.length - 1) {
        alert("Please answer or finish all questions before submitting.");
        return;
    }

    await submitQuiz();
});



async function chain(){
    try{
        let category_id=await storeCatagory("science");
        await storeQues(category_id,"science",science);
        await storeoption(question_id,category_id,science,"science");
        category_id=await storeCatagory("math");
        await storeQues(category_id,"math",math);
         await storeoption(question_id,category_id,math,"math");    
    }
    catch(error)
    {
        console.error("Error",error);
    }
}
// chain();


    skip.addEventListener("click",skip_tonext);
    next.addEventListener("click",next_ques);











    
</script>

</body>
</html>