<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';
    include '../../database/db_connect.php';

    $participantQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM participant");

    $totalParticipants = 0;

    if($participantQuery){
        $participantResult = mysqli_fetch_assoc($participantQuery);
        $totalParticipants = $participantResult['total'];
    }

    $activityQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activity
        WHERE status = 'Active'");

    $totalActivities = 0;

    if($activityQuery){
        $activityResult = mysqli_fetch_assoc($activityQuery);
        $totalActivities = $activityResult['total'];
    }

    $submissionQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activitysubmission");

    $totalSubmissions = 0;

    if($submissionQuery){
        $submissionResult = mysqli_fetch_assoc($submissionQuery);
        $totalSubmissions = $submissionResult['total'];
    }

    $pointsQuery = mysqli_query($conn,
        "SELECT
            COALESCE(SUM(pointChange), 0) AS total
        FROM pointtransaction
        WHERE transactionType = 'Earn'
        OR transactionType = 'Refund'");

    $totalPointsEarned = 0;

    if($pointsQuery){
        $pointsResult = mysqli_fetch_assoc($pointsQuery);
        $totalPointsEarned = $pointsResult['total'];
    }

?>

<main class="main-content">

    <h1 class="dashboard-title">View System Reports</h1>

    <p class="dashboard-subtitle">
        View and analyze system performance and user participation.
    </p>

    <div class="report-summary-grid">

        <div class="report-summary-card">

            <div class="report-summary-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <h3>
                    <?= $totalParticipants; ?>
                </h3>

                <p>Total Participants</p>
            </div>

        </div>

        <div class="report-summary-card">

            <div class="report-summary-icon">
                <i class="fa-solid fa-leaf"></i>
            </div>

            <div>
                <h3>
                    <?= $totalActivities; ?>
                </h3>

                <p>Active Activities</p>
            </div>

        </div>

        <div class="report-summary-card">

            <div class="report-summary-icon">
                <i class="fa-solid fa-list-check"></i>
            </div>

            <div>
                <h3>
                    <?= $totalSubmissions; ?>
                </h3>

                <p>Total Submissions</p>
            </div>

        </div>

        <div class="report-summary-card">

            <div class="report-summary-icon">
                <i class="fa-solid fa-star"></i>
            </div>

            <div>
                <h3>
                    <?= $totalPointsEarned; ?>
                </h3>

                <p>Points Earned</p>
            </div>

        </div>

    </div>

    <h2 class="report-section-title">
        Detailed Reports
    </h2>

    <div class="report-link-grid">

        <a
            href="user_participation_report.php"
            class="report-link-card">
            <i class="fa-solid fa-users"></i>

            <div>
                <h3>User Participation Report</h3>
                <p>View user participation and activity submission trends.</p>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a
            href="point_distribution_report.php"
            class="report-link-card">
            <i class="fa-solid fa-chart-column"></i>

            <div>
                <h3>Point Distribution Report</h3>
                <p>Analyze points earned and redeemed by participants.</p>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a
            href="reward_redemption_report.php"
            class="report-link-card">
            <i class="fa-solid fa-gift"></i>

            <div>
                <h3>Reward Redemption Report</h3>
                <p>View reward redemption activity and redemption status.</p>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a
            href="green_activity_report.php"
            class="report-link-card">
            <i class="fa-solid fa-leaf"></i>

            <div>
                <h3>Green Activity Report</h3>
                <p>Analyze participation in green activities.</p>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a
            href="team_challenge_report.php"
            class="report-link-card">
            <i class="fa-solid fa-people-group"></i>

            <div>
                <h3>Team Challenge Report</h3>
                <p>View team challenge participation and activity.</p>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

    </div>

</main>

<?php
    include '../includes/footer.php';
?>