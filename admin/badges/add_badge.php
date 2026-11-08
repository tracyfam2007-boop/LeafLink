<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_badge.php");
        exit();
    }

    $badgeName = trim($_POST['badgeName']);
    $description = trim($_POST['description']);
    $requiredPoints = trim($_POST['requiredPoints']);

    $idQuery = mysqli_query($conn,
        "SELECT badgeId FROM badge
        ORDER BY badgeId DESC
        LIMIT 1");

    if(mysqli_num_rows($idQuery) == 0){
        $badgeId = "B000001";
    }else{
        $lastBadge = mysqli_fetch_assoc($idQuery);
        $lastNumber = (int)substr($lastBadge['badgeId'],1);
        $newNumber = $lastNumber + 1;
        $badgeId = "B".str_pad($newNumber,6,"0",STR_PAD_LEFT);
    }

    $insert = mysqli_query($conn,
        "INSERT INTO badge(
            badgeId,
            badgeName,
            description,
            requiredPoints)

        VALUES(
            '$badgeId',
            '$badgeName',
            '$description',
            '$requiredPoints')"
        );

    if($insert){
        $_SESSION['badgeSuccess'] = "Badge added successfully.";
    }else{
        $_SESSION['badgeError'] = "Failed to add badge.";
    }
    
    header("Location: manage_badge.php");
    exit();

?>