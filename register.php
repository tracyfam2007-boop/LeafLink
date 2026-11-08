<?php
    include 'database/db_connect.php';
    include 'includes/functions.php';
    include 'includes/header.php';

    $participantTypes = [
        "Student",
        "Lecturer",
        "Staff"
    ];

    $faculties = [
        "School of Computing",
        "School of Engineering",
        "School of Technology",
        "School of Business",
        "School of Accounting",
        "School of Design",
        "School of Media"
    ];

    $error = "";
    $success = "";

    if(isset($_POST['btnRegister'])){

        $fullName = trim($_POST['fullName']);
        $emailAddress = trim($_POST['emailAddress']);
        $phoneNumber = trim($_POST['phoneNumber']);
        $dateOfBirth = $_POST['dateOfBirth'];
        $participantType = $_POST['participantType'];
        $faculty = $_POST['faculty'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if(
            empty($fullName) ||
            empty($emailAddress) ||
            empty($phoneNumber) ||
            empty($dateOfBirth) ||
            empty($participantType) ||
            empty($faculty) ||
            empty($password) ||
            empty($confirmPassword)
        ){
            $error = "Please fill in all required fields.";
        }else if(!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)){
            $error = "Please enter a valid email address.";
        }else if(!preg_match("/^01[0-9]{8,9}$/", $phoneNumber)){
            $error = "Please enter a valid Malaysian phone number.";
        }else if(strlen($password) < 8){
            $error = "Password must be at least 8 characters.";
        }else if($password != $confirmPassword){
            $error = "Password and Confirm Password do not match.";
        }else if(emailExists($conn, $emailAddress)){
            $error = "This email address is already registered.";
        }else if(phoneExists($conn, $phoneNumber)){
            $error = "This phone number is already registered.";
        }else{

            $userId = generateUserID($conn);
            $participantId = generateParticipantID($conn);

            $roleId = "R000001";

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sqlUser = "INSERT INTO user
            (
                userId,
                roleId,
                fullName,
                emailAddress,
                phoneNumber,
                password,
                dateOfBirth
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )";

            $stmtUser = mysqli_prepare($conn, $sqlUser);

            mysqli_stmt_bind_param(
                $stmtUser,
                "sssssss",
                $userId,
                $roleId,
                $fullName,
                $emailAddress,
                $phoneNumber,
                $hashedPassword,
                $dateOfBirth
            );

            $sqlParticipant = "INSERT INTO participant
            (
                participantId,
                participantType,
                faculty,
                pointBalance,
                userId
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?
            )";

            $stmtParticipant = mysqli_prepare($conn, $sqlParticipant);

            $pointBalance = 0;

            mysqli_stmt_bind_param(
                $stmtParticipant,
                "sssis",
                $participantId,
                $participantType,
                $faculty,
                $pointBalance,
                $userId
            );

            mysqli_begin_transaction($conn);

            try{

                mysqli_stmt_execute($stmtUser);

                mysqli_stmt_execute($stmtParticipant);

                mysqli_commit($conn);

                $success = "Registration successful! Redirecting to login page...";

                header("refresh:2;url=login.php");
            }catch(Exception $e){

                mysqli_rollback($conn);

                $error = "Registration failed. Please try again.";
            }
        }

    }
?>

<section class="auth-section">

    <div class="container">

        <div class="auth-card">

            <h1>Create Account</h1>

            <p>
                Join LeafLink today and start participating in green activities.
            </p>

            <?php
                if($error != ""){
            ?>

                <div class="error-message">
                    <?php echo $error; ?>
                </div>

            <?php
                }

                if($success != ""){
            ?>

                <div class="success-message">
                    <?php echo $success; ?>
                </div>

            <?php
                }
            ?>

            <form action="" method="POST">

                <div class="form-group">

                    <label>Full Name</label>

                    <input
                        type="text"
                        name="fullName"
                        placeholder="Enter your full name"
                        minlength="3"
                        required>

                </div>
                
                <div class="form-group">

                    <label>Email Address</label>

                    <input 
                        type="email"
                        name="emailAddress"
                        placeholder="Enter your email"
                        required>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label>Phone Number</label>

                        <input
                            type="tel"
                            id="phoneNumber"
                            name="phoneNumber"
                            placeholder="01XXXXXXXX"
                            pattern="01[0-9]{8,9}"
                            title="Please enter a valid Malaysian phone number."
                            required>

                    </div>

                    <div class="form-group">

                        <label>Date of Birth</label>

                        <input
                            type="date"
                            name="dateOfBirth"
                            required>

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label>Participant Type</label>

                        <select name="participantType" required>
                            
                            <option value="">-- Select Type --</option>

                            <?php
                                foreach($participantTypes as $type){
                            ?>
                                <option value="<?php echo $type; ?>">
                                    <?php echo $type; ?>
                                </option>

                            <?php
                                }
                            ?>
                            
                        </select>

                    </div>

                    <div class="form-group">

                        <label>Faculty</label>

                        <select name="faculty" required>

                            <option value="">-- Select Faculty --</option>

                            <?php
                                foreach($faculties as $faculty){
                            ?>
                                <option value="<?php echo $faculty; ?>">
                                    <?php echo $faculty; ?>
                                </option>

                            <?php
                                }
                            ?>
                            
                        </select>

                    </div>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Minimum 8 characters"
                        minlength="8"
                        required>

                </div>

                <div class="form-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        placeholder="Re-enter password"
                        minlength="8"
                        required>

                </div>

                <button type="submit" name="btnRegister" class="auth-btn">Register</button>

            </form>

            <div class="login-link">

                Already have an account?

                <a href="login.php">Login Here</a>

            </div>

        </div>

    </div>

</section>

<?php
    include 'includes/footer.php';
?>

                



                

