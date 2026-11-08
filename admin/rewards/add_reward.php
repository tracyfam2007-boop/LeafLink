<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_reward.php");
        exit();
    }

    $rewardName = trim($_POST['rewardName']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $pointRequired = trim($_POST['pointRequired']);
    $stock = trim($_POST['stock']);
    $status = trim($_POST['status']);

    $idQuery = mysqli_query($conn,
        "SELECT rewardId FROM reward
        ORDER BY rewardId DESC
        LIMIT 1");

    if(mysqli_num_rows($idQuery) == 0){
        $rewardId = "RW000001";
    }else{
        $lastReward = mysqli_fetch_assoc($idQuery);
        $lastNumber = (int)substr($lastReward['rewardId'],2);
        $newNumber = $lastNumber + 1;
        $rewardId = "RW".str_pad($newNumber,6,"0",STR_PAD_LEFT);
    }

    $insert = mysqli_query($conn,
        "INSERT INTO reward(
            rewardId,
            rewardName,
            description,
            image,
            pointRequired,
            stock,
            status)

        VALUES (
            '$rewardId',
            '$rewardName',
            '$description',
            '$image',
            '$pointRequired',
            '$stock',
            '$status')"
    );

    if($insert){
        $_SESSION['rewardSuccess'] = "Reward added successfully.";
    }else{
        $_SESSION['rewardError'] = "Failed to add reward.";

    }

    header("Location: manage_reward.php");
    exit();

?>