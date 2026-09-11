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

    <title>Manage Quiz</title>

    <link rel="stylesheet" href="../css/category.css">
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

    <!-- Main Content -->
    <main class="main-content">

        <div class="page-header">
            <div>
                <h1>Manage Quiz</h1>
                <p>Manage quiz categories and quizzes.</p>
            </div>
        </div>
        <div>
            <button id="addbut" onclick='addbut()'>Add category</button>
        </div>
</main>
        <!-- Category CRUD Section -->
        <section class="crud-section">

            <div class="section-header">

                <div>
                    <h2 id="cat">Category List</h2>
                </div>
            </div>


            <!-- CRUD Table -->
            <div class="table-container">

                <table  border="1">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>         
                    <?php
                      $sql="SELECT * FROM catagories WHERE is_active=1";
                    $stm=$conn->prepare($sql);
                    $stm->execute();
                    $result=$stm->get_result();
                    if($result->num_rows>0){
                        while($rows=mysqli_fetch_assoc($result)){
                            echo"<tr>";
                            echo "<td>".$rows['id']."</td>";
                             echo "<td class='cat-name'>".$rows['catagorie_name']."</td>";
                              echo "<td class='cat-desc'>".$rows['description']."</td>";
                              echo "<td class='butt'>
                                        <button class='viewbn' onclick='viewques(".$rows['id'].")'>View Questions</button>
                                        <button class='editbn' value='".$rows['id']."' onclick='editbtn(this)'>Edit</button>
                                        <button class='savebn' value='".$rows['id']."' style='display:none;' onclick='savebtn(this)'>Save</button>
                                        <button class='cancelbn' value='".$rows['id']."' style='display:none;' onclick='cancelbtn(this)'>Cancel</button>
                                        <button class='delbn' onclick='delbtn(".$rows['id'].")'>Delete</button>
                                      </td>";

                                echo "</tr>";
                        }
                    }
                    else{
                        echo "<tr>";
                        echo "<td colspan=5>No categories Found.</td>";
                        echo "</tr>";
                    }
                       ?>   
                                           
                    </tbody>
</table>
            </div>
        </section>
    </main>
    <script>
        function editbtn(catlis){
        let row=catlis.closest("tr");
        let category = row.querySelector(".cat-name");
        let description = row.querySelector(".cat-desc");
        let save=row.querySelector(".savebn");
        let del=row.querySelector(".delbn");
        let view=row.querySelector(".viewbn");
        let edit=row.querySelector(".editbn");
        let cancel=row.querySelector(".cancelbn");

        category.contentEditable = "true";
        description.contentEditable = "true";
        category.focus();
        del.style.display="none";
        view.style.display="none";
        edit.style.display="none";
        save.style.display="block";
        cancel.style.display="block";
      

        }


        async  function savebtn(catlis){
           
        let row=catlis.closest("tr");
        let id=catlis.value;
        let category = row.querySelector(".cat-name");
        let description = row.querySelector(".cat-desc");
        let categoryValue=category.innerText.trim();
        let descriptionValue=description.innerText.trim();
        try{
        const response=await fetch('../db/updatecat.php',{
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body: JSON.stringify({
                    id: id,
                    category: categoryValue,
                    description: descriptionValue
                })        
            });
            const data=await response.json();
            console.log(data);
            if(data.success){
                alert("Update Successfull");
                category.contentEditable="false";
                description.contentEditable="false";
                row.querySelector(".editbn").style.display = "block";
                row.querySelector(".delbn").style.display = "block";
                row.querySelector(".viewbn").style.display = "block";
                row.querySelector(".savebn").style.display = "none";
                row.querySelector(".cancelbn").style.display = "none";
            }
            else {
                alert(data.message || "Update failed");
            }
            }  
        catch (error) {

            console.error(error);
            alert("Something went wrong while updating the category.");
        }
        }

        
        function addbut(){
            window.location.href='addcat.php';
        }
        async function delbtn(num){
            let confirmdel=confirm("Are you sure You want to delete this category");
            if(confirmdel){
            const response= await fetch(`../db/delcat.php?id=${num}`);
            const data= await response.json();
            if(data.success){
                window.location.href="category.php";
            }
            }
            else{
                alert("Failed to Delete");
            }
        }
        function viewques(num){
            window.location.href=`questionview.php?id=${num}`;
        }
        </script>
</body>
</html>
