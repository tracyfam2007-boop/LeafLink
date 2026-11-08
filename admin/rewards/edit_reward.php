<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("location: manage_reward.php");
        exit();
    }

    $rewardId = $_POST['rewardId'];
    $rewardName = trim($_POST['rewardName']);
    $description = trim($_POST['description']);
    $pointRequired = trim($_POST['pointRequired']);
    $stock = trim($_POST['stock']);
    $status = trim($_POST['status']);

    $currentQuery = mysqli_query($conn,
        "SELECT image
        FROM reward
        WHERE rewardId = '$rewardId'"
    );

    $currentReward = mysqli_fetch_assoc($currentQuery);

    $currentImage = $currentReward['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];

        $imageExtension = strtolower(
            pathinfo($imageName, PATHINFO_EXTENSION)
        );

        $allowedExtensions = [
            "jpg",
            "jpeg",
            "png"
        ];

        if(!in_array($imageExtension, $allowedExtensions)){
            $_SESSION['rewardError'] = "Only JPG, JPEG and PNG images are allowed.";
            header("Location: manage_reward.php");
            exit();
        }

        if($imageSize > 5 * 1024 * 1024){
            $_SESSION['rewardError'] = "Image size must not exceed 5MB.";
            header("Location: manage_reward.php");
            exit();
        }

        $uploadFolder = "../../uploads/rewards/";

        $newImagePath = $uploadFolder . $imageName;

        if(!move_uploaded_file(
            $imageTmpName,
            $newImagePath
        )){
            $_SESSION['rewardError'] = "Failed to upload reward image.";
            header("Location: manage_reward.php");
            exit();
        }

        $image = $imageName;

    }else{

        $image = $currentImage;
    }

    $update = mysqli_query($conn,
        "UPDATE reward
        SET
            rewardName = '$rewardName',
            description = '$description',
            image = '$image',
            pointRequired = '$pointRequired',
            stock = '$stock',
            status = '$status'
        WHERE rewardId = '$rewardId'");

    if($update){
        $_SESSION['rewardSuccess'] = "Reward updated successfully.";
    }else{
        $_SESSION['rewardError'] = "Failed to update reward.";
    }

    header("Location: manage_reward.php");
    exit();

?>