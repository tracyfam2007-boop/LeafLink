<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';

    $search = "";
    $category = "";
    $status = "";

    if(isset($_GET['search'])){
        $search  = trim($_GET['search']);
    }

    if(isset($_GET['category'])){
        $category = trim($_GET['category']);
    }

    if(isset($_GET['status'])){
        $status = trim($_GET['status']);
    }

    $sql = 
        "SELECT
            activityId,
            activityName,
            description,
            category,
            pointsReward,
            rules,
            status
        FROM activity
        WHERE 1";

    if($search != ""){
        $sql .= "
            AND(
                activityId LIKE '%$search%'
                OR activityName LIKE '%$search%')";
    }

    if($category != ""){
        $sql .="
            AND category='$category'";
    }

    if($status != ""){
        $sql .= "
            AND status='$status'";
    }

    $sql .= "
        ORDER BY activityId ASC";

    $activityQuery = mysqli_query($conn, $sql);

?>

<main class="main-content">

    <?php if(isset($_SESSION['activitySuccess'])): ?>

        <div class="success-message">
            <?= $_SESSION['activitySuccess']; ?>
        </div>

        <?php 
            unset($_SESSION['activitySuccess']);
            endif;
        ?>

    <?php if(isset($_SESSION['activityError'])): ?>

        <div class="error-message">
            <?= $_SESSION['activityError']; ?>
        </div>

        <?php
            unset($_SESSION['activityError']);
            endif;
        ?>

    <h1 class="dashboard-title">Manage Activities</h1>

    <p class="dashboard-subtitle">
        View and manage all green activites.
    </p>

    <form class="toolbar" method="GET">

        <input
            type="text"
            name="search"
            class="search-box"
            placeholder="Search Activity ID or Activity Name..."
            value="<?= $search; ?>">

        <select name="category" class="filter-box">

            <option value="">All Categories</option>
            <option value="Recycling" <?= ($category == "Recycling") ?"selected" : ""; ?>>
                Recycling
            </option>
            <option value="Energy Saving" <?= ($category == "Energy Saving") ?"selected" : ""; ?>>
                Energy Saving
            </option>
            <option value="Transportation" <?= ($category == "Transportation") ?"selected" : ""; ?>>
                Transportation
            </option>
            <option value="Community Service" <?= ($category == "Community Service") ?"selected" : ""; ?>>
                Community Service
            </option>
            <option value="Tree Planting" <?= ($category == "Tree Planting") ?"selected" : ""; ?>>
                Tree Planting
            </option>
            <option value="Water Conservation" <?= ($category == "Water Conservation") ?"selected" : ""; ?>>
                Water Conservation
            </option>
            <option value="Others" <?= ($category == "Others") ?"selected" : ""; ?>>
                Others
            </option>
        
        </select>

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
            Add Activity
        </button>

    </form>

    <div class="table-card">

        <table class="recent-table">

            <thead>
                <tr>
                    <th>Activity ID</th>
                    <th>Activity Name</th>
                    <th>Category</th>
                    <th>Points</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    if(mysqli_num_rows($activityQuery) > 0){
                        while($row = mysqli_fetch_assoc($activityQuery)){
                ?>
                
                <tr>
                    <td><?= $row['activityId']; ?></td>
                    <td><?= $row['activityName']; ?></td>
                    <td><?= $row['category']; ?></td>
                    <td><?= $row['pointsReward']; ?></td>
                    <td>
                        <span class="status <?= strtolower($row['status']); ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <button

                            type="button" class="action-btn view-btn"
                            data-id="<?= $row['activityId']; ?>"
                            data-name="<?= $row['activityName']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-category="<?= $row['category']; ?>"
                            data-points="<?= $row['pointsReward']; ?>"
                            data-rules="<?= $row['rules']; ?>"
                            data-status="<?= $row['status']; ?>">
                            
                            <i class="fa-solid fa-eye"></i>

                        </button>

                        <button 
                        
                            type="button" class="action-btn edit-btn"
                            data-id="<?= $row['activityId']; ?>"
                            data-name="<?= $row['activityName']; ?>"
                            data-description="<?= $row['description']; ?>"
                            data-category="<?= $row['category']; ?>"
                            data-points="<?= $row['pointsReward']; ?>"
                            data-rules="<?= $row['rules']; ?>"
                            data-status="<?= $row['status']; ?>">

                            <i class="fa-solid fa-pen-to-square"></i>

                        </button>

                        <button

                            type="button" class="action-btn delete-btn"
                            data-id="<?= $row['activityId']; ?>"
                            data-name="<?= $row['activityName']; ?>">

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </td>

                </tr>

                <?php 
                        }
                    }else{
                    ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:25px;">
                        No activities found.
                    </td>
                </tr>
                
                <?php } ?>

            </tbody>

        </table>

    </div>

    <div id="viewActivityModal" class="modal">
        
        <div class="modal-content">
            
            <span class="close-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-eye"></i>
                View Activity
            </h2>

            <div class="view-details">

                <div class="detail-row">
                    <label>Activity ID</label>
                    <span id="viewActivityId"></span>
                </div>

                <div class="detail-row">
                    <label>Activity Name</label>
                    <span id="viewActivityName"></span>
                </div>

                <div class="detail-row">
                    <label>Description</label>
                    <span id="viewDescription"></span>
                </div>

                <div class="detail-row">
                    <label>Category</label>
                    <span id="viewCategory"></span>
                </div>

                <div class="detail-row">
                    <label>Points Reward</label>
                    <span id="viewPoints"></span>
                </div>

                <div class="detail-row">
                    <label>Rules</label>
                    <span id="viewRules"></span>
                </div>

                <div class="detail-row">
                    <label>Status</label>
                    <span id="viewStatus"></span>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" id="closeActivityModalBtn" class="close-btn">
                    Close
                </button>
            </div>

        </div>

    </div>

    <div id="addActivityModal" class="modal">

        <div class="modal-content">

            <span class="close-add-activity-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-plus"></i>
                Add Activity
            </h2>

            <form id="addActivityForm" action="add_activity.php" method="POST">

                <div class="form-group">
                    <label>Activity Name</label>
                    <input type="text" name="activityName" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Category</labeL>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Recycling">Recycling</option>
                        <option value="Energy Saving">Energy Saving</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Community Service">Community Service</option>
                        <option value="Tree Planting">Tree Planting</option>
                        <option value="Water Conservation">Water Conservation</option>
                        <option value="Others">Others</option>
                    </select>  
                </div>

                <div class="form-group">
                    <label>Points Reward</label>
                    <input type="number" name="pointsReward" min="1" required>
                </div>

                <div class="form-group">
                    <label>Rules</label>
                    <textarea name="rules" rows="4" required></textarea>
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
                        Save Activity
                    </button>

                    <button type="button" id="cancelAddActivity" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div id="editActivityModal" class="modal">

        <div class="modal-content">

            <span class="close-edit-activity-modal">&times;</span>

            <h2 class="modal-title">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Activity
            </h2>

            <form id="editActivityForm" action="edit_activity.php" method="POST">

                <input type="hidden" name="activityId" id="editActivityId">

                <div class="form-group">
                    <label>Activity ID</label>
                    <input type="text" id="editActivityIdDisplay" readonly>
                </div>

                <div class="form-group">
                    <label>Activity Name</label>
                    <input type="text" name="activityName" id="editActivityName" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="editDescription" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" id="editCategory" required>
                        <option value="Recycling">Recycling</option>
                        <option value="Energy Saving">Energy Saving</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Community Service">Community Service</option>
                        <option value="Tree Planting">Tree Planting</option>
                        <option value="Water Conservation">Water Conservation</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Points Reward</label>
                    <input type="number" name="pointsReward" id="editPoints" min="1" required>
                </div>

                <div class="form-group">
                    <label>Rules</label>
                    <textarea name="rules" id="editRules" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update Activity
                    </button>
                
                    <button type="button" id="cancelEditActivity" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

    <div id="deleteActivityModal" class="modal">

        <div class="modal-content delete-modal">

            <span class="close-delete-activity-modal">&times;</span>

            <h2 class="modal-title delete-title">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Delete Activity
            </h2>

            <p class="delete-text">
                Do you want to delete this activity? This action cannot be undone.
            </p>

            <div class="detail-row">
                <strong>Activity ID</strong>
                <span id="deleteActivityId"></span>
            </div>

            <div class="detail-row">
                <strong>Activity Name</strong>
                <span id="deleteActivityName"></span>
            </div>

            <form action="delete_activity.php" method="POST">

                <input type="hidden" id="deleteActivityIdHidden" name="activityId">

                <div class="modal-buttons">
                    <button type="submit" class="delete-confirm-btn">
                        <i class="fa-solid fa-trash"></i>
                        Delete Activity
                    </button>

                    <button type="button" id="cancelDeleteActivity" class="cancel-btn">
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