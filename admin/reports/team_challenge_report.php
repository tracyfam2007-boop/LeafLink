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
        FROM teamchallenge
        WHERE startDate
        BETWEEN '$startDate' AND '$endDate'");

    $totalChallenges = 0;

    if($totalQuery){
        $totalRow = mysqli_fetch_assoc($totalQuery);
        $totalChallenges = (int)$totalRow['total'];
    }

    $activeQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM teamchallenge
        WHERE status = 'Active'
        AND startDate
        BETWEEN '$startDate' AND '$endDate'");

    $activeChallenges = 0;

    if($activeQuery){
        $activeRow = mysqli_fetch_assoc($activeQuery);
        $activeChallenges = (int)$activeRow['total'];
    }

    $inactiveQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM teamchallenge
        WHERE status = 'Inactive'
        AND startDate
        BETWEEN '$startDate' AND '$endDate'");

    $inactiveChallenges = 0;

    if($inactiveQuery){
        $inactiveRow = mysqli_fetch_assoc($inactiveQuery);
        $inactiveChallenges = (int)$inactiveRow['total'];
    }

    $memberQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM teammember tm
        
        INNER JOIN teamchallenge tc
        ON tm.challengeId = tc.challengeId
        
        WHERE tc.startdate
        BETWEEN '$startDate' AND '$endDate'");

    $totalMembers = 0;

    if($memberQuery){
        $memberRow = mysqli_fetch_assoc($memberQuery);
        $totalMembers = (int)$memberRow['total'];
    }

    $monthLabels = [];
    $challengeData = [];

    $monthlyQuery = mysqli_query($conn,
        "SELECT
            DATE_FORMAT(startDate, '%Y-%m') AS month,
            COUNT(*) AS totalChallenges
        FROM teamchallenge
        WHERE startDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY DATE_FORMAT(startDate, '%Y-%m')
        ORDER BY month ASC");

    if($monthlyQuery){
        while($row = mysqli_fetch_assoc($monthlyQuery)){
            $monthLabels[] = date(
                'M Y',
                strtotime($row['month'] . '-01')
            );
            $challengeData[] = (int)$row['totalChallenges'];
        }
    }

    $challengeLabels = [];
    $memberData = [];

    $participationQuery = mysqli_query($conn,
        "SELECT
            tc.challengeName,
            (
                SELECT COUNT(*)
                FROM teammember tm
                WHERE tm.challengeId = tc.challengeId
            ) AS totalMembers
        FROM teamchallenge tc
        WHERE tc.startDate
        BETWEEN '$startDate' AND '$endDate'
        ORDER BY totalMembers DESC");

    if($participationQuery){
        while($row = mysqli_fetch_assoc($participationQuery)){
            $challengeLabels[] = $row['challengeName'];
            $memberData[] = (int)$row['totalMembers'];
        }
    }

?>

<main class="main-content">

    <h1 class="dashboard-title">Team Challenge Report</h1>

    <p class="dashboard-subtitle">
        View team challenge participation and activity statistics within the selected period.
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
                    href="team_challenge_report.php"
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
                <h3><?= number_format($totalChallenges); ?></h3>
                <p>Total Team Challenges</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h3><?= number_format($activeChallenges); ?></h3>
                <p>Active Challenges</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div>
                <h3><?= number_format($inactiveChallenges); ?></h3>
                <p>Inactive Challenges</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <h3><?= number_format($totalMembers); ?></h3>
                <p>Total Team Members</p>
            </div>
        </div>

    </div>

    <div class="report-chart-grid">

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Monthly Team Challenges</h2>
            </div>

            <div class="chart-container">
                <canvas id="teamChallengeChart"></canvas>
            </div>
        </div>

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Team Members by Team Challenge</h2>
            </div>

            <div class="chart-container">
                <canvas id="teamChallengeParticipationChart"></canvas>
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
    const teamChallengeMonthLabels = <?= json_encode($monthLabels); ?>;
    const teamChallengeMonthData = <?= json_encode($challengeData); ?>;
    const teamChallengeLabels = <?= json_encode($challengeLabels); ?>;
    const teamChallengeData = <?= json_encode($memberData); ?>;

    createTeamChallengeChart(
        teamChallengeMonthLabels,
        teamChallengeMonthData
    );

    createTeamChallengeParticipationChart(
        teamChallengeLabels,
        teamChallengeData
    );
</script>

<?php
    include '../includes/footer.php';
?>