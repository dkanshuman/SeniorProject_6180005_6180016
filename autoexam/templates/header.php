<?php 
    session_start();
    require './includes/config.php'; 
    require_once './includes/connection.php';
    require_once './includes/function.php'; 

    
    if(isset($_SESSION['user']))
    {
        $userQuery = mysqli_query($connection, "SELECT * FROM teacher_profile WHERE email = '$_SESSION[user]'");
        $userRow = mysqli_fetch_assoc($userQuery);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title;?> | <?= $sitename; ?>
    </title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>

    <header class="admin-header">
        <h1 class="title">
            <span class="bars" id="menu-toggle"><i class="fa-solid fa-bars"></i></span>
            <img src="./assets/images/logo.png" alt="Auto Exam Generator" height="60px">
        </h1> 
        
        <div>
            <ul>
                <li class="dropmenu">
                    <a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                    <ul class="dropdown">
                        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a></li>
                        
                    </ul>                
                </li>
            </ul>
        </div>

    </header>


    <aside id="asideMenu"> 

        <div class="profile-header" id="profile-header2">

            <?php 
                if($_SESSION['userType'] == 'Admin')
                {
                    echo "<i class=\"fa-solid fa-user-check\"></i>";
                }
                else
                {
                    echo "<i class=\"fa-solid fa-user\"></i>";
                }
            ?>
            <div>
                <h2>
                    <?= 
                        $userRow['teacher_firstname'] ." ". $userRow['teacher_lastname']
                    ?>
                </h2>
                <p> <?=  $_SESSION['userType']; ?> </p>
            </div>
        </div>

        <section id="nav-header">
        
            <nav>
                <ul class="navbar">
                    <li><a href="dashboard.php"><i class="fa-solid fa-house"></i><span>Dashboard</span></a></li>
                    <?php
                        // if($_SESSION['userType'] == 'Admin')
                        // {
                    ?>
                            <li><a href="institute-view.php"><i class="fa-solid fa-building-columns"></i><span>Institute</span></a></li>
                            <li><a href="studyType-view.php"><i class="fa-solid fa-bookmark"></i><span>Study Type</span></a></li>
                            <li><a href="major-view.php"><i class="fa-solid fa-chalkboard-user"></i><span>Major</span></a></li>
                            <li><a href="subject-view.php"><i class="fa-solid fa-book"></i><span>Subject</span></a></li>
                            <li><a href="topic-view.php"><i class="fa-solid fa-book-open"></i><span>Topic</span></a></li>
                    <?php
                        if($_SESSION['userType'] == 'Admin')
                        {
                    ?>
                            <li><a href="teacher-view.php"><i class="fa-solid fa-person-chalkboard"></i><span>View Teachers</span></a></li>
                    <?php 
                        }   
                    ?>
                    <li><a href="question-view.php"><i class="fa-solid fa-receipt"></i><span>Questions</span></a></li>
                    <li><a href="setExam-1.php"><i class="fa-solid fa-graduation-cap"></i><span>Set Exam</span></a></li>
                </ul>
            </nav>
        </section>

        <footer class="copyright">Copyright@
            <?= date("Y"); ?>
            <?= $sitename; ?>. All Rights Reserved.
        </footer>

    </aside>


    <main>


    <script>
        document.querySelector("#menu-toggle").addEventListener("click", toggleMenu);

        function toggleMenu()
        {
            document.querySelector("#asideMenu").classList.toggle("showmenu");
        }
    </script>