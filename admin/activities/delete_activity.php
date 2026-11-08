<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_activity.php");
        exit();
    }

    $activityId = $_POST['activityId'];

    $delete = mysqli_query($conn,
        "DELETE FROM activity
        WHERE activityId='$activityId'");

    if($delete){
        $_SESSION['activitySuccess'] = "Activity deleted successfully.";
    }else{
        $_SESSION['activityError'] = "Failed to delete activity.";
    }

    header("Location: manage_activity.php");
    exit();

?>