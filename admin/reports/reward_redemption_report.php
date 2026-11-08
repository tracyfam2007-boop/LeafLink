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
        FROM rewardredemption
        WHERE redeemedDate
        BETWEEN '$startDate' AND '$endDate'");

    $totalRedemptions = 0;

    if($totalQuery){
        $totalRow = mysqli_fetch_assoc($totalQuery);
        $totalRedemptions = (int)$totalRow['total'];
    }

    $approvedQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM rewardredemption
        WHERE status = 'Approved'
        AND redeemedDate
        BETWEEN '$startDate' AND '$endDate'");

    $approvedRedemptions = 0;

    if($approvedQuery){
        $approvedRow = mysqli_fetch_assoc($approvedQuery);
        $approvedRedemptions = (int)$approvedRow['total'];
    }

    $pendingQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM rewardredemption
        WHERE status = 'Pending'
        AND redeemedDate
        BETWEEN '$startDate' AND '$endDate'");

    $pendingRedemptions = 0;

    if($pendingQuery){
        $pendingRow = mysqli_fetch_assoc($pendingQuery);
        $pendingRedemptions = (int)$pendingRow['total'];
    }

    $rejectedQuery = mysqli_query($conn,
        "SELECT COUNT(*) AS total
        FROM rewardredemption
        WHERE status = 'Rejected'
        AND redeemedDate
        BETWEEN '$startDate' AND '$endDate'");

    $rejectedRedemptions = 0;

    if($rejectedQuery){
        $rejectedRow = mysqli_fetch_assoc($rejectedQuery);
        $rejectedRedemptions = (int)$rejectedRow['total'];
    }

    $monthLabels = [];
    $redemptionData = [];

    $monthlyQuery = mysqli_query($conn,
        "SELECT
            DATE_FORMAT(redeemedDate, '%Y-%m') AS month,
            COUNT(*) AS totalRedemptions
        FROM rewardredemption
        WHERE redeemedDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY DATE_FORMAT(redeemedDate, '%Y-%m')
        ORDER BY month ASC");

    if($monthlyQuery){
        while($row = mysqli_fetch_assoc($monthlyQuery)){
            $monthLabels[] = date(
                'M Y',
                strtotime($row['month'] . '-01')
            );
            $redemptionData[] = (int)$row['totalRedemptions'];
        }
    }

    $rewardLabels = [];
    $rewardData = [];

    $rewardQuery = mysqli_query($conn,
        "SELECT
            r.rewardName,
            COUNT(rr.redemptionId) AS totalRedemptions
        FROM rewardredemption rr
        
        INNER JOIN reward r
        ON rr.rewardId = r.rewardId
        
        WHERE rr.redeemedDate
        BETWEEN '$startDate' AND '$endDate'
        GROUP BY r.rewardId, r.rewardName
        ORDER BY totalRedemptions DESC");

    if($rewardQuery){
        while($row = mysqli_fetch_assoc($rewardQuery)){
            $rewardLabels[] = $row['rewardName'];
            $rewardData[] = (int)$row['totalRedemptions'];
        }
    }

?>

<main class="main-content">

    <h1 class="dashboard-title">Reward Redemption Report</h1>

    <p class="dashboard-subtitle">
        View reward redemption activity within the selected period.
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
                    href="reward_redemption_report.php"
                    class="report-reset-btn">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <div class="report-summary-grid">

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-gift"></i>
            </div>

            <div>
                <h3><?= number_format($totalRedemptions); ?></h3>
                <p>Total Redemptions</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h3><?= number_format($approvedRedemptions); ?></h3>
                <p>Approved Redemptions</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div>
                <h3><?= number_format($pendingRedemptions); ?></h3>
                <p>Pending Redemptions</p>
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-icon">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>

            <div>
                <h3><?= number_format($rejectedRedemptions); ?></h3>
                <p>Rejected Redemptions</p>
            </div>
        </div>

    </div>

    <div class="report-chart-grid">

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Monthly Reward Redemptions</h2>
            </div>

            <div class="chart-container">
                <canvas id="rewardRedemptionChart"></canvas>
            </div>
        </div>

        <div class="report-chart-card">
            <div class="report-card-header">
                <h2>Most Redeemed Rewards</h2>
            </div>

            <div class="chart-container">
                <canvas id="mostRedeemedRewardChart"></canvas>
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
    const rewardRedemptionLabels = <?= json_encode($monthLabels); ?>;
    const rewardRedemptionData = <?= json_encode($redemptionData); ?>;
    const mostRedeemedRewardLabels = <?= json_encode($rewardLabels); ?>;
    const mostRedeemedRewardData = <?= json_encode($rewardData); ?>;

    createRewardRedemptionChart(
        rewardRedemptionLabels,
        rewardRedemptionData
    );

    createMostRedeemedRewardChart(
        mostRedeemedRewardLabels,
        mostRedeemedRewardData
    );
</script>

<?php
    include '../includes/footer.php';
?>