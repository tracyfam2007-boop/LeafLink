<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';

    $search = "";

    if(isset($_GET['search'])){
        $search  = trim($_GET['search']);
    }

    $sql =
        "SELECT
            badgeId,
            badgeName,
            description,
            requiredPoints
        FROM badge
        WHERE 1";

    if($search != ""){

        $sql .= "
            AND(
                badgeId LIKE '%$search%'
                OR badgeName LIKE '%$search%')";

    }

    $sql .= "
        ORDER BY badgeId ASC";

    $badgeQuery = mysqli_query($conn, $sql);

?>

<main class="main-content">

    <?php if(isset($_SESSION['badgeSuccess'])): ?>

        <div class="success-message">
            <?= $_SESSION['badgeSuccess']; ?>
        </div>

        <?php 
            unset($_SESSION['badgeSuccess']);
            endif;
        ?>

    <?php if(isset($_SESSION['badgeError'])): ?>

        <div class="error-message">
            <?= $_SESSION['badgeError']; ?>
        </div>

        <?php
            unset($_SESSION['badgeError']);
            endif;
        ?>

    <h1 class="dashboard-title">Manage Badges</h1>

    <p class="dashboard-subtitle">
        View and manage all badges.
    </p>

    <form class="toolbar" method="GET">

        <input
            type="text"
            name="search"
            class="search-box"
            placeholder="Search Badge ID or Badge Name..."
            value="<?= $search; ?>">

        <button type="submit" class="filter-btn">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>

        <button type="button" class="add-btn">
            <i class="fa-solid fa-plus"></i>
            Add Badge
        </button>

    </form>

    <div class="table-card">

        <table class="recent-table">

            <thead>
                <tr>
                    <th>Badge ID</th>
                    <th>Badge Name</th>
                    <th>Description</th>
                    <th>Required Points</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    if(mysqli_num_rows($badgeQuery) > 0){
                        while($row = mysqli_fetch_assoc($badgeQuery)){
                ?>
                
                <tr>
                    <td><?= $row['badgeId']; ?></td>   
                    <td><?= $row['badgeName']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['requiredPoints']; ?></td>
                    <td>
                        <button
                            type="button" class="action-btn view-btn"
                            data-id="<?= $row['badgeId']; ?>"
                            data-name="<?= $row['badgeName']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-points="<?= $row['requiredPoints']; ?>">

                            <i class="fa-solid fa-eye"></i>

                        </button>

                        <button
                            type="button" class="action-btn edit-btn"
                            data-id="<?= $row['badgeId']; ?>"
                            data-name="<?= $row['badgeName']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-points="<?= $row['requiredPoints']; ?>">

                            <i class="fa-solid fa-pen-to-square"></i>

                        </button>

                        <button
                            type="button" class="action-btn delete-btn"
                            data-id="<?= $row['badgeId']; ?>"
                            data-name="<?= $row['badgeName']; ?>">

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </td>

                </tr>

                <?php 
                        }
                    }else{
                    ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding:25px;">
                        No badges found.
                    </td>
                </tr>
                
                <?php } ?>

            </tbody>

        </table>

    </div>

    <div id="viewBadgeModal" class="modal">
        
        <div class="modal-content">
            
            <span class="close-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-eye"></i>
                View Badge
            </h2>

            <div class="view-details">

                <div class="detail-row">
                    <label>Badge ID</label>
                    <span id="viewBadgeId"></span>
                </div>

                <div class="detail-row">
                    <label>Badge Name</label>
                    <span id="viewBadgeName"></span>
                </div>

                <div class="detail-row">
                    <label>Description</label>
                    <span id="viewDescription"></span>
                </div>

                <div class="detail-row">
                    <label>Required Points</label>
                    <span id="viewRequiredPoints"></span>
                </div>

                </div>

                <div class="modal-footer">
                    <button type="button" id="closeBadgeModalBtn" class="close-btn">
                        Close
                    </button>
                </div>

            </div>

        </div>

    <div id="addBadgeModal" class="modal">

        <div class="modal-content">

            <span class="close-add-badge-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-plus"></i>
                Add Badge
            </h2>

            <form id="addBadgeForm" action="add_badge.php" method="POST">

                <div class="form-group">
                    <label>Badge Name</label>
                    <input type="text" name="badgeName" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Required Points</label>
                    <input type="number" name="requiredPoints" min="1" required>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Badge
                    </button>

                    <button type="button" id="cancelAddBadge" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div id="editBadgeModal" class="modal">

        <div class="modal-content">

            <span class="close-edit-badge-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Badge
            </h2>

            <form id="editBadgeForm" action="edit_badge.php" method="POST">

                <input type="hidden" name="badgeId" id="editBadgeId">

                <div class="form-group">
                    <label>Badge ID</label>
                    <input type="text" id="editBadgeIdDisplay" readonly>
                </div>

                <div class="form-group">
                    <label>Badge Name</label>
                    <input type="text" name="badgeName" id="editBadgeName" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="editDescription" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Required Points</label>
                    <input type="number" name="requiredPoints" id="editRequiredPoints" min="1" required>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update Badge
                    </button>
                
                    <button type="button" id="cancelEditBadge" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div id="deleteBadgeModal" class="modal">

        <div class="modal-content delete-modal">

            <span class="close-delete-badge-modal">&times;</span>

            <h2 class="modal-title delete-title">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Delete Badge
            </h2>

            <p class="delete-text">
                Do you want to delete this badge? This action cannot be undone.
            </p>

            <div class="detail-row">
                <strong>Badge ID</strong>
                <span id="deleteBadgeId"></span>
            </div>

            <div class="detail-row">
                <strong>Badge Name</strong>
                <span id="deleteBadgeName"></span>
            </div>

            <form action="delete_badge.php" method="POST">

                <input type="hidden" id="deleteBadgeIdHidden" name="badgeId">

                <div class="modal-buttons">
                    <button type="submit" class="delete-confirm-btn">
                        <i class="fa-solid fa-trash"></i>
                        Delete Badge
                    </button>

                    <button type="button" id="cancelDeleteBadge" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

</main>

<?php
    include'../includes/footer.php';
?>