<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';
    include '../../database/db_connect.php';

    $search = "";

    if(isset($_GET['search'])){
        $search = trim($_GET['search']);
    }

    $sql = 
        "SELECT
            ar.abnormalId,
            ar.submissionId,
            ar.moderatorId,
            ar.reason,
            ar.reportDate,
            ar.remark,
            u.fullName AS moderatorName
        FROM abnormalreport ar
        
        LEFT JOIN user u
        ON ar.moderatorId = u.userId
        
        WHERE 1";

    if($search != ""){
        $sql .= "
            AND (
                ar.abnormalId LIKE '%$search%'
                OR ar.submissionId LIKE '%$search%'
                OR ar.moderatorId LIKE '%$search%'
                OR ar.reason LIKE '%$search%'
                OR u.fullName LIKE '%$search%')";
    }

    $sql .= "
        ORDER BY ar.reportDate DESC, ar.abnormalId DESC";

    $reportQuery = mysqli_query($conn, $sql);

?>

<main class="main-content">

    <?php if(isset($_SESSION['reportSuccess'])): ?>

        <div class="success-message">
            <?= $_SESSION['reportSuccess']; ?>
        </div>

        <?php 
            unset($_SESSION['reportSuccess']);
            endif;
        ?>

    <?php if(isset($_SESSION['reportError'])): ?>

        <div class="error-message">
            <?= $_SESSION['reportError']; ?>
        </div>

        <?php
            unset($_SESSION['reportError']);
            endif;
        ?>

    <h1 class="dashboard-title">Abnormal Reports</h1>

    <p class="dashboard-subtitle">
        View and manage abnormal activity reports.
    </p>

    <form class="toolbar" method="GET">

        <input
            type="text"
            name="search"
            class="search-box"
            placeholder="Search Abnormal Report ID, Submission ID or Reason..."
            value="<?= $search; ?>">

        <button type="submit" class="filter-btn">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>

    </form>

    <div class="table-card">

        <table class="recent-table">

            <thead>
                <tr>
                    <th>Abnormal ID</th>
                    <th>Submission ID</th>
                    <th>Reported By</th>
                    <th>Reason</th>
                    <th>Reported date</th>
                    <th>Remark</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    if(mysqli_num_rows($reportQuery) > 0){
                        while($row = mysqli_fetch_assoc($reportQuery)){
                ?>

                <tr>
                    <td><?= $row['abnormalId']; ?></td>
                    <td><?= $row['submissionId']; ?></td>
                    <td>
                        <?php
                            if(!empty($row['moderatorName'])){
                                echo $row['moderatorName'];
                            }else{
                                echo $row['moderatorId'];
                            }
                        ?>
                    </td>
                    <td><?= $row['reason']; ?></td>
                    <td><?= $row['reportDate']; ?></td>
                    <td>
                        <?php
                            if(!empty($row['remark'])): ?>
                                <?= $row['remark']; ?>
                            <?php else: ?>
                                <span style="color:#888;">
                                    No remark
                                </span>
                            <?php endif; ?>
                    </td>
                    <td>
                        <a 
                            href="abnormal_report_details.php?abnormalId=<?= $row['abnormalId']; ?>"
                            class="action-btn view-btn"
                            title="View Report">
                                <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                
                </tr>

                <?php 
                        }
                    }else{
                    ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:25px;">
                        No abnormal reports found.
                    </td>
                </tr>
                
                <?php } ?>

            </tbody>

        </table>

    </div>

</main>

<?php
    include '../includes/footer.php';
?>