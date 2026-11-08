<?php
    session_start();

    include '../database/db_connect.php';
    include 'includes/header.php';
    include 'includes/sidebar.php'; 

    $activityQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activitysubmission
        WHERE status='Pending'");

    $pendingActivities = mysqli_fetch_assoc($activityQuery)['total'];

    $rewardQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM rewardredemption
        WHERE status='Pending'");

    $pendingRewards = mysqli_fetch_assoc($rewardQuery)['total'];

    $abnormalQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM abnormalreport
        WHERE remark IS NULL
        OR remark = ''");

    $pendingReports = mysqli_fetch_assoc($abnormalQuery)['total'];

    $recentActivities = mysqli_query($conn,
        "SELECT
            user.fullName,
            activity.activityName,
            activity.pointsReward,
            activitysubmission.status,
            activitysubmission.submissionDate
            
        FROM activitysubmission
        
        INNER JOIN participant
        ON activitysubmission.participantId = participant.participantId
        
        INNER JOIN user
        ON participant.userId = user.userId
        
        INNER JOIN activity
        ON activitysubmission.activityId = activity.activityId
        
        ORDER BY activitysubmission.submissionDate DESC, activitysubmission.submissionTime DESC
        
        LIMIT 5");

    $topActivities = mysqli_query($conn,
        "SELECT
            activity.activityName,
            COUNT(activitysubmission.submissionId) AS totalSubmission
        FROM activity
        
        LEFT JOIN activitysubmission
        ON activity.activityId = activitysubmission.activityId
        
        GROUP BY activity.activityId
        
        ORDER BY totalSubmission DESC
        
        LIMIT 5");
?>

<main class="main-content">

    <h1 class="dashboard-title">Admin Dashboard</h1>

    <p class="dashboard-subtitle">
        Welcome back,
        <strong><?= $_SESSION['fullName']; ?></strong>!
        Here's what's happening in LeafLink today.
    </p>

    <h2 class="section-title">Quick Actions</h2>

    <div class="stats-container">

        <a href="users/manage_user.php" class="stat-card">
            <h3>Manage Users</h3>
            <h2>
                <i class="fa-solid fa-users"></i>
            </h2>
        </a>

        <a href="activities/manage_activity.php" class="stat-card">
            <h3>Manage Activities</h3>
            <h2>
                <i class="fa-solid fa-leaf"></i>
            </h2>
        </a>

        <a href="rewards/manage_reward.php" class="stat-card">
            <h3>Manage Rewards</h3>
            <h2>
                <i class="fa-solid fa-gift"></i>
            </h2>
        </a>

        <a href="badges/manage_badge.php" class="stat-card">
            <h3>Manage Badges</h3>
            <h2>
                <i class="fa-solid fa-award"></i>
            </h2>
        </a>

    </div>

    <div class="quick-review">

        <h2>Quick Review</h2>

        <div class="quick-review-grid">

            <div class="review-card">
                <h3>Pending Activities</h3>
                <p><?= $pendingActivities; ?></p>
            </div>

            <div class="review-card">
                <h3>Pending Reward Redemption</h3>
                <p><?= $pendingRewards; ?></p>
            </div>

            <div class="review-card">
                <h3>Pending Abnormal Reports</h3>
                <p><?= $pendingReports; ?></p>
            </div>

        </div>

    </div>

    <div class="table-card">

        <h2>Recent Activities</h2>

        <table class="recent-table">

            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Activity</th>
                    <th>Points</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

                <?php if(mysqli_num_rows($recentActivities) > 0){ ?>

                    <?php while($row = mysqli_fetch_assoc($recentActivities)){ ?>
                    
                    <tr>
                        <td><?= $row['fullName'] ?></td>
                        <td><?= $row['activityName'] ?></td>
                        <td><?= $row['pointsReward'] ?></td>
                        <td>
                            <span class="status <?= strtolower($row['status']) ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        
                        <td>
                            <?= date("d M Y", strtotime($row['submissionDate'])) ?>
                        </td>
                    </tr>
                
                    <?php } ?>
                
                <?php }else{ ?>

                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px;">
                            No activity submissions found.
                        </td>
                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <div class="top-activities-card">

        <h2>Top Activities</h2>

        <div class="activity-rank">

            <?php
                if(mysqli_num_rows($topActivities) > 0){
                    $rank = 1;
                    while($row = mysqli_fetch_assoc($topActivities)){
            ?>

            <div class="rank-item">

                <?php if($rank == 1){ ?>

                    <span class="rank-number gold">🥇</span>
                
                <?php }elseif($rank == 2){ ?>

                    <span class="rank-number silver">🥈</span>

                <?php }elseif($rank == 3){ ?>

                    <span class="rank-number bronze">🥉</span>
                
                <?php }else{ ?>

                    <span class="rank-number"><?= $rank ?></span>

                <?php } ?>

                <div class="rank-info">
                    <strong><?= $row['activityName'] ?></strong>
                    <small><?= $row['totalSubmission'] ?> Submission</small>
                </div>

            </div>

            <?php
                $rank++; }
                }else{ ?>

            <p style="text-align:center; color:#777; padding: 25px;">
                No activity submission found.
            </p>

            <?php
                }
            ?>

        </div>

    </div>

</main>

<?php
    include 'includes/footer.php';
?>