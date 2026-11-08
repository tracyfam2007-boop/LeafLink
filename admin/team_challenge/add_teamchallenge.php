<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_teamchallenge.php");
        exit();
    }

    $challengeName = trim($_POST['challengeName']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $challengePoint = trim($_POST['challengePoint']);
    $status = trim($_POST['status']);

    $idQuery = mysqli_query($conn,
        "SELECT challengeId FROM teamchallenge
        ORDER BY challengeId DESC
        LIMIT 1");

    if(mysqli_num_rows($idQuery) == 0){
        $challengeId = "TC000001";
    }else{
        $lastChallenge = mysqli_fetch_assoc($idQuery);
        $lastNumber = (int)substr($lastChallenge['challengeId'],2);
        $newNumber = $lastNumber + 1;
        $challengeId = "TC".str_pad($newNumber,6,"0",STR_PAD_LEFT);
    }

    $insert = mysqli_query($conn,
        "INSERT INTO teamchallenge(
            challengeId,
            challengeName,
            startDate,
            endDate,
            status,
            challengePoint)
        VALUES(
            '$challengeId',
            '$challengeName',
            '$startDate',
            '$endDate',
            '$status',
            '$challengePoint')"
        );

    if($insert){
        $_SESSION['challengeSuccess'] = "Team challenge added successfully.";
    }else{
        $_SESSION['challengeError'] = "Failed to add team challenge.";
    }

    header("Location: manage_teamchallenge.php");
    exit();

?>