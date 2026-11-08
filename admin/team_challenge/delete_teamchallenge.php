<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_teamchallenge.php");
        exit();
    }

    $challengeId = $_POST['challengeId'];

    $delete = mysqli_query($conn,
        "DELETE FROM teamchallenge
        WHERE challengeId='$challengeId'");

    if($delete){
        $_SESSION['challengeSuccess'] = "Team challenge deleted successfully.";
    }else{
        $_SESSION['challengeError'] = "Failed to delete team challenge.";
    }

    header("Location: manage_teamchallenge.php");
    exit();

?>