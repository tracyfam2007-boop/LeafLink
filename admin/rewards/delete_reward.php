<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_reward.php");
        exit();
    }

    $rewardId = $_POST['rewardId'];

    $delete = mysqli_query($conn,
        "DELETE FROM reward
        WHERE rewardId='$rewardId'");

    if($delete){
        $_SESSION['rewardSuccess'] = "Reward deleted successfully.";
    }else{
        $_SESSION['rewardError'] = "Failed to delete reward.";
    }

    header("Location: manage_reward.php");
    exit();

?>