<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_badge.php");
        exit();
    }

    $badgeId = $_POST['badgeId'];

    $delete = mysqli_query($conn,
        "DELETE FROM badge
        WHERE badgeId='$badgeId'");

    if($delete){
        $_SESSION['badgeSuccess'] = "Badge deleted successfully.";
    }else{
        $_SESSION['badgeError'] = "Failed to delete badge.";
    }

    header("Location: manage_badge.php");
    exit();

?>