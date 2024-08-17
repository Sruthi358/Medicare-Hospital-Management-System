<?php
    session_start();
    $update = false;
    $showerror=false;
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    $sql = "select * from doctor where username='$username' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: No record found for the username '$username'.";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phone = $_POST['phno'];
        $gender = $_POST['gender'];
        $language = $_POST['languages'];
        $languages_string = implode(',',$language);
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
                // echo "File uploaded successfully.";
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Error uploading file: " . $_FILES["uploadfile"]["error"];
        }
        $sql = "UPDATE `doctor` SET `name` = '$name',`photo` = '$folder', `email` = '$email',`dob` = '$dob', `phone` = '$phone',`gender` = '$gender', `languages` = '$languages_string',`area` = '$area', `city` = '$city',`state` = '$state', `code` = '$code',`password` = '$password' WHERE `doctor`.`username` = '$username'";
        $result = mysqli_query($con, $sql);
        if($result){
            $update = true;
            // Fetch the updated data
            $sql = "SELECT * FROM doctor WHERE username='$username' LIMIT 1";
            $result1 = mysqli_query($con, $sql);
            if ($result1 && mysqli_num_rows($result1) > 0) {
                $row = mysqli_fetch_assoc($result1);
            }
            else {
                $showerror = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/add-update-doctor.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
</head>

<body>
    <?php include 'partials/_doctor-header.php';?>
    <main>
        <div class="right">
            <?php
                if($update){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>success! </strong> Updated successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
                if($showerror){
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>success! </strong> Not updated successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            ?>
            <div class="heading">
                <h1>Edit details</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_update_doctor(event)"
                        action="/rtp-doctor-appointment-booking-system/update-details-doctor.php" name="update_doctor"
                        method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="formdesign" id="dname">
                                <label for="name">Patient's full name</label>
                                <input type="text" name="name" id="name" value="<?php echo $row['name'];?>"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uname">
                                <label for="name">Current Image</label>
                                <div>
                                    <img src="<?php echo $row['photo']; ?>" alt="Current Photo" height="100px">
                                </div>
                            </div>
                            <div class="formdesign" id="uname">
                                <label for="uploadfile">Upload New Image</label>
                                <input type="file" name="uploadfile">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="d_uname">
                                <label for="name">Username</label>
                                <input type="text" name="u_name" id="u_name" value="<?php echo $row['username'];?>"
                                    disabled><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="demail">
                                <label for="email">Email address</label>
                                <input type="email" name="email" id="email" value="<?php echo $row['email'];?>"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ddob">
                                <label for="dob">Date of birth</label>
                                <input type="date" name="dob" id="dob" value="<?php echo $row['dob'];?>"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="dphno">
                                <label for="phno">Phone number</label>
                                <input type="text" name="phno" id="phno" value="<?php echo $row['phone'];?>"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <!-- gender -->
                            <div class="formdesign" id="gender">
                                <label for="">Gender</label>
                                <div class="gender-part" value="<?php echo $row['gender'];?>">
                                    <label for="male">
                                        <input type="radio" name="gender" value="Male" <?php echo (isset($row['gender'])
                                            && $row['gender']=='Male' ) ? 'checked' : '' ; ?>>Male
                                    </label>
                                    <label for="female">
                                        <input type="radio" name="gender" value="Female" <?php echo
                                            (isset($row['gender']) && $row['gender']=='Female' ) ? 'checked' : '' ;
                                            ?>>Female
                                    </label>
                                    <label for="other">
                                        <input type="radio" name="gender" value="Other" <?php echo
                                            (isset($row['gender']) && $row['gender']=='Other' ) ? 'checked' : '' ;
                                            ?>>Other
                                    </label>
                                </div><b><span class="formerror" id="gender_error"></span></b>
                            </div>
                            <div class="formdesign" id="language">
                                <label for="">Languages known</label>
                                <div class="gender-part" value="<?php echo $row['languages'];?>">
                                    <label for="telugu">
                                        <input type="checkbox" name="languages[]" value="Telugu" <?php echo
                                            (isset($row['languages']) && in_array('Telugu', explode(',',
                                            $row['languages']))) ? 'checked' : '' ; ?>>Telugu
                                    </label>
                                    <label for="hindi">
                                        <input type="checkbox" name="languages[]" value="Hindi" <?php echo
                                            (isset($row['languages']) && in_array('Hindi', explode(',',
                                            $row['languages']))) ? 'checked' : '' ; ?>>Hindi
                                    </label>
                                    <label for="english">
                                        <input type="checkbox" name="languages[]" value="English" <?php echo
                                            (isset($row['languages']) && in_array('English', explode(',',
                                            $row['languages']))) ? 'checked' : '' ; ?>>English
                                    </label>
                                    <label for="tamil">
                                        <input type="checkbox" name="languages[]" value="Tamil" <?php echo
                                            (isset($row['languages']) && in_array('Tamil', explode(',',
                                            $row['languages']))) ? 'checked' : '' ; ?>>Tamil</label>
                                </div><b><span class="formerror" id="language_error"></span></b>
                            </div>
                            <div class="formdesign" id="dqualification">
                                <label for="qualification">
                                    Qualification
                                </label>
                                <input type="text" name="qualification" value="<?php echo $row['qualification'];?>"
                                    readonly><b><span class="formerror" id="language_error"></span></b>
                            </div>
                            <div class="formdesign" id="select">
                                <label for="dropdown-menu">Speciality</label>
                                <label for="dropdown-menu">
                                    <select name="speciality" id="dropdown-menu">
                                        <option value="#" disabled>Select</option>
                                        <option value="Neurologist" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Neurologist' ) ? 'selected' : '' ; ?>
                                            disabled>Neurologist</option>
                                        <option value="Psychiatrist" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Psychiatrist' ) ? 'selected' : '' ; ?>
                                            disabled>Psychiatrist</option>
                                        <option value="General Physician" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='General Physician' ) ? 'selected' : '' ; ?>
                                            disabled>General Physician</option>
                                        <option value="Surgeon" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Surgeon' ) ? 'selected' : '' ; ?> disabled>Surgeon
                                        </option>
                                        <option value="Oncologist" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Oncologist' ) ? 'selected' : '' ; ?>
                                            disabled>Oncologist</option>
                                        <option value="Dermatologist" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Dermatologist' ) ? 'selected' : '' ; ?>
                                            disabled>Dermatologist</option>
                                        <option value="Cardiologist" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Cardiologist' ) ? 'selected' : '' ; ?>
                                            disabled>Cardiologist</option>
                                        <option value="Gynaecologist" <?php echo (isset($row['speciality']) &&
                                            $row['speciality']=='Gynaecologist' ) ? 'selected' : '' ; ?>
                                            disabled>Gynaecologist</option>
                                    </select>
                                </label><b><span class="formerror" id="language_error"></span></b>
                            </div>
                            <label for="address">Address</label>
                            <div class="address">
                                <div class="formdesign" id="darea"><input type="text" name="area" id="area"
                                        value="<?php echo $row['area'];?>"><b><span class="formerror"></span></b></div>
                                <div class="formdesign" id="dcity"><input type="text" name="city" id="city"
                                        value="<?php echo $row['city'];?>"><b><span
                                            class="formerror"></span></b></span></b>
                                </div>
                                <div class="formdesign" id="dstate"><input type="text" name="state" id="state"
                                        value="<?php echo $row['state'];?>"><b><span
                                            class="formerror"></span></b></span></b>
                                </div>
                                <div class="formdesign" id="dcode"><input type="text" name="code" id="code"
                                        value="<?php echo $row['code'];?>"><b><span class="formerror"></span></b></div>
                            </div>
                            <div class="formdesign" id="dpassword">
                                <label for="password">Password</label>
                                <input type="text" name="password" id="password"
                                    value="<?php echo $row['password'];?>"><b><span class="formerror"></span></b>
                            </div>
                            <div class="buttons">
                                <button type="submit">Save changes</button>
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
    <script>
        function seterror(id, error) {
            var element = document.getElementById(id);
            element.getElementsByClassName('formerror')[0].innerHTML = error;
        }

        function clearErrors() {
            var errors = document.getElementsByClassName('formerror');
            for (var i = 0; i < errors.length; i++) {
                errors[i].innerHTML = "";
            }
            console.log("Errors cleared");
        }

        function hasSymbol(password) {
            const symbolRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
            return symbolRegex.test(password);
        }

        function hasNumber(password) {
            const numberRegex = /\d/;
            return numberRegex.test(password);
        }

        function hasDot(email) {
            const emailRegex = /.@/;
            return emailRegex.test(email);
        }

        function validateGender() {
            var radios = document.getElementsByName('gender');
            var isChecked = false;
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    isChecked = true;
                    break;
                }
            }
            if (!isChecked) {
                seterror("gender", "*Please select a gender");
                return false;
            }
            return true;
        }

        function validateLanguage() {
            var check = document.getElementsByName('languages[]');
            var isChecked = false;
            for (var i = 0; i < check.length; i++) {
                if (check[i].checked) {
                    isChecked = true;
                    break;
                }
            }
            if (!isChecked) {
                seterror("language", "*Please choose a language");
                return false;
            }
            return true;
        }

        function hasDot(email) {
            const emailRegex = /.@/;
            return emailRegex.test(email);
        }

        function validateForm_update_doctor(event) {
            var returnval = true;
            clearErrors();

            var name = document.forms['update_doctor']['name'].value;
            if (name == '') {
                seterror("dname", "*Field is required");
                returnval = false;
            }

            var email = document.forms['update_doctor']['email'].value;
            if (email == '') {
                seterror("demail", "*Field is required");
                returnval = false;
            }
            else if (!hasDot(email)) {
                seterror("uemail", "*Enter valid email address");
                returnval = false;
            }

            var dob = document.forms['update_doctor']['dob'].value;
            if (dob == '') {
                seterror("ddob", "*Field is required");
                returnval = false;
            }

            var phno = document.forms['update_doctor']['phno'].value;
            if (phno == '') {
                seterror("dphno", "*Field is required");
                returnval = false;
            }

            if (phno.length != 10) {
                seterror("dphno", "*Enter valid phone number");
                returnval = false;
            }

            if (!validateLanguage()) {
                returnval = false;
            }

            var area = document.forms['update_doctor']['area'].value;
            if (area == '') {
                seterror("darea", "*Field is required");
                returnval = false;
            }

            var city = document.forms['update_doctor']['city'].value;
            if (city == '') {
                seterror("dcity", "*Field is required");
                returnval = false;
            }

            var state = document.forms['update_doctor']['state'].value;
            if (state == '') {
                seterror("dstate", "*Field is required");
                returnval = false;
            }

            var code = document.forms['update_doctor']['code'].value;
            if (code == '') {
                seterror("dcode", "*Field is required");
                returnval = false;
            }

            var password = document.forms['update_doctor']['password'].value;
            if (password == '') {
                seterror("dpassword", "*Field is required");
                returnval = false;
            }
            if (password.length < 6 || !hasSymbol(password) || !hasNumber(password)) {
                seterror("dpassword", "*Minimum length of password must be 6<br>*Password must contain a symbol<br>*Password must contain a number");
                returnval = false;
            }

            if (!returnval) {
                event.preventDefault();
            }

            return returnval;
        }
    </script>
</body>

</html>