<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_activity.php");
        exit();
    }

    $activityName = trim($_POST['activityName']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $pointsReward = trim($_POST['pointsReward']);
    $rules = trim($_POST['rules']);
    $status = trim($_POST['status']);

    $idQuery = mysqli_query($conn,
        "SELECT activityId FROM activity
        ORDER BY activityId DESC
        LIMIT 1");

    if(mysqli_num_rows($idQuery) == 0){
        $activityId = "A000001";
    }else{
        $lastActivity = mysqli_fetch_assoc($idQuery);
        $lastNumber = (int)substr($lastActivity['activityId'],1);
        $newNumber = $lastNumber + 1;
        $activityId = "A".str_pad($newNumber,6,"0",STR_PAD_LEFT);
    }

    $insert = mysqli_query($conn,
        "INSERT INTO activity(
            activityId,
            activityName,
            description,
            category,
            pointsReward,
            rules,
            status)

        VALUES (
            '$activityId',
            '$activityName',
            '$description',
            '$category',
            '$pointsReward',
            '$rules',
            '$status')"
    );

    if($insert){
        $_SESSION['activitySuccess'] = "Activity added successfully.";
    }else{
        $_SESSION['activityError'] = "Failed to add activity.";
    }
    
    header("Location: manage_activity.php");
    exit();

?>