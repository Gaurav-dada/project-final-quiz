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
    <title>Manage Users</title>

    <link rel="stylesheet" href="../css/manageuser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
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
    <main class="user-manage">
        <header class="user-summary">
            <div class="users-container">
                <h1>Manage Users</h1>              
                <div class="user-card">
                    <div class="user-logo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                            <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/>
                        </svg>
                    </div>
                    <div class="user-info">
                        <h2 id="userss"></h2>
                        <h3>Total Users</h3>
                    </div>
                </div>
            </div>           
        </header>
        <section id="section">
            <table border="1px" width="100%">
                <thead>
                    <tr>
                        <th>UserId</th>
                        <th>FullName</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr >
                        <!-- <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td> -->
                    </tr>
                </tbody>
            </table>
        </section>

    </main>
    <script >
       

       const userdata = document.querySelector("#section tbody");
const usernum = document.getElementById("userss");


// ==============================
// Get Total Users
// ==============================
async function getTotalUsers() {

    try {

        const res = await fetch('../db/admin1.php');

        if (!res.ok) {
            throw new Error("Failed to fetch total users");
        }

        const data = await res.json();

        console.log(data);

        usernum.textContent = data.user.length;

    } catch (error) {

        console.error("Total users error:", error);

    }

}


// ==============================
// Load Users
// ==============================
async function user_data() {

    try {

        const res = await fetch('../db/user_data.php');

        if (!res.ok) {
            throw new Error("Failed to fetch users");
        }

        const data = await res.json();

        userdata.innerHTML = "";

        data.data.forEach(element => {

            userdata.innerHTML += `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.fullname}</td>
                    <td>${element.email}</td>
                    <td>${element.username}</td>

                    <td>
                        <button onclick="editUser(${element.id})">
                            Edit
                        </button>

                        <button onclick="deleteUser(${element.id})">
                            Delete
                        </button>
                    </td>
                </tr>
            `;

        });

    } catch (error) {

        console.error("User loading error:", error);

    }

}


// ==============================
// Delete User
// ==============================
window.deleteUser = async function(id) {

    try {

        const res = await fetch(
            `../db/del_userdata.php?userid=${id}`
        );

        if (!res.ok) {
            throw new Error("Delete request failed");
        }

        const data = await res.json();

        if (data.success) {

            alert("User deleted successfully");

            // Refresh table
            user_data();

            // Refresh total user count
            getTotalUsers();

        } else {

            alert("Delete failed");

        }

    } catch (error) {

        console.error("Delete error:", error);

    }

};


// ==============================
// Edit User
// ==============================
window.editUser = async function(id) {

    try {

        const res = await fetch(
            `../db/edit_userdata.php?userid=${id}`
        );

        if (!res.ok) {
            throw new Error("Edit request failed");
        }

        const result = await res.json();

        localStorage.setItem(
            "editUser",
            JSON.stringify(result.data)
        );

        window.location.href = "../php/edituser.php";

    } catch (error) {

        console.error("Edit error:", error);

    }

};


// ==============================
// Run When Page Loads
// ==============================
getTotalUsers();
user_data();

    </script>
</body>
</html>