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

    $earnedQuery = mysqli_query($conn,
        "SELECT COALESCE(SUM(pointChange), 0) AS total
        FROM pointtransaction
        WHERE transactionType = 'Earn'
        OR transactionType = 'Refund'
        AND transactionDate BETWEEN '$startDate' AND '$endDate'");

    $totalEarned = 0;

    if($earnedQuery){
        $earnedRow = mysqli_fetch_assoc($earnedQuery);
        $totalEarned = (int)$earnedRow['total'];
    }

    $redeemedQuery = mysqli_query($conn, 
        "SELECT COALESCE(SUM(ABS(pointChange)), 0) AS total
        FROM pointtransaction
        WHERE transactionType = 'Redeem'
        AND transactionDate BETWEEN '$startDate' AND '$endDate'");

    $totalRedeemed = 0;

    if($redeemedQuery){
        $redeemedRow = mysqli_fetch_assoc($redeemedQuery);
        $totalRedeemed = (int)$redeemedRow['total'];
    }

    $netPoints = $totalEarned - $totalRedeemed;

    $transactionQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM pointtransaction
        WHERE transactionDate
        BETWEEN '$startDate' AND '$endDate'");

    $totalTransactions = 0;

    if($transactionQuery){
        $transactionRow = mysqli_fetch_assoc($transactionQuery);
        $totalTransactions = (int)$transactionRow['total'];
    }

    $monthLabels = [];
    $earnedData = [];
    $redeemedData = [];

    $monthlyQuery = mysqli_query($conn,
        "SELECT
            DATE_FORMAT(transactionDate, '%Y-%m') AS month,
            SUM(
                CASE
                    WHEN transactionType = 'Earn'
                    OR transactionType = 'Refund'
                    THEN pointChange
                    ELSE 0
                END
            ) AS earned,
            SUM(
                CASE
                    WHEN transactionType = 'Redeem'
                    THEN ABS(pointChange)
                    ELSE 0
                END
            ) AS redeemed
        FROM pointtransaction
        WHERE transactionDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY DATE_FORMAT(transactionDate, '%Y-%m')
        ORDER BY month ASC");

    if($monthlyQuery){
        while($row = mysqli_fetch_assoc($monthlyQuery)){
            $monthLabels[] = date(
                'M Y',
                strtotime($row['month'] . '-01')
            );
            $earnedData[] = (int)$row['earned'];
            $redeemedData[] = (int)$row['redeemed'];
        }
    }

    $activityLabels = [];
    $activityData = [];

    $activityQuery = mysqli_query($conn, 
        "SELECT
            a.activityName,
            COALESCE(SUM(pt.pointChange), 0) AS totalPoints
        FROM pointtransaction pt

        INNER JOIN activitysubmission ass
        ON pt.submissionId = ass.submissionId
        
        INNER JOIN activity a
        ON ass.activityId = a.activityId
        
        WHERE pt.transactionType = 'Earn'
        AND pt.transactionDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY a.activityId, a.activityName
        ORDER BY totalPoints DESC");

    if($activityQuery){
        while($row = mysqli_fetch_assoc($activityQuery)){
            $activityLabels[] = $row['activityName'];
            $activityData[] = (int)$row['totalPoints'];
        }
    }

?>

<main class="main-content">

    <h1 class="dashboard-title">Point Distribution Report</h1>

    <p class="dashboard-subtitle">
        View and distribution of points earned and redeemed within the selected period.
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
                    href="point_distribution_report.php"
                    class="report-reset-btn">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <div class="report-summary-grid">

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>

            <div>
                <h3><?= $totalEarned; ?></h3>
                <p>Total Points Earned</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-gift"></i>
            </div>

            <div>
                <h3><?= $totalRedeemed; ?></h3>
                <p>Total Points Redeemed</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-coins"></i>
            </div>

            <div>
                <h3><?= number_format($netPoints); ?></h3>
                <p>Net Points</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-receipt"></i>
            </div>

            <div>
                <h3><?= number_format($totalTransactions); ?></h3>
                <p>Points Transactions</p>
            </div>
        </div>

    </div>

    <div class="report-chart-grid">

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Monthly Point Distribution</h2>
            </div>

            <div class="chart-container">
                <canvas id="pointDistributionChart"></canvas>
            </div>
        </div>

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Points Earned by Green Activity</h2>
            </div>

            <div class="chart-container">
                <canvas id="pointsByActivityChart"></canvas>
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
    const pointDistributionLabels = <?= json_encode($monthLabels); ?>;
    const pointEarnedData = <?= json_encode($earnedData); ?>;
    const pointRedeemedData = <?= json_encode($redeemedData); ?>;
    const pointsByActivityLabels = <?= json_encode($activityLabels); ?>;
    const pointsByActivityData = <?= json_encode($activityData); ?>;

    createPointDistributionChart(
        pointDistributionLabels,
        pointEarnedData,
        pointRedeemedData
    );

    createPointsByActivityChart(
        pointsByActivityLabels,
        pointsByActivityData
    );
</script>

<?php
    include '../includes/footer.php'
?>