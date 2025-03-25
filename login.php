<?php session_start();?>
<?php include('head.php');?>
<link rel="stylesheet" href="popup_style.css">

<?php
include('connect.php');

if(isset($_POST['btn_login'])) {
    // Get the username and password from POST data
    $username = $_POST['username'];
    $username = mysqli_real_escape_string($conn, $username);
    $username = htmlentities($username);

    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn, $password);
    $password = htmlentities($password);

    // Query to check if the username and password match
    $sql = "SELECT * FROM admin WHERE username='$username' and password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    // Set session variables if login is successful
    $_SESSION["id"] = $row['id'];
    $_SESSION["username"] = $row['username'];
    $_SESSION["password"] = $row['password'];
    $_SESSION["email"] = $row['email'];
    $_SESSION["fname"] = $row['fname'];
    $_SESSION["lname"] = $row['lname'];
    $_SESSION["image"] = $row['image'];
    
    $count = mysqli_num_rows($result);
    if($count == 1 && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Success</h3>
                <p>Login Successfully</p>
                <p>
                    <?php echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>"; ?>
                </p>
            </div>
        </div>
        <?php
    } else { ?>
        <div class="popup popup--icon -error js_error-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">Error</h3>
                <p>Invalid Username or Password</p>
                <p>
                    <a href="login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                </p>
            </div>
        </div>
    <?php
    }
}
?>

<div id="main-wrapper">
    <div class="unix-login">
        <?php
        $sql_login = "SELECT * FROM manage_website"; 
        $result_login = $conn->query($sql_login);
        $row_login = mysqli_fetch_array($result_login);
        ?>
        <div class="container-fluid" style="background-color: #FA8BFF;
background-image: linear-gradient(45deg, #FA8BFF 0%, #2BD2FF 52%, #2BFF88 90%);">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="login-content card">
                        <div class="login-form" style="font-family:Algerian;">
                            <center><img src="adlogin.webp" style="width:50%";></center><br>
                            <form method="POST">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username" required="" style="font-family:Times New Roman";>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required="" style="font-family:Times New Roman";>
                                </div>
                                <button type="submit" name="btn_login" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                                <p align=center class="role-msg" style="font-family:Footlight MT Light; font-size:20px;">Are you a student? <a href="student.php">Login Here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/sidebarmenu.js"></script>
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="js/custom.min.js"></script>
</body>
</html>
