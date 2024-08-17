<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $booked = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $speciality = trim($_POST['speciality']);
        $name = trim($_POST['name']);
        $doa = $_POST['date-of-appointment'];
        $toa = $_POST['toa'];
        $type = $_POST['appointment_type'];
        $reason = $_POST['reason'];
        $existsSql = "SELECT * FROM doctor WHERE name='$name' AND speciality = '$speciality'";
        $result = mysqli_query($con, $existsSql);
        if ($result && mysqli_num_rows($result) > 0){
            $sql = "INSERT INTO `appointment` (`username`, `speciality`, `doc_name`, `doa`, `toa`, `type`, `reason`) VALUES ('$username', '$speciality', '$name', '$doa', '$toa', '$type', '$reason')";
            $result = mysqli_query($con, $sql);
            if($result){
                $booked = true;
            }  
        }
        else {
            if($result && mysqli_num_rows($result) == 0){
                $showError = "Doctor doesn't exists";
            }
            else{
                $sql = "SELECT * FROM appointment WHERE doc_name='$name' AND speciality = '$speciality' AND doa='$doa' AND toa='$toa'";
                $result = mysqli_query($con, $sql);
                if ($result && mysqli_num_rows($result) > 0){
                    $showError = "Slot is already booked. Please try with another slot!";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/add-update-doctor.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
    <style>
        #doctorlist ul {
            background-color: #eee;
            cursor: pointer;
        }

        #doctorlist li {
            padding: 12px;
        }

        select:disabled option[disabled] {
            color: red;
        }

        .note {
            color: red;
            text-align: center;
        }

        .alert {
            margin-top: 20px;
            margin-right: 20px;
        }

    </style>
</head>

<body>
    <?php include 'partials/_patient-header.php'; ?>
    <main>
        <div class="right">
            <?php
                if($showError){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error! </strong>".$showError ."
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
                if($booked){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> You booked successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
            ?>
            <div class="heading">
                <h1>Book Appointment</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_book_appointment(event)"
                        action="/rtp-doctor-appointment-booking-system/patient-book-app.php" name="patient-book-app"
                        id="patient-book-app" method="post">
                        <div class="form">
                            <div class="formdesign" id="select_speciality">
                                <label for="speciality">Speciality</label>
                                <select name="speciality" id="speciality">
                                    <option value="#">Select</option>
                                    <option value="Neurologist">Neurologist</option>
                                    <option value="Psychiatrist">Psychiatrist</option>
                                    <option value="General Physician">General Physician</option>
                                    <option value="Surgeon">Surgeon</option>
                                    <option value="Oncologist">Oncologist</option>
                                    <option value="Dermatologist">Dermatologist</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Gynaecologist">Gynaecologist</option>
                                </select>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="udoc_name">
                                <label for="name">Doctor Name</label>
                                <input type="text" name="name" id="name" placeholder="Doctor's full name"
                                    autocomplete="off"><b><span class="formerror"></span></b>
                                <div id="doctorlist"></div>
                            </div>
                            <div class="formdesign" id="udoa">
                                <label for="date-of-appointment">Date of Appointment</label>
                                <input type="date" name="date-of-appointment" id="doa"
                                    min="<?php echo date('Y-m-d'); ?>"><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="select_time">
                                <label for="toa">Time of Appointment</label>
                                <select name="toa" id="toa">
                                    <option value="#">Select</option>
                                    <option value="9:30 AM">9:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                </select>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uatype">
                                <label for="appointment_type">Appointment Type</label>
                                <select name="appointment_type" id="appointment_type">
                                    <option value="#">Select</option>
                                    <option value="New consultation">New consultation</option>
                                    <option value="Follow up">Follow up</option>
                                </select>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ureason">
                                <label for="reason">Reason for Visit</label>
                                <input type="text" name="reason" id="reason" placeholder="Reason for visit"><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="note">
                                Note: Payment is done offline!
                            </div>
                            <div class="buttons">
                                <button type="submit">Book</button>
                                <button type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
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
                // Fetch available times for the selected doctor and date
                var docName = $(this).text();
                var doa = $('#doa').val();
                if (docName && doa) {
                    $.ajax({
                        url: "fetch-available-times.php",
                        method: "POST",
                        data: { docName: docName, doa: doa },
                        success: function (data) {
                            $('#toa').html(data);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Event listener for doctor selection
            $(document).on('click', 'li', function () {
                var docName = $(this).text();
                var doa = $('#doa').val();
                if (docName && doa) {
                    $.ajax({
                        url: "fetch-available-times.php",
                        method: "POST",
                        data: { docName: docName, doa: doa },
                        success: function (data) {
                            $('#toa').html(data);
                        }
                    });
                }
            });

            // Event listener for date selection
            $('#doa').change(function () {
                var docName = $('#name').val();
                var doa = $(this).val();
                if (docName && doa) {
                    $.ajax({
                        url: "fetch-available-times.php",
                        method: "POST",
                        data: { docName: docName, doa: doa },
                        success: function (data) {
                            $('#toa').html(data);
                        }
                    });
                }
            });
        });
    </script>
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

        function validateForm_book_appointment(event) {
            var returnval = true;
            clearErrors();

            var selectedOption1 = document.forms['patient-book-app']['speciality'].value;
            if (selectedOption1 == '#') {
                seterror("select_speciality", "*Please select speciality");
                returnval = false;
            }

            var name = document.forms['patient-book-app']['name'].value;
            if (name == '') {
                seterror("udoc_name", "*Field is required");
                returnval = false;
            }

            var time = document.forms['patient-book-app']['date-of-appointment'].value;
            if (time == '') {
                seterror("udoa", "*Field is required");
                returnval = false;
            }

            var selectedOption2 = document.forms['patient-book-app']['toa'].value;
            if (selectedOption2 == '#') {
                seterror("select_time", "*Please select a time of appointment");
                returnval = false;
            }

            var selectedOption3 = document.forms['patient-book-app']['appointment_type'].value;
            if (selectedOption3 == '#') {
                seterror("uatype", "*Please select type of appointment");
                returnval = false;
            }

            var name = document.forms['patient-book-app']['reason'].value;
            if (name == '') {
                seterror("ureason", "*Field is required");
                returnval = false;
            }

            if (!returnval) {
                event.preventDefault();
            }

            return returnval;
        }
    </script>

    <script>
        $(document).ready(function () {
            function fetchAvailableTimes() {
                var docName = $('#name').val();
                var doa = $('#doa').val();
                if (docName && doa) {
                    $.ajax({
                        url: "fetch-available-times.php",
                        method: "POST",
                        data: { docName: docName, doa: doa },
                        success: function (data) {
                            $('#toa').html(data);
                        }
                    });
                }
            }
            $('#name').keyup(function () {
                fetchAvailableTimes();
            });
            $('#doa').change(function () {
                fetchAvailableTimes();
            });
            $(document).on('click', 'li', function () {
                $('#name').val($(this).text());
                $('#doctorlist').fadeOut();
                fetchAvailableTimes();
            });
        });
    </script>
</body>

</html>