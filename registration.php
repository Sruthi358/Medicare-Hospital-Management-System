<?php
    $insert = false;
    $showError = false;
    //connection to database
    include 'partials/_dbconnect.php';
    //read the values from the form
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $username = $_POST['u_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phone = $_POST['phno'];
        $gender = $_POST['gender'];
        $area = $_POST['area'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $code = $_POST['code'];
        $password = $_POST['password'];
        //to check whether another user exists with same username
        $existsSql = "SELECT * FROM `registration` WHERE username = '$username'";
        $result = mysqli_query($con, $existsSql);
        $numExistRows = mysqli_num_rows($result);
        //if yes then show error
        if($numExistRows > 0){
          $showError = true;
        }
        //else insert the values into database
        else{
            $sql = "INSERT INTO `registration` (`name`, `username`, `email`, `dob`, `phone`, `gender`, `area`, `city`, `state`, `code`, `password`) VALUES ('$name', '$username', '$email', '$dob', '$phone', '$gender', '$area', '$city', '$state', '$code', '$password')";
            $result = mysqli_query($con, $sql);
            if($result){
                $insert = true;
            } 
        }   
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/common-bootstrap-edis.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="stylesheet" href="css/registration-login-header.css">
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
                    <button class="btn btn-sm btn-primary mt-3" style="height: 35px; width: 80px; margin: 5px;"><a
                            href="login.php">Login</a></button>
                    <div class="option">
                        <button class="btn btn-sm btn-primary mt-3 m-3"
                            style="height: 35px; width: 80px; margin: 5px;"><a href="index.html">Home</a></button>
                    </div>
            </ul>
        </nav>
    </header>
    <?php
        if($showError){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Error! </strong> Username already exists
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
        if($insert){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> You registered successfully. Now you can login
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
    ?>
    <main>
        <div class="whole">
            <div class="image">
                <img src="img/doctor.jpg" alt="doctor">
            </div>
            <div class="form-outer">
                <form onsubmit="return validateForm_reg(event)" onreset="clearErrors()"
                    action="/rtp-doctor-appointment-booking-system/registration.php" name="registration" method="post">
                    <div class="form">
                        <div class="formdesign" id="uname">
                            <label for="name">Patient's full name</label>
                            <input type="text" name="name" id="name" placeholder="Patient's full name"><b><span
                                    class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="u_uname">
                            <label for="name">Username</label>
                            <input type="text" name="u_name" id="u_name" placeholder="Enter username"><b><span
                                    class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="uemail">
                            <label for="email">Email address</label>
                            <input type="email" name="email" id="email" placeholder="Enter email"><b><span
                                    class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="udob">
                            <label for="dob">Date of birth</label>
                            <input type="date" name="dob" id="dob" max="<?php echo date('Y-m-d'); ?>"><b><span
                                    class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="uphno">
                            <label for="phno">Phone number</label>
                            <input type="text" name="phno" id="phno" placeholder="Enter phone number"><b><span
                                    class="formerror"></span></b>
                        </div>
                        <!-- gender -->
                        <div class="formdesign" id="gender">
                            <label for="">Gender</label>
                            <div class="gender-part">
                                <label for="male"><input type="radio" name="gender" value="Male">Male</label>
                                <label for="female"><input type="radio" name="gender" value="Female">Female</label>
                                <label for="other"><input type="radio" name="gender" value="Other">Other</label>
                            </div><b><span class="formerror" id="gender_error"></span></b>
                        </div>
                        <label for="address">Address</label>
                        <div class="address">
                            <div class="formdesign" id="uarea"><input type="text" name="area" id="area"
                                    placeholder="Enter area"><b><span class="formerror"></span></b></div>
                            <div class="formdesign" id="ucity"><input type="text" name="city" id="city"
                                    placeholder="Enter city"><b><span class="formerror"></span></b></span></b>
                            </div>
                            <div class="formdesign" id="ustate"><input type="text" name="state" id="state"
                                    placeholder="Enter state"><b><span class="formerror"></span></b></span></b>
                            </div>
                            <div class="formdesign" id="ucode"><input type="text" name="code" id="code"
                                    placeholder="Pin code"><b><span class="formerror"></span></b></div>
                        </div>
                        <div class="formdesign" id="upassword">
                            <label for="password">Create password</label>
                            <input type="password" name="password" id="password" placeholder="Enter password"><b><span
                                    class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="ucpassword">
                            <label for="confirm-password">Confirm password</label>
                            <input type="password" name="cpassword" id="cpassword"
                                placeholder="Confirm password"><b><span class="formerror"></span></b>
                        </div>
                        <div class="buttons">
                            <!-- <button type="submit">Register</button>
                            <button type="button">Cancel</button> -->
                            <button type="submit" class="btn btn-sm btn-primary mt-3"
                                style="height: 35px; width: 80px; margin: 5px;">Register</button>
                            <button type="reset" class="btn btn-sm btn-primary mt-3 m-3"
                                style="height: 35px; width: 80px; margin: 5px;">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/validation.js"></script>
</body>

</html>