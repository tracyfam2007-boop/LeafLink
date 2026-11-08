<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';

    $search = "";
    $status = "";

    if(isset($_GET['search'])){
        $search = trim($_GET['search']);
    }

    if(isset($_GET['status'])){
        $status = trim($_GET['status']);
    }

    $sql = 
        "SELECT 
            challengeId,
            challengeName,
            startDate,
            endDate,
            status,
            challengePoint
        FROM teamchallenge
        WHERE 1";

    if($search !=""){
        $sql .= " 
            AND(
                challengeId LIKE '%$search%'
                OR challengeName LIKE '%$search%')";
    }

    if($status != ""){
        $sql .= " 
            AND status='$status'";
    }

    $sql .= " 
        ORDER BY challengeId ASC";

    $challengeQuery = mysqli_query($conn, $sql);

?>

<main class="main-content">

    <?php if(isset($_SESSION['challengeSuccess'])): ?>

        <div class="success-message">
            <?= $_SESSION['challengeSuccess']; ?>
        </div>

        <?php 
            unset($_SESSION['challengeSuccess']); 
            endif;
        ?>

    <?php if(isset($_SESSION['challengeError'])): ?>

        <div class="error-message">
            <?= $_SESSION['challengeError']; ?>
        </div>

        <?php 
            unset($_SESSION['challengeError']); 
            endif;
        ?>

    <h1 class="dashboard-title">Manage Team Challenges</h1>

    <p class="dashboard-subtitle">
        View and manage all team challenges.
    </p>

    <form class="toolbar" method="GET">

        <input 
            type="text"
            name="search"
            class="search-box"
            placeholder="Search Challenge ID or Challenge Name..."
            value="<?= $search; ?>">

        <select name="status" class="filter-box">
            <option value="">All Status</option>
            <option value="Active" <?= ($status == "Active") ?"selected" : ""; ?>>
                Active
            </option>
            <option value="Inactive" <?= ($status == "Inactive") ?"selected" : ""; ?>>
                Inactive
            </option>
        </select>

        <button type="submit" class="filter-btn">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>

        <button type="button" class="add-btn">
            <i class="fa-solid fa-plus"></i>
            Add Challenge
        </button>

    </form>

    <div class="table-card">

        <table class="recent-table">

            <thead>
                <tr>
                    <th>Challenge ID</th>
                    <th>Challenge Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Points</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php 
                    if(mysqli_num_rows($challengeQuery) > 0){
                        while($row = mysqli_fetch_assoc($challengeQuery)){
                    ?>
                    
                    <tr>
                        <td><?= $row['challengeId']; ?></td>
                        <td><?= $row['challengeName']; ?></td>
                        <td><?= $row['startDate']; ?></td>
                        <td><?= $row['endDate']; ?></td>
                        <td><?= $row['challengePoint']; ?></td>
                        <td>
                            <span class="status <?= strtolower($row['status']); ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <button 

                                type="button" class="action-btn view-btn"
                                data-id="<?= $row['challengeId']; ?>"
                                data-name="<?= $row['challengeName']; ?>"
                                data-start="<?= $row['startDate']; ?>"
                                data-end="<?= $row['endDate']; ?>"
                                data-points="<?= $row['challengePoint']; ?>"
                                data-status="<?= $row['status']; ?>">

                                <i class="fa-solid fa-eye"></i>

                            </button>

                            <button

                                type="button" class="action-btn edit-btn"
                                data-id="<?= $row['challengeId']; ?>"
                                data-name="<?= $row['challengeName']; ?>"
                                data-start="<?= $row['startDate']; ?>"
                                data-end="<?= $row['endDate']; ?>"
                                data-points="<?= $row['challengePoint']; ?>"
                                data-status="<?= $row['status']; ?>">

                                <i class="fa-solid fa-pen-to-square"></i>

                            </button>

                            <button

                                type="button" class="action-btn delete-btn"
                                data-id="<?= $row['challengeId']; ?>"
                                data-name="<?= $row['challengeName']; ?>">

                                <i class="fa-solid fa-trash"></i>

                            </button>
                        
                        </td>

                    </tr>

                <?php 
                    }
                }else{
                ?>

                <tr>
                    <td colspan="7" style="text-align:center; padding:25px;">
                        No team challenges found.
                    </td>
                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <div id="viewChallengeModal" class="modal">

        <div class="modal-content">
        
            <span class="close-view-challenge-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-eye"></i>
                View Team Challenge
            </h2>

            <div class="view-details">

                <div class="detail-row">
                    <label>Challenge ID</label>
                    <span id="viewChallengeId"></span>
                </div>

                <div class="detail-row">
                    <label>Challenge Name</label>
                    <span id="viewChallengeName"></span>
                </div>

                <div class="detail-row">
                    <label>Start Date</label>
                    <span id="viewChallengeStart"></span>
                </div>

                <div class="detail-row">
                    <label>End Date</label>
                    <span id="viewChallengeEnd"></span>
                </div>

                <div class="detail-row">
                    <label>Challenge Points</label>
                    <span id="viewChallengePoints"></span>
                </div>

                <div class="detail-row">
                    <label>Status</label>
                    <span id="viewChallengeStatus"></span>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" id="closeViewChallengeBtn" class="close-btn">
                    Close
                </button>
            </div>

        </div>

    </div>

    <div id="addChallengeModal" class="modal">

        <div class="modal-content">

            <span class="close-add-challenge-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-trophy"></i>
                Add Team Challenge
            </h2>

            <form method="POST" action="add_teamchallenge.php" id="addChallengeForm">

                <div class="form-group">
                    <label>Challenge Name</label>
                    <input type="text" name="challengeName" id="challengeName" required>
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="startDate" id="startDate" required>
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="endDate" id="endDate" required>
                </div>

                <div class="form-group">
                    <label>Challenge Points</label>
                    <input type="number" name="challengePoint" id="challengePoint" min="0" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="challengeStatus" required>
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Challenge
                    </button>

                    <button type="button" id="cancelAddChallenge" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>
 
    <div id="editChallengeModal" class="modal">

        <div class="modal-content">

            <span class="close-edit-challenge-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Team Challenge
            </h2>

            <form id="editChallengeForm" action="edit_teamchallenge.php" method="POST">

                <input type="hidden" name="challengeId" id="editChallengeId">

                <div class="form-group">
                    <label>Challenge ID</label>
                    <input type="text" id="editChallengeIdDisplay" readonly>
                </div>

                <div class="form-group">
                    <label>Challenge Name</label>
                    <input type="text" name="challengeName" id="editChallengeName" required>
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="startDate" id="editStartDate" required>
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="endDate" id="editEndDate" required>
                </div>

                <div class="form-group">
                    <label>Challenge Points</label>
                    <input type="number" name="challengePoint" id="editChallengePoint" min="1" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editChallengeStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update Challenge
                    </button>

                    <button type="button" id="cancelEditChallenge" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>
        
        </div>

    </div>

    <div id="deleteChallengeModal" class="modal">

        <div class="modal-content delete-modal">

            <span class="close-delete-challenge-modal">&times;</span>

            <h2 class="modal-title delete-title">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Delete Team Challenge
            </h2>

            <p class="delete-text">
                Do you want to delete this team challenge? This action cannot be undone.
            </p>

            <div class="detail-row">
                <strong>Challenge ID</strong>
                <span id="deleteChallengeId"></span>
            </div>

            <div class="detail-row">
                <strong>Challenge Name</strong>
                <span id="deleteChallengeName"></span>
            </div>

            <form action="delete_teamchallenge.php" method="POST">
                
                <input type="hidden" name="challengeId" id="deleteChallengeIdHidden">

                <div class="modal-buttons">
                    <button type="submit" class="delete-confirm-btn">
                        <i class="fa-solid fa-trash"></i>
                        Delete Challenge
                    </button>

                    <button type="button" id="cancelDeleteChallenge" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

</main>

<?php
    include '../includes/footer.php';
?>
    