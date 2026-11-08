<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("location: manage_badge.php");
        exit();
    }

    $badgeId = $_POST['badgeId'];
    $badgeName = trim($_POST['badgeName']);
    $description = trim($_POST['description']);
    $requiredPoints = trim($_POST['requiredPoints']);

    $update = mysqli_query($conn,
        "UPDATE badge
        SET
            badgeName = '$badgeName',
            description = '$description',
            requiredPoints = '$requiredPoints'
        WHERE badgeId = '$badgeId'");

    if($update){
        $_SESSION['badgeSuccess'] = "Badge updated successfully.";
    }else{
        $_SESSION['badgeError'] = "Failed to update badge.";
    }

    header("Location: manage_badge.php");
    exit();

?>