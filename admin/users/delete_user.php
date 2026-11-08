<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: manage_user.php");
        exit();
    }

    $userId = $_POST['userId'];

    $userQuery = mysqli_query($conn,
        "SELECT
            user.userId,
            role.roleName
        FROM user
        INNER JOIN role
        ON user.roleId = role.roleId
        WHERE user.userId = '$userId'");

    if(mysqli_num_rows($userQuery) == 0){
        $_SESSION['deleteUserError'] = "User not found.";
        header("Location: manage_user.php");
        exit();
    }

    $user = mysqli_fetch_assoc($userQuery);

    if(isset($_SESSION['userId']) && $_SESSION['userId'] == $userId){
        $_SESSION['deleteUserError'] = "You cannot delete your own account.";
        header("Location: manage_user.php");
        exit();
    }

    $deleteUser = mysqli_query($conn, 
        "DELETE FROM user
        WHERE userId='$userId'");

    if(!$deleteUser){
        die("Delete Failed : " . mysqli_error($conn));
    }

    $_SESSION['successMessage'] = "User deleted successfully.";
    header("Location: manage_user.php");
    exit();

?>