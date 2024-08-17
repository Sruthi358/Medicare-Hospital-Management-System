<?php
    session_start();
    $insert = false;
    $showError=false;
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `registration` WHERE `username` = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $doc_name = $_POST['name'];
        $speciality = $_POST['speciality'];
        $feedback = $_POST['feedback'];
        $sqld = "SELECT * FROM `doctor` WHERE `name` = '$doc_name' AND `speciality` = '$speciality'";
        $resultd = mysqli_query($con, $sqld);
        if ($resultd && mysqli_num_rows($resultd) > 0){
            $sqli = "INSERT INTO `feedback`(`name`, `doc_name`, `speciality`, `feedback`) VALUES ('{$row['name']}', '$doc_name', '$speciality', '$feedback') ";
            $resulti = mysqli_query($con, $sqli);
            if($resulti){
                $insert = true;
            }
            else{
                $showError=true;
            }
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/add-update-doctor.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
    <style>
        .custom-card {
            border: 2px solid rgb(224, 216, 216);
            border-radius: 5px;
            padding: 1rem;
            margin-top: 1rem;
            text-align: center;
        }

        .row h3 {
            color: black;
            text-align: center;
            padding-top: 20px;
        }

        .alert-custom {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            text-align: center;
        }

        .alert {
            margin-top: 20px;
            margin-right: 20px;
        }

        .badge {
            display: flex;
            justify-content: end;
        }
    </style>
</head>

<body>
    <?php include 'partials/_patient-header.php';?>
    <div class="right">
        <div class="heading">
            <h1>Feedback</h1>
        </div>
        <?php
            if($showError){
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error! </strong> Not submitted <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            if($insert){
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Submitted successfully. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        ?>
        <div class="whole">
            <div class="form-outer">
                <form onsubmit="return validateForm_reg(event)" onreset="clearErrors()"
                    action="/rtp-doctor-appointment-booking-system/feedback.php" name="registration" method="post">
                    <div class="form">
                        <div class="formdesign" id="udoc_name">
                            <label for="name">Doctor Name</label>
                            <input type="text" name="name" id="name" placeholder="Doctor's full name"
                                autocomplete="off"><b><span class="formerror"></span></b>
                            <div id="doctorlist"></div>
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
                        <div class="formdesign" id="uname">
                            <label for="name">Feedback</label>
                            <textarea rows="6" cols="30" name="feedback" id="feedback"
                                placeholder="Feedback"></textarea><b><span class="formerror"></span></b>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="btn btn-sm btn-primary mt-3"
                                style="height: 35px; width: 80px; margin: 5px;">Submit</button>
                            <button type="reset" class="btn btn-sm btn-primary mt-3 m-3"
                                style="height: 35px; width: 80px; margin: 5px;">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#name').keyup(function () {
                    var query = $(this).val();
                    if (query != '') {
                        $.ajax({
                            url: "search-booking.php",
                            method: "POST",
                            data: { query: query },
                            success: function (data) {
                                $('#doctorlist').fadeIn();
                                $('#doctorlist').html(data);
                            }
                        });
                    }
                    else {
                        $('#doctorlist').fadeOut();
                        $('#doctorlist').html("");
                    }
                });
                $(document).on('click', 'li', function () {
                    $('#name').val($(this).text());
                    $('#doctorlist').fadeOut();
                });
            });
        </script>
</body>

</html>