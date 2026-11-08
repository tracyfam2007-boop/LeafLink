<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("location: manage_activity.php");
        exit();
    }

    $activityId = $_POST['activityId'];
    $activityName = trim($_POST['activityName']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $pointsReward = trim($_POST['pointsReward']);
    $rules = trim($_POST['rules']);
    $status = trim($_POST['status']);

    $update = mysqli_query($conn,
        "UPDATE activity
        SET
            activityName = '$activityName',
            description = '$description',
            category = '$category',
            pointsReward = '$pointsReward',
            rules = '$rules',
            status = '$status'
        WHERE activityId = '$activityId'");

    if($update){
        $_SESSION['activitySuccess'] = "Activity updated successfully.";
    }else{
        $_SESSION['activityError'] = "Failed to update activity.";
    }

    header("Location: manage_activity.php");
    exit();

?>