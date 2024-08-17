<?php
    session_start();
    $userlogin = false;
    $adminlogin = false;
    $doctorlogin = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //for user/patient credientials
        $userType = $_POST['user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        //for admin credientials
        $admin_username = "admin";
        $admin_password = "123";
        if ($userType == 'doctor.html') {
            // Check doctor's credentials
            $sqld = "SELECT * FROM doctor WHERE username='$username' AND password='$password'";
            $resultd = mysqli_query($con, $sqld);
            $numd = mysqli_num_rows($resultd);
            if ($numd == 1) {
                $doctorlogin = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
            }
        } elseif ($userType == 'patient.html') {
            // Check patient's credentials
            $sql = "SELECT * FROM registration WHERE username='$username' AND password='$password'";
            $result = mysqli_query($con, $sql);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                $userlogin = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
            }
        } 
        elseif ($userType == 'admin.html') {
            // Check admin's credentials
            if ($username == $admin_username && $password == $admin_password) {
                $adminlogin = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $admin_username;
            }
        }
        // Show error if credentials are invalid
        if (!$doctorlogin && !$userlogin && !$adminlogin) {
            $showError = true;
        }
        if($userlogin){
            header("Location: patient.php");
            exit();
        }
        if($adminlogin){
            header("Location: admin.php");
            exit();
        }
        if($doctorlogin){
            header("Location: doctor.php");
            exit();
        }     
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/common-bootstrap-edis.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/registration-login-header.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <div class="logo">
                    <img src="img/logo.png" alt="logo">
                </div>
                <div class="option">
                <button class="btn btn-sm btn-primary mt-3" style="height: 35px; width: 80px; margin: 5px;"><a href="registration.php">Register</a></button>
                <div class="option">
                <button class="btn btn-sm btn-primary mt-3 m-3" style="height: 35px; width: 80px; margin: 5px;"><a href="index.html">Home</a></button>
                </div>
            </ul>
        </nav>
    </header>
    <?php
        if($showError){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Error! </strong> invalid credintieals <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
    ?>
    <main>
        <div class="login">
            <div class="image">
                <img src="img/doctor-login1.jpg" alt="">
            </div>
            <form onsubmit="return validateForm_login(event)" action="/rtp-doctor-appointment-booking-system/login.php" id="loginForm" name="loginForm"
                 method="post">
                <div class="form">
                    <div class="formdesign" id="select">
                        <label for="dropdown-menu">
                            <select name="user" id="dropdown-menu">
                                <option value="#">Select</option>
                                <option name="user" value="patient.html">User</option>
                                <option name="user" value="doctor.html">Doctor</option>
                                <option name="user" value="admin.html">Admin</option>
                            </select>
                        </label><b><span class="formerror"></span></b>
                    </div>
                    <div class="formdesign" id="uusername">
                        <label for="username">User ID</label>
                        <input type="text" name="username" id="username"><b><span class="formerror"></span></b>
                    </div>
                    <div class="formdesign" id="upassword">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"><b><span class="formerror"></span></b>
                    </div>
                    <div class="button">
                        <button type="submit" class=" btn btn-sm btn-primary">Login</button>
                        <a href="forgot-password.php">Forgot password?</a>
                        <a href="registration.php">New member?</a>
                    </div>   
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/validation.js"></script>
</body>

</html>