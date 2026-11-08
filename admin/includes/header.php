<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }


    $fullname = $_SESSION['fullName'] ?? "Admin";

    require_once __DIR__ . '/../../database/db_connect.php';
    
    $notificationCountQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM abnormalreport
        WHERE remark IS NULL OR remark = ''");
    $notificationCount = mysqli_fetch_assoc($notificationCountQuery)['total'];

    $notificationQuery = mysqli_query($conn,
        "SELECT 
            user.fullName,
            abnormalreport.reason,
            abnormalreport.reportDate
            
        FROM abnormalreport
        
        INNER JOIN activitysubmission
        ON abnormalreport.submissionId = activitysubmission.submissionId
        
        INNER JOIN participant
        ON activitysubmission.participantId = participant.participantId
        
        INNER JOIN user
        ON participant.userId = user.userId

        WHERE abnormalreport.remark IS NULL
        OR abnormalreport.remark = ''
        
        ORDER BY abnormalreport.reportDate DESC
        
        LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeafLink Admin</title>

    <link rel="stylesheet" href="/LeafLink/admin/admin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/LeafLink/admin/chart.js"></script>

</head>
<body>

    <div class="admin-header">
        
        <div class="header-left">

            <img src="/LeafLink/images/logo.jpg" alt="LeafLink Logo">

        </div>

        <div class="header-right">

            <div class="notification">

                <i class="fa-regular fa-bell"></i>

                <span class="notification-count">
                    <?= $notificationCount ?>
                </span>

                <div class="notification-dropdown">

                    <h4>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Abnormal Reports (<?= $notificationCount ?>)
                    </h4>

                    <hr>

                    <?php if(mysqli_num_rows($notificationQuery) > 0){ ?>
                    
                        <?php while($notification = mysqli_fetch_assoc($notificationQuery)){ ?>
                            
                            <strong>
                                <i class="fa-solid fa-user"></i>
                                <?= $notification['fullName'] ?>
                            </strong>

                            <br>

                            <p class="notification-reason">
                                <?= $notification['reason'] ?>
                            </p>

                            <span class="notification-date">
                                <?= date(" d M Y", strtotime($notification['reportDate'])) ?>
                            </span>
                            <hr>
                        
                        <?php } ?>
                    
                    <?php }else{ ?>

                        <p class="no-notification">
                            No abnormal reports.
                        </p>

                    <?php } ?>

                    <a href="/LeafLink/admin/abnormal_reports/manage_abnormalreport.php">
                        View All Abnormal Reports
                    </a>

                </div>

            </div>

            <div class="profile-menu">

                <div class="profile-avatar">

                    <i class="fa-solid fa-user"></i>

                </div>

                <span><?= $fullname; ?></span>

                <i class="fa-solid fa-chevron-down"></i>

                <div class="profile-dropdown">
                    <a href="#" onclick="showLogoutModal(event)">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>
                </div>

            </div>

        </div>

    </div>

    <div class="admin-container">