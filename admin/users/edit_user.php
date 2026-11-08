<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_user.php");
        exit();
    }

    $userId = $_POST['userId'];
    $fullName = trim($_POST['fullName']);
    $emailAddress = trim($_POST['emailAddress']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $dateOfBirth = $_POST['dateOfBirth'];

    $emailCheck = mysqli_query($conn, 
        "SELECT * FROM user
        WHERE emailAddress='$emailAddress'
        AND userId != '$userId'");

    if(mysqli_num_rows($emailCheck) > 0){
        $_SESSION['editUserError'] = "This email address is already registered.";
        header("Location: manage_user.php");
        exit();
    }

    $updateUser = mysqli_query($conn,
        "UPDATE user
        SET
            fullName='$fullName',
            emailAddress = '$emailAddress',
            phoneNumber = '$phoneNumber',
            dateOfBirth = '$dateOfBirth'
        WHERE userId = '$userId'");

    if(!$updateUser){
        die(mysqli_error($conn));
    }
    $_SESSION['successMessage'] = "User updated successfully.";
    header("Location: manage_user.php");
    exit();

?>