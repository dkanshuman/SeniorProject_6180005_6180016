<?php 
    require_once './includes/config.php'; 
    // session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> |
        <?= $sitename; ?>
    </title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/home-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>

    <div class="topbar">
        <div class="container">
            <ul class="toplist">
                <li>
                    <a href="mailto:"><i class="fa-solid fa-envelope"></i>
                        <span>anshuman.ver@student.mahidol.edu</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-phone"></i> <span>123-456-7890</span></a>
                </li>
            </ul>
        </div>
    </div>

    <header id="header">
        <div class="container">
            <nav class="navbar">
                <img src="./assets/images/logo.png" alt="Auto Exam Generator" height="80px">
                <h1 class="title">
                    <?php
                    //  echo $sitename; 
                    ?>
                </h1>
                <ul class="navlist">
                   
                    <li><a href="./index.php">Home</a></li>
                    <?php
                        if(isset($_SESSION['user']))
                        {
                            echo "<li><a href=\"./dashboard.php\">Dashboard</a></li>";
                            echo "<li><a href=\"./logout.php\">Logout</a></li>";
                        }
                        else
                        {
                    ?>
                            <li><a href="./signup.php">Signup</a></li>
                            <li><a href="./login.php" class="btn blue-btn">Login</a></li>
                    <?php
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>