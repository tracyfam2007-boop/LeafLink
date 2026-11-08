<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';

    $search = "";
    $status = "";

    if(isset($_GET['search'])){
        $search  = trim($_GET['search']);
    }

    if(isset($_GET['status'])){
        $status = trim($_GET['status']);
    }

    $sql =
        "SELECT
            rewardId,
            rewardName,
            description,
            image,
            pointRequired,
            stock,
            status
        FROM reward
        WHERE 1";

    if($search != ""){
        $sql .= "
            AND(
                rewardId LIKE '%$search%'
                OR rewardName LIKE '%$search%')";
    }

    if($status != ""){
        $sql .= "
            AND status='$status'";
    }

    $sql .= "
        ORDER BY rewardId ASC";

    $rewardQuery = mysqli_query($conn, $sql);

?>

<main class="main-content">

    <?php if(isset($_SESSION['rewardSuccess'])): ?>

        <div class="success-message">
            <?= $_SESSION['rewardSuccess']; ?>
        </div>

        <?php 
            unset($_SESSION['rewardSuccess']);
            endif;
        ?>

    <?php if(isset($_SESSION['rewardError'])): ?>

        <div class="error-message">
            <?= $_SESSION['rewardError']; ?>
        </div>

        <?php
            unset($_SESSION['rewardError']);
            endif;
        ?>

    <h1 class="dashboard-title">Manage Rewards</h1>

    <p class="dashboard-subtitle">
        View and manage all rewards.
    </p>

    <form class="toolbar" method="GET">

        <input
            type="text"
            name="search"
            class="search-box"
            placeholder="Search Reward ID or Reward Name..."
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
            Add Reward
        </button>

    </form>

    <div class="table-card">

        <table class="recent-table">

            <thead>
                <tr>
                    <th>Reward ID</th>
                    <th>Reward Name</th>
                    <th>Image</th>
                    <th>Points</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    if(mysqli_num_rows($rewardQuery) > 0){
                        while($row = mysqli_fetch_assoc($rewardQuery)){
                ?>

                <tr>
                    <td><?= $row['rewardId']; ?></td>
                    <td><?= $row['rewardName']; ?></td>
                    <td>
                        <?php if(!empty($row['image'])): ?>
                            <img
                                src="../../uploads/rewards/<?= $row['image']; ?>"
                                alt="<?= $row['rewardName']; ?>"
                                class="reward-image">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= $row['pointRequired']; ?></td>
                    <td><?= $row['stock']; ?></td>
                    <td>
                        <span class="status <?= strtolower($row['status']); ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <button
                            
                            type="button" class="action-btn view-btn"
                            data-id="<?= $row['rewardId']; ?>"
                            data-name="<?= $row['rewardName']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-image="<?= $row['image']; ?>"
                            data-points="<?= $row['pointRequired']; ?>"
                            data-stock="<?= $row['stock']; ?>"
                            data-status="<?= $row['status']; ?>">

                            <i class="fa-solid fa-eye"></i>

                        </button>

                        <button

                            type="button" class="action-btn edit-btn"
                            data-id="<?= $row['rewardId']; ?>"
                            data-name="<?= $row['rewardName']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-image="<?= $row['image']; ?>"
                            data-points="<?= $row['pointRequired']; ?>"
                            data-stock="<?= $row['stock']; ?>"
                            data-status="<?= $row['status']; ?>">

                            <i class="fa-solid fa-pen-to-square"></i>

                        </button>

                        <button

                            type="button" class="action-btn delete-btn"
                            data-id="<?= $row['rewardId']; ?>"
                            data-name="<?= $row['rewardName']; ?>">

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
                        No rewards found.
                    </td>
                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <div id="viewRewardModal" class="modal">

        <div class="modal-content">

            <span class="close-view-reward-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-eye"></i>
                View Reward
            </h2>

            <div class="view-details">

                <div class="detail-row">
                    <label>Reward ID</label>
                    <span id="viewRewardId"></span>
                </div>

                <div class="detail-row">
                    <label>Reward Name</label>
                    <span id="viewRewardName"></span>
                </div>

                <div class="detail-row">
                    <label>Description</label>
                    <span id="viewRewardDescription"></span>
                </div>

                <div class="detail-row">
                    <labeL>Reward Image</label>
                    <span>
                        <img
                            id="viewRewardImage"
                            class="reward-view-image"
                            src=""
                            alt="Reward Image">
                    </span>
                </div>

                <div class="detail-row">
                    <label>Points Required</label>
                    <span id="viewRewardPoints"></span>
                </div>

                <div class="detail-row">
                    <label>Stock</label>
                    <span id="viewRewardStock"></span>
                </div>

                <div class="detail-row">
                    <label>Status</label>
                    <span id="viewRewardStatus"></span>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" id="closeViewRewardBtn" class="close-btn">
                    Close
                </button>
            </div>

        </div>

    </div>

    <div id="addRewardModal" class="modal">

        <div class="modal-content">

            <span class="close-add-reward-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-plus"></i>
                Add Reward
            </h2>

            <form id="addRewardForm" action="add_reward.php" method="POST">

                <div class="form-group">
                    <label>Reward Name</label>
                    <input type="text" name="rewardName" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Reward Image</label>
                    <input type="file" name="image" id="rewardImage" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label>Points Required</label>
                    <input type="number" name="pointRequired" min="1" required>
                </div>

                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" min="0" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Reward
                    </button>

                    <button type="button" id="cancelAddReward" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div id="editRewardModal" class="modal">

        <div class="modal-content">

            <span class="close-edit-reward-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Reward
            </h2>

            <form id="editRewardForm" action="edit_reward.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="rewardId" id="editRewardId">

                <div class="form-group">
                    <label>Reward ID</label>
                    <input type="text" id="editRewardIdDisplay" readonly>
                </div>

                <div class="form-group">
                    <label>Reward Name</label>
                    <input type="text" name="rewardName" id="editRewardName" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="editDescription" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Reward Image</label>
                    <input type="file" name="image" id="editRewardImage" accept="image/*">
                    <small>
                        Leave empty to keep the current image.
                    </small>
                    <div>
                        <img
                            id="editRewardImagePreview"
                            class="reward-view-image"
                            src=""
                            alt="Current Reward Image">
                    </div>
                </div>

                <div class="form-group">
                    <label>Points Required</label>
                    <input type="number" name="pointRequired" id="editRewardPoints" min="1" required>
                </div>

                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" id="editRewardStock" min="0" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editRewardStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update Reward
                    </button>
                
                    <button type="button" id="cancelEditReward" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div id="deleteRewardModal" class="modal">

        <div class="modal-content delete-modal">

            <span class="close-delete-reward-modal">&times;</span>

            <h2 class="modal-title delete-title">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Delete Reward
            </h2>

            <p class="delete-text">
                Do you want to delete this reward? This action cannot be undone.
            </p>

            <div class="detail-row">
                <strong>Reward ID</strong>
                <span id="deleteRewardId"></span>
            </div>

            <div class="detail-row">
                <strong>Reward Name</strong>
                <span id="deleteRewardName"></span>
            </div>

            <form action="delete_reward.php" method="POST">

                <input type="hidden" id="deleteRewardIdHidden" name="rewardId">

                <div class="modal-buttons">
                    <button type="submit" class="delete-confirm-btn">
                        <i class="fa-solid fa-trash"></i>
                        Delete Reward
                    </button>

                    <button type="button" id="cancelDeleteReward" class="cancel-btn">
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