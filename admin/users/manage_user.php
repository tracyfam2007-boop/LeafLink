<?php
    session_start();

    include '../includes/header.php';
    include '../includes/sidebar.php';

    $search = "";
    $role = "";

    if(isset($_GET['search'])){
        $search = trim($_GET['search']);
    }

    if(isset($_GET['role'])){
        $role = trim($_GET['role']);
    }

    $sql = "
        SELECT
            user.userId,
            user.fullName,
            user.emailAddress,
            user.phoneNumber,
            user.dateOfBirth,
            role.roleName,
            participant.participantId,
            participant.participantType,
            participant.faculty,
            participant.pointBalance
            
        FROM user
        
        INNER JOIN role
        ON user.roleId = role.roleId

        LEFT JOIN participant
        ON user.userId = participant.userId
        
        WHERE 1";

    if($search != ""){
        $sql .="
            AND(
                user.userId LIKE '%$search%'
                OR user.fullName LIKE '%$search%'
                OR user.emailAddress LIKE '%$search%'
            )";
    }

    if($role != ""){
        $sql .="
            AND role.roleName = '$role'";
    }

    $sql .="
        ORDER BY user.userId ASC";

    $userQuery = mysqli_query($conn, $sql);

    if (!$userQuery) {
        die(mysqli_error($conn));
    }
?>

<main class="main-content">

    <?php if(isset($_SESSION['successMessage'])): ?>

        <div class="success-message">
            <?= $_SESSION['successMessage']; ?>
        </div>

        <?php
            unset($_SESSION['successMessage']);
            endif;
        ?>

    <?php if(isset($_SESSION['deleteUserError'])): ?>

        <div class="error-message">
            <?= $_SESSION['deleteUserError']; ?>
        </div>

        <?php unset($_SESSION['deleteUserError']); ?>

    <?php endif; ?>

    <h1 class="dashboard-title">Manage Users</h1>

    <p class="dashboard-subtitle">
        View and manage all system user.
    </p>

    <form class="toolbar" method="GET">

        <input
            type="text"
            name="search"
            class="search-box"
            placeholder="Search by User ID, Name or Email..."
            value="<?= $search; ?>">

        <select name="role" class="filter-box">

            <option value="">All Roles</option>
            <option value="Administrator" <?= ($role == "Administrator") ? "selected" : ""; ?>>
                Administrator
            </option>
            <option value="Moderator" <?= ($role == "Moderator") ? "selected" : ""; ?>>
                Moderator
            </option>
            <option value="Participant" <?= ($role == "Participant") ? "selected" : ""; ?>>
                Participant
            </option>

        </select>

        <button class="filter-btn" type="submit">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>

        <button class="add-btn" type="button">
            <i class="fa-solid fa-plus"></i>
            Add User
        </button>

    </form>

    <div class="table-card">

        <table class="recent-table">

            <thead>

                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                <?php
                    if(mysqli_num_rows($userQuery) > 0){
                        while($row = mysqli_fetch_assoc($userQuery)){
                ?>
                
                <tr>
                    <td><?= $row['userId'] ?></td>
                    <td><?= $row['fullName'] ?></td>
                    <td><?= $row['emailAddress'] ?></td>
                    <td><?= $row['roleName'] ?></td>
                    <td>
                        <button

                            type="button" class="action-btn view-btn"
                            data-id="<?= $row['userId'] ?>"
                            data-name="<?= $row['fullName'] ?>"
                            data-email="<?= $row['emailAddress'] ?>"
                            data-role="<?= $row['roleName'] ?>"
                            data-phone="<?= $row['phoneNumber'] ?>"
                            data-dob="<?= $row['dateOfBirth'] ?>"

                            data-participant="<?= $row['participantId'] ?>"
                            data-type="<?= $row['participantType'] ?>"
                            data-faculty="<?= $row['faculty'] ?>"
                            data-points="<?= $row['pointBalance'] ?>">
                            
                            <i class="fa-solid fa-eye"></i>

                        </button>

                    
                        <?php if($row['roleName'] != "Participant"){ ?>
                            
                            <button 

                                type="button" class="action-btn edit-btn"
                                data-id="<?= $row['userId'] ?>"
                                data-name="<?= $row['fullName'] ?>"
                                data-email="<?= $row['emailAddress'] ?>"
                                data-phone="<?= $row['phoneNumber'] ?>"
                                data-dob="<?= $row['dateOfBirth'] ?>"
                                data-role="<?= $row['roleName'] ?>">

                                <i class="fa-solid fa-pen-to-square"></i>

                            </button>
                        
                            <button 

                                type="button" class="action-btn delete-btn"
                                data-id="<?= $row['userId'] ?>"
                                data-name="<?= $row['fullName'] ?>"
                                data-role="<?= $row['roleName'] ?>">

                                <i class="fa-solid fa-trash"></i>
                            </button>
                        
                        <?php } ?>
                    
                    </td>
                
                </tr>
            
                <?php }
                    }else{
                ?>

                    <tr>
                        <td colspan="5" style="text-align:center; padding:25px;">
                            No users found.
                        </td>
                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <div id="viewModal" class="modal">

        <div class="modal-content">

            <span class="close-modal">&times;</span>

            <h2>
                <i class="fa-solid fa-user"></i>
                User Details
            </h2>

            <div class="detail-row">
                <strong>User ID</strong>
                <span id="viewUserId"></span>
            </div>

            <div class="detail-row">
                <strong>Full Name</strong>
                <span id="viewFullName"></span>
            </div>

            <div class="detail-row">
                <strong>Email</strong>
                <span id="viewEmail"></span>
            </div>

            <div class="detail-row">
                <strong>Role</strong>
                <span id="viewRole"></span>
            </div>

            <div class="detail-row">
                <strong>Phone Number</strong>
                <span id="viewPhone"></span>
            </div>

            <div class="detail-row">
                <strong>Date of Birth</strong>
                <span id="viewDob"></span>
            </div>

            <div id="participantIdRow" class="detail-row participant-info">
                <strong>Participant ID</strong>
                <span id="viewParticipantId"></span>
            </div>

            <div id="participantTypeRow" class="detail-row participant-info">
                <strong>Participant Type</strong>
                <span id="viewParticipantType"></span>
            </div>

            <div id="facultyRow" class="detail-row participant-info">
                <strong>Faculty</strong>
                <span id="viewFaculty"></span>
            </div>

            <div id="pointRow" class="detail-row participant-info">
                <strong>Point Balance</strong>
                <span id="viewPointBalance"></span>
            </div>

            <button type="button" id="closeModalBtn" class="close-btn">Close</button>

        </div>

    </div>

    <div id="editUserModal" class="modal">

        <div class="modal-content">

            <span class="close-edit-modal">&times;</span>

            <h2>
                <i class="fa-solid fa-user-pen"></i>
                Edit User
            </h2>

            <?php if(isset($_SESSION['editUserError'])): ?>

                <div class="error-message">
                    <?= $_SESSION['editUserError']; ?>
                </div>

            <?php endif; ?>

            <form id="editUserForm" action="edit_user.php" method="POST">

                <input type="hidden" id="editUserId" name="userId">

                <div class="form-group">
                    <label>User ID</label>
                    <input type="text" id="editUserIdDisplay" readonly>
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="editFullName" name="fullName" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="editEmail" name="emailAddress" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" id="editPhone" name="phoneNumber" required>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" id="editDob" name="dateOfBirth" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <input type="text" id="editRole" readonly>
                </div>

                <div class="modal-buttons">

                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update User
                    </button>

                    <button type="button" id="cancelEditUser" class="cancel-btn">
                        Cancel
                    </button>

                </div>

            </form>

        </div>

    </div>

    <div id="deleteUserModal" class="modal">

        <div class="modal-content delete-modal">

            <span class="close-delete-modal">&times;</span>

            <h2>
                <i class="fa-solid fa-triangle-exclamation"></i>
                Confirm Delete
            </h2>

            <p class="delete-text">
                Do you want to delete this user? This action cannot be undone.
            </p>

            <div class="detail-row">
                <strong>User ID</strong>
                <span id="deleteUserId"></span>
            </div>

            <div class="detail-row">
                <strong>Full Name</strong>
                <span id="deleteFullName"></span>
            </div>

            <div class="detail-row">
                <strong>Role</strong>
                <span id="deleteRole"></span>
            </div>

            <form action="delete_user.php" method="POST">

                <input type="hidden" id="deleteUserIdHidden" name="userId">

                <div class="modal-buttons">

                    <button type="submit" class="delete-confirm-btn">
                        <i class="fa-solid fa-trash"></i>
                        Delete User
                    </button>

                    <button type="button" id="cancelDeleteUser" class="cancel-btn">
                        Cancel
                    </button>

                </div>

            </form>

        </div>

    </div>

    <div id="addUserModal" class="modal">

        <div class="modal-content">

            <span class="close-add-modal">&times;</span>

            <h2>
                <i class="fa-solid fa-user-plus"></i>
                Add User
            </h2>

            <?php if(isset($_SESSION['addUserError'])): ?>

                <div class="error-message">
                    <?= $_SESSION['addUserError']; ?>
                </div>
                
                <?php endif; ?>

            <form id="addUserForm" action="add_user.php" method="POST">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="fullName" name="fullName" required >
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="emailAddress" name="emailAddress" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" required>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select id="roleSelect" name="role" required>
                        <option value="" selected disabled>-- Select Role --</option>
                        <option value="Administrator">Administrator</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Participant">Participant</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" required>
                </div>      
                
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>

                <div id="participantSection">

                    <hr>

                    <h3>Participant Information</h3>

                    <div class="form-group">
                        <label>Faculty</label>
                        <select id="faculty" name="faculty">
                            <option value="" selected disabled>-- Select Faculty --</option>
                            <option value="School of Computing">School of Computing</option>
                            <option value="School of Engineering">School of Engineering</option>
                            <option value="School of Technology">School of Technology</option>
                            <option value="School of Business">School of Business</option>
                            <option value="School of Accounting">School of Accounting</option>
                            <option value="School of Design">School of Design</option>
                            <option value="School of Media">School of Media</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Participant Type</label>
                        <select id="participantType" name="participantType">
                            <option value="" selected disabled>-- Select Participant Type --</option>
                            <option value="Student">Student</option>
                            <option value="Lecturer">Lecturer</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>

                </div>

                <div class="modal-buttons">
                    <button type="submit" class="save-btn" name="addUser">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save User
                    </button>

                    <button type="button" id="cancelAddUser" class="cancel-btn">
                        Cancel
                    </button>
                </div>

            </form>

        </div>

    </div>

</main>

<?php if(isset($_SESSION['addUserError'])){ ?>
    <script>
        window.onload = function(){
            document.getElementById("addUserModal").classList.add("show");
        };
    </script>

    <?php 
        unset($_SESSION['addUserError']);
        } 
    ?>

<?php if(isset($_SESSION['editUserError'])){ ?>
    <script>
        window.onload = function(){
            document.getElementById("editUserModal").classList.add("show");
        };
    </script>
    
    <?php
        unset($_SESSION['editUserError']);
        }
    ?>

<?php
    include '../includes/footer.php';
?>