<?php
    session_start();
    include 'database/db_connect.php';
    include 'includes/header.php';

    $error = "";

    if(isset($_POST['btnLogin'])){

        $emailAddress = trim($_POST['emailAddress']);
        $password = $_POST['password'];

        if(empty($emailAddress) || empty($password)){
            $error = "Please enter your email and password.";
        }else{

            $sql = "SELECT * FROM user WHERE emailAddress = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "s", $emailAddress);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $user = mysqli_fetch_assoc($result);

                if(password_verify($password, $user['password'])){

                    if(session_status() == PHP_SESSION_NONE){
                        session_start();
                    }

                    $_SESSION['userId'] = $user['userId'];
                    $_SESSION['roleId'] = $user['roleId'];
                    $_SESSION['fullName'] = $user['fullName'];
                    $_SESSION['emailAddress'] = $user['emailAddress'];

                    if($user['roleId'] == "R000001"){
                        header("Location: participant/dashboard.php");
                        exit();
                    }else if($user['roleId'] == "R000002"){
                        header("Location: moderator/dashboard.php");
                        exit();
                    }else if($user['roleId'] == "R000003"){
                        header("Location: admin/dashboard.php");
                        exit();
                    }else{
                        $error = "Invalid user role.";
                    }

                }else{
                    $error = "Incorrect password.";
                }
                
            }else{
                $error = "Email address does not exist.";
            }
        }
    }
?>

<section class="auth-section">

    <div class="container">

        <div class="auth-card">

            <h1>Login</h1>

            <p>Welcome back to LeafLink.</p>

            <?php
                if($error != ""){
            ?>

                <div class="error-message">
                    <?php echo $error; ?>
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

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required>

                </div>

                <button
                    type="submit"
                    name="btnLogin"
                    class="auth-btn">Login</button>

            </form>

            <div class="login-link">

                <a href="forgot_password.php">Forgot Password?</a>

                <br><br>

                Don't have an account?

                <a href="register.php">Register Here</a>

            </div>

        </div>

    </div>

</section>

<?php
    include 'includes/footer.php';
?>