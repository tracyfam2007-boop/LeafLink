<?php
    include 'database/db_connect.php';
    include 'includes/header.php';

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    $error = "";
    $success = "";

    $showResetForm = false;

    if(isset($_POST['btnVerify'])){

        $emailAddress = trim($_POST['emailAddress']);
        $phoneNumber = trim($_POST['phoneNumber']);

        if(empty($emailAddress) || empty($phoneNumber)){
            $error = "Please enter your email and phone number.";
        }else{
            $sql = "SELECT * FROM user
                    WHERE emailAddress = ?
                    AND phoneNumber = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ss",
                $emailAddress,
                $phoneNumber
            );

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $user = mysqli_fetch_assoc($result);
                $_SESSION['resetUserId'] = $user['userId'];
                $showResetForm = true;
            }else{
                $error = "Invalid email address or phone number.";
            }
        }
    }

    if(isset($_POST['btnResetPassword'])){

        $userId = $_SESSION['resetUserId'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $showResetForm = true;

        if(empty($newPassword) || empty($confirmPassword)){
            $error = "Please enter your new password.";
        }else if(strlen($newPassword) < 8){
            $error = "Password must be at least 8 characters.";
        }else if($newPassword != $confirmPassword){
            $error = "Passwords do not match.";
        }else{

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE user
                    SET password = ?
                    WHERE userId = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ss",
                $hashedPassword,
                $userId
            );

            if(mysqli_stmt_execute($stmt)){
                unset($_SESSION['resetUserId']);
                $success = "Password reset successfully! Redirecting to Login...";
                $showResetForm = false;
                header("refresh:2;url=login.php");
            }else{
                $error = "Failed to reset password.";
            }
        }
    }

?>

<section class="auth-section">

    <div class="container">

        <div class="auth-card">

            <h1>Forgot Password</h1>

            <p>
                Verify your account before resetting your password.
            </p>

            <?php
                if($error != ""){
            ?>

                <div class="error-message">
                    <?php echo $error; ?>
                </div>

            <?php
                }

                if($success !=""){
            ?>

                <div class="success-message">
                    <?php echo $success; ?>
                </div>

            <?php
                }
            ?>

            <form action="" method="POST">

                <div class="form-group">

                    <label>Email Address</label>

                    <input 
                        type="email"
                        name="emailAddress"
                        placeholder="Enter your email"
                        required>

                </div>

                <div class="form-group">

                    <label>Phone Number</label>

                    <input
                        type="tel"
                        name="phoneNumber"
                        placeholder="01XXXXXXXX"
                        pattern="01[0-9]{8,9}"
                        required>

                </div>

                <button
                    type="submit"
                    name="btnVerify"
                    class="auth-btn">Verify Account</button>

            </form>

            <?php
                if($showResetForm){
            ?>

            <hr><br>

            <h2>Create New Password</h2>

            <form action="" method="POST">

                <div class="form-group">

                    <label>New Password</label>

                    <input
                        type="password"
                        name="newPassword"
                        placeholder="Minimum 8 characters"
                        minlength="8"
                        required>
                </div>

                <div class="form-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="confirmPassword"
                        placeholder="Re-enter password"
                        minlength="8"
                        required>

                </div>

                <button
                    type="submit"
                    name="btnResetPassword"
                    class="auth-btn">Reset Password</button>
                
            </form>

            <?php
                }
            ?>

            <div class="login-link">

                <a href="login.php">Back to Login</a>

            </div>

        </div>

    </div>

</section>

<?php
    include 'includes/footer.php';
?>


