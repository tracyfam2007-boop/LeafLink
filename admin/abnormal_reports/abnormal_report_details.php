<?php
    session_start();

    include '../../database/db_connect.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $abnormalId = trim($_POST['abnormalId']);
        $remark = trim($_POST['remark']);

        if($remark == ""){
            $_SESSION['reportError'] = "Please enter a remark.";
            header("Location: abnormal_report_details.php?abnormalId=$abnormalId");
            exit();
        }

        $update = mysqli_query($conn,
            "UPDATE abnormalreport
            SET
                remark = '$remark'
            WHERE abnormalId = '$abnormalId'");

        if($update){
            $_SESSION['reportSuccess'] = "Remark sent successfully.";
        }else{
            $_SESSION['reportError'] = "Failed to send remark.";
        }

        header("Location: manage_abnormalreport.php");
        exit();
    }

    if(!isset($_GET['abnormalId'])){
        header("Location: manage_abnormalreport.php");
        exit();
    }

    $abnormalId = $_GET['abnormalId'];

    $sql =
        "SELECT
            ar.abnormalId,
            ar.submissionId,
            ar.moderatorId,
            ar.reason,
            ar.reportDate,
            ar.remark,
            
            moderator.fullName AS moderatorName,
            
            ass.participantId,
            ass.activityId,
            ass.evidencePhoto,
            ass.description AS submissionDescription,
            ass.status AS submissionStatus,
            ass.submissionDate,
            ass.submissionTime,
            
            p.participantType,
            p.faculty,
            p.pointBalance,
            
            participantUser.fullName AS participantName,
            
            a.activityName

        FROM abnormalreport ar
        
        LEFT JOIN user moderator
        ON ar.moderatorId = moderator.userId
        
        LEFT JOIN activitysubmission ass
        ON ar.submissionId = ass.submissionId
        
        LEFT JOIN participant p
        ON ass.participantId = p.participantId
        
        LEFT JOIN user participantUser
        ON p.userId = participantUser.userId
        
        LEFT JOIN activity a
        ON ass.activityId = a.activityId
        
        WHERE ar.abnormalId = '$abnormalId'";

    $reportQuery = mysqli_query($conn, $sql);

    if(!$reportQuery || mysqli_num_rows($reportQuery) ==0){
        $_SESSION['reportError'] = "Abnormal report not found.";
        header("Location: manage_abnormalreport.php");
        exit();
    }

    $report = mysqli_fetch_assoc($reportQuery);
    $remark = trim($report['remark'] ?? '');

    include '../includes/header.php';
    include '../includes/sidebar.php';

?>

<main class="main-content">

    <h1 class="dashboard-title">Abnormal Report Details</h1>

    <p class="dashboard-subtitle">
        View abnormal activity report details and provide a remark to the moderator.
    </p>

    <div class="details-card">

        <h3>
            Reported By <?= $report['moderatorName'] ?? 'N/A'; ?> Moderator
        </h3>

        <div class="details-grid">

            <div class="detail-item">
                <label>Moderator ID</label>
                <span>
                    <?= $report['moderatorId']; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Moderator Name</label>
                <span>
                    <?= $report['moderatorName'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Report Date</label>
                <span>
                    <?= $report['reportDate']; ?>
                </span>
            </div>

        </div>

    </div>

    <div class="details-card">

        <h3>Reported Activity Information</h3>

        <div class="details-grid">

            <div class="detail-item">
                <label>Participant ID</label>
                <span>
                    <?= $report['participantId'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Submission ID</label>
                <span>
                    <?= $report['submissionId']; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Activity ID</label>
                <span>
                    <?= $report['activityId'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Activity Name</label>
                <span>
                    <?= $report['activityName'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Participant Name</label>
                <span>
                    <?= $report['participantName'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Submission Date</label>
                <span>
                    <?= $report['submissionDate'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Submission Time</label>
                <span>
                    <?= $report['submissionTime'] ?? 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <label>Status</label>
                <span>
                    <?= $report['submissionStatus'] ?? 'N/A'; ?>
                </span>
            </div>

        </div>

        <div class="detail-item">
            <label>Description</label>
            <p>
                <?= $report['submissionDescription']; ?>
            </p>
        </div>

        <div class="detail-item">
            <label>Evidence Photo</label>

            <img
                src="../../uploads/evidence/<?= $report['evidencePhoto']; ?>"
                alt="Evidence Photo"
                class="evidence-image">
        </div>

    </div>

    <div class="details-card">

        <h3>Reason for Report</h3>

        <div class="reason-box">
            <?= $report['reason']; ?>
        </div>

    </div>

    <div class="details-card">

        <h3>Actions</h3>

        <form method="POST">

            <input
                type="hidden"
                name="abnormalId"
                value="<?= $report['abnormalId']; ?>">

            <div class="form-group">
                <label>Remark</label>
                <textarea
                    name="remark"
                    rows="5"
                    placeholder="Enter your remark for the moderator..."
                    required><?= $remark; ?></textarea>
            </div>

            <div class="modal-buttons">
                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send
                </button>

                <a
                    href="manage_abnormalreport.php"
                    class="cancel-btn">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</main>

<?php
    include '../includes/footer.php';
?>