<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';
    include '../../database/db_connect.php';

    $fromMonth = isset($_GET['fromMonth']) ? (int)$_GET['fromMonth'] : date('n');
    $fromYear = isset($_GET['fromYear']) ? (int)$_GET['fromYear'] : date('Y');
    $toMonth = isset($_GET['toMonth']) ? (int)$_GET['toMonth'] : date('n');
    $toYear = isset($_GET['toYear']) ? (int)$_GET['toYear'] : date('Y');

    $startDate = sprintf(
        '%04d-%02d-01',
        $fromYear,
        $fromMonth
    );

    $endDate = date(
        'Y-m-t',
        strtotime(
            sprintf(
                '%04d-%02d-01',
                $toYear,
                $toMonth
            )
        )
    );

    $totalQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activitysubmission
        WHERE submissionDate
        BETWEEN '$startDate' AND '$endDate'");

    $totalSubmissions = 0;

    if($totalQuery){
        $totalResult = mysqli_fetch_assoc($totalQuery);
        $totalSubmissions = $totalResult['total']; 
    }

    $approvedQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activitysubmission
        WHERE status = 'Approved'
        AND submissionDate
        BETWEEN '$startDate' AND '$endDate'");

    $approvedSubmissions = 0;

    if($approvedQuery){
        $approvedResult = mysqli_fetch_assoc($approvedQuery);
        $approvedSubmissions = $approvedResult['total'];
    }

    $pendingQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activitysubmission
        WHERE status = 'Pending'
        AND submissionDate
        BETWEEN '$startDate' AND '$endDate'");

    $pendingSubmissions = 0;

    if($pendingQuery){
        $pendingResult = mysqli_fetch_assoc($pendingQuery);
        $pendingSubmissions = $pendingResult['total'];
    }

    $rejectedQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM activitysubmission
        WHERE status = 'Rejected'
        AND submissionDate
        BETWEEN '$startDate' AND '$endDate'");

    $rejectedSubmissions = 0;

    if($rejectedQuery){
        $rejectedResult = mysqli_fetch_assoc($rejectedQuery);
        $rejectedSubmissions = $rejectedResult['total'];
    }

    $monthLabels = [];
    $monthData = [];

    $monthlyQuery = mysqli_query($conn,
        "SELECT
            DATE_FORMAT(submissionDate, '%Y-%m') AS month,
            COUNT(*) AS total
        FROM activitysubmission
        WHERE submissionDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY DATE_FORMAT(submissionDate, '%Y-%m')
        ORDER BY month ASC");

    if($monthlyQuery){
        while($row = mysqli_fetch_assoc($monthlyQuery)){
            $monthLabels[] = date(
                'M Y',
                strtotime($row['month'] . '-01')
            );
            $monthData[] = (int)$row['total'];
        }
    }

    $activityLabels = [];
    $activityData = [];

    $activityQuery = mysqli_query($conn,
        "SELECT
            a.activityName,
            COUNT(ass.submissionId) AS total
        FROM activity a

        INNER JOIN activitysubmission ass
        ON a.activityId = ass.activityId

        WHERE ass.submissionDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY a.activityId, a.activityName
        ORDER BY total DESC");

    if($activityQuery){
        while($row = mysqli_fetch_assoc($activityQuery)){
            $activityLabels[] = $row['activityName'];
            $activityData[] = (int)$row['total'];
        }
    }

?>

<main class="main-content">

    <h1 class="dashboard-title">User Participation Report</h1>

    <p class="dashboard-subtitle">
        View and analyze user participation in green activities.
    </p>

    <div class="report-filter-card">

        <form method="GET">

            <div class="report-filter-group">

                <div class="filter-field">
                    <label>From</label>

                    <div class="month-year-input">

                        <select name="fromMonth">
                            <?php
                            for($month = 1; $month <= 12; $month++){
                            ?>
                                <option
                                    value="<?= $month; ?>"
                                    <?= ($month == $fromMonth) ? 'selected' : ''; ?>
                                >
                                    <?= date(
                                        'F',
                                        mktime(0, 0, 0, $month, 1)
                                    ); ?>
                                </option>

                            <?php } ?>
                        </select>

                        <select name="fromYear">
                            <?php
                            for($year = 2025; $year <= date('Y') + 1; $year++){
                            ?>
                                <option
                                    value="<?= $year; ?>"
                                    <?= ($year == $fromYear) ? 'selected' : ''; ?>
                                >
                                    <?= $year; ?>
                                </option>

                            <?php } ?>
                        </select>

                    </div>

                </div>

                <div class="filter-field">
                    <label>To</label>

                    <div class="month-year-input">

                        <select name="toMonth">
                            <?php
                            for($month = 1; $month <= 12; $month++){
                            ?>
                                <option
                                    value="<?= $month; ?>"
                                    <?= ($month == $toMonth) ? 'selected' : ''; ?>
                                >
                                    <?= date(
                                        'F',
                                        mktime(0, 0, 0, $month, 1)
                                    ); ?>
                                </option>

                            <?php } ?>
                        </select>

                        <select name="toYear">
                            <?php
                            for(
                                $year = 2025;
                                $year <= date('Y') + 1;
                                $year++
                            ){
                            ?>
                                <option
                                    value="<?= $year; ?>"
                                    <?= ($year == $toYear) ? 'selected' : ''; ?>
                                >
                                    <?= $year; ?>
                                </option>

                            <?php } ?>
                        </select>

                    </div>

                </div>

                <button type="submit" class="report-filter-btn">
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>

                <a
                    href="user_participation_report.php"
                    class="report-reset-btn">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <div class="report-summary-grid">

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-list-check"></i>
            </div>

            <div>
                <h3><?= $totalSubmissions; ?></h3>
                <p>Total Submissions</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h3><?= $approvedSubmissions; ?></h3>
                <p>Approved Submissions</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div>
                <h3><?= $pendingSubmissions; ?></h3>
                <p>Pending Submissions</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>

            <div>
                <h3><?= $rejectedSubmissions; ?></h3>
                <p>Rejected Submissions</p>
            </div>
        </div>

    </div>

    <div class="report-chart-grid">

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>User Participation Trend</h2>
            </div>

            <div class="chart-container">
                <canvas id="userParticipationChart"></canvas>
            </div>
        </div>

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Participation by Green Activity</h2>
            </div>

            <div class="chart-container">
                <canvas id="greenActivityChart"></canvas>
            </div>
        </div>

    </div>

    <div class="report-back-container">
        <a
            href="manage_report.php"
            class="cancel-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Reports
        </a>
    </div>

</main>

<script>
    const userParticipationLabels = <?= json_encode($monthLabels); ?>;
    const userParticipationData = <?= json_encode($monthData); ?>;
    const greenActivityLabels = <?= json_encode($activityLabels); ?>;
    const greenActivityData = <?= json_encode($activityData); ?>;

    createUserParticipationChart(
        userParticipationLabels,
        userParticipationData
    );

    createGreenActivityChart(
        greenActivityLabels,
        greenActivityData
    );
</script>

<?php
    include '../includes/footer.php';
?>