<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeafLink</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo">
                <img src="images/logo.jpg" alt="LeafLink Logo">
            </a>

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li>
                        <a href="register.php" class="register-btn">Register</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
