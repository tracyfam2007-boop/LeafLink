<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("location: manage_teamchallenge.php");
        exit();
    }

    $challengeId = $_POST['challengeId'];
    $challengeName = trim($_POST['challengeName']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $challengePoint = trim($_POST['challengePoint']);
    $status = trim($_POST['status']);

    $update = mysqli_query($conn,
        "UPDATE teamchallenge
        SET
            challengeName = '$challengeName',
            startDate = '$startDate',
            endDate = '$endDate',
            challengePoint = '$challengePoint',
            status = '$status'
        WHERE challengeId = '$challengeId'");

    if($update){
        $_SESSION['challengeSuccess'] = "Team challenge updated successfully.";
    }else{
        $_SESSION['challengeError'] = "Failed to update team challenge.";
    }

    header("Location: manage_teamchallenge.php");
    exit();

?>

