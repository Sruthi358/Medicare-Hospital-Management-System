<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $insert = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $username = $_POST['u_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phone = $_POST['phno'];
        $gender = $_POST['gender'];
        $language = $_POST['languages'];
        $languages_string = implode(',',$language);
        $qualification = $_POST['qualification'];
        $speciality = $_POST['speciality'];
        $area = $_POST['area'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $code = $_POST['code'];
        $password = $_POST['password'];
        if ($_FILES["uploadfile"]["error"] === UPLOAD_ERR_OK) {
            $filename = basename($_FILES["uploadfile"]["name"]);
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $folder = "images/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Error uploading file: " . $_FILES["uploadfile"]["error"];
        }
        $existsSql = "SELECT * FROM `doctor` WHERE username = '$username'";
        $result = mysqli_query($con, $existsSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
          $showError = true;
        }
        else{
        $sql = "INSERT INTO `doctor` (`name`, `username`, `email`, `dob`, `phone`, `gender`, `languages`, `qualification`, `speciality`, `area`, `city`, `state`, `code`, `password`,`photo`) VALUES ('$name', '$username', '$email', '$dob', '$phone', '$gender', '$languages_string', '$qualification', '$speciality', '$area', '$city', '$state', '$code', '$password','$folder')";
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
    <title>Add Doctors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/add-update-doctor.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
</head>

<body>
    <?php include 'partials/_admin-header.php';?>
    <main>
        <div class="right">
            <?php
                if($showError){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error! </strong> Username already exists
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
                if($insert){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your information has been inserted successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
            ?>
            <div class="heading">
                <h1>Add doctor</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_add_doctor(event)"
                        action="/rtp-doctor-appointment-booking-system/add-doctor-copy.php" name="registration"
                        method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="formdesign" id="uname">
                                <label for="name">Doctor's full name</label>
                                <input type="text" name="name" id="name" placeholder="Doctor's full name"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uname">
                                <label for="name">Upload Image</label>
                                <input type="file" name="uploadfile">
                                <b><span class="formerror"></span></b>
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
                                <input type="date" name="dob" id="dob" max="<?php echo date('Y-m-d'); ?>"><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uphno">
                                <label for="phno">Phone number</label>
                                <input type="text" name="phno" id="phno" placeholder="Enter phone number"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="gender">
                                <label for="">Gender</label>
                                <div class="gender-part">
                                    <label for="male" class="male"><input type="radio" name="gender"
                                            value="Male">&nbsp;Male</label>
                                    <label for="female"><input type="radio" name="gender"
                                            value="Female">&nbsp;Female</label>
                                    <label for="other"><input type="radio" name="gender"
                                            value="Other">&nbsp;Other</label>
                                </div><b><span class="formerror" id="gender_error"></span></b>
                            </div>
                            <div class="formdesign" id="language">
                                <label for="">Languages known</label>
                                <div class="languages-part">
                                    <label for="languages"><input type="checkbox" name="languages[]" id="telugu"
                                            value="Telugu">&nbsp;Telugu</label>
                                    <label for="languages"><input type="checkbox" name="languages[]" id="hindi"
                                            value="Hindi">&nbsp;Hindi</label>
                                    <label for="languages"><input type="checkbox" name="languages[]" id="english"
                                            value="English">&nbsp;English</label>
                                    <label for="languages"><input type="checkbox" name="languages[]" id="tamil"
                                            value="Tamil">&nbsp;Tamil</label>
                                </div><b><span class="formerror" id="language_error"></span></b>
                            </div>
                            <div class="formdesign" id="uqualification">
                                <label for="qualification">
                                    Qualification
                                </label>
                                <input type="text" name="qualification" placeholder="Enter qualification"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="select">
                                <label for="dropdown-menu">Speciality</label>
                                <label for="dropdown-menu">
                                    <select name="speciality" id="dropdown-menu">
                                        <option name="speciality" value="#">Select</option>
                                        <option name="speciality" value="Neurologist">Neurologist</option>
                                        <option name="speciality" value="Psychiatrist">Psychiatrist</option>
                                        <option name="speciality" value="General Physician">General Physician</option>
                                        <option name="speciality" value="Surgeon">Surgeon</option>
                                        <option name="speciality" value="Oncologist">Oncologist</option>
                                        <option name="speciality" value="Dermatologist">Dermatologist</option>
                                        <option name="speciality" value="Cardiologist">Cardiologist</option>
                                        <option name="speciality" value="Gynaecologist">Gynaecologist</option>
                                    </select>
                                </label><b><span class="formerror" id="language_error"></span></b>
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
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password"
                                    placeholder="Enter password"><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ucpassword">
                                <label for="confirm-password">Confirm password</label>
                                <input type="password" name="cpassword" id="cpassword"
                                    placeholder="Confirm password"><b><span class="formerror"></span></b>
                            </div>
                            <div class="buttons">
                                <button type="submit">Add</button>
                                <button type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/validation.js"></script>
</body>

</html>