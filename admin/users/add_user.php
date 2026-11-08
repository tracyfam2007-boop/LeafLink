<?php
    session_start();

    include'../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_user.php");
        exit();
    }

    $fullName = trim($_POST['fullName']);
    $emailAddress = trim($_POST['emailAddress']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $dateOfBirth = $_POST['dateOfBirth'];
    $roleName = $_POST['role'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $participantType = $_POST['participantType'] ?? "";
    $faculty = $_POST['faculty'] ?? "";

    if($password != $confirmPassword){
        $_SESSION['addUserError'] = "Password and Confirm Password do not match.";
        header("Location: manage_user.php");
        exit();
    }

    $emailCheck = mysqli_query($conn, 
        "SELECT * FROM user
        WHERE emailAddress='$emailAddress'");
    
    if(mysqli_num_rows($emailCheck) > 0){
        $_SESSION['addUserError'] = "This email address is already registered.";
        header("Location: manage_user.php");
        exit();
    }

    $roleQuery = mysqli_query($conn,
        "SELECT roleId FROM role
        WHERE roleName = '$roleName'");

    if(mysqli_num_rows($roleQuery) == 0){

        $_SESSION['addUserError'] = "Invalid role selected.";
        header("Location: manage_user.php");
        exit();
    }

    $roleData = mysqli_fetch_assoc($roleQuery);
    $roleId = $roleData['roleId'];

    $userIdQuery = mysqli_query($conn, 
        "SELECT userId FROM user
        ORDER BY userId DESC
        LIMIT 1");
    
    if(mysqli_num_rows($userIdQuery) == 0){
        $userId = "U000001";
    }else{
        $lastUser = mysqli_fetch_assoc($userIdQuery);
        $lastNumber = (int) substr($lastUser['userId'], 1);
        $newNumber = $lastNumber + 1;
        $userId = "U" . str_pad($newNumber, 6, "0", STR_PAD_LEFT);
    }

    $participantId = "";

    if($roleName == "Participant"){

        $participantQuery = mysqli_query($conn,
            "SELECT participantId FROM participant
            ORDER BY participantId DESC
            LIMIT 1");

        if(mysqli_num_rows($participantQuery) == 0){
            $participantId = "P000001";
        }else{
            $lastParticipant = mysqli_fetch_assoc($participantQuery);
            $lastNumber = (int) substr($lastParticipant['participantId'], 1);
            $newNumber = $lastNumber + 1;
            $participantId = "P" . str_pad($newNumber, 6, "0", STR_PAD_LEFT);
        }
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertUser = mysqli_query($conn,
        "INSERT INTO user
        (
            userId,
            roleId,
            fullName,
            emailAddress,
            phoneNumber,
            password,
            dateOfBirth
        )

        VALUES
        (
            '$userId',
            '$roleId',
            '$fullName',
            '$emailAddress',
            '$phoneNumber',
            '$hashedPassword',
            '$dateOfBirth'
        )"

    );

    if(!$insertUser){
        die("Error inserting user: " . mysqli_error($conn));
    }

    if($roleName == "Participant"){

        $insertParticipant = mysqli_query($conn,
            "INSERT INTO participant
            (
                participantId,
                participantType,
                faculty,
                pointBalance,
                userId
            )

            VALUES
            (
                '$participantId',
                '$participantType',
                '$faculty',
                0,
                '$userId'
            )"

        );

        if(!$insertParticipant){
            die("Error inserting participant: " . mysqli_error($conn));
        }

    }

    $_SESSION['successMessage'] = "User added successfully.";
    header("Location: manage_user.php");
    exit();

?>