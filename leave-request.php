<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $sent = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $reason = $_POST['name'];
        $start = $_POST['date-of-appointment-start'];
        $end = $_POST['date-of-appointment-end'];
        $comment = $_POST['reason'];
        $sql1 = "SELECT * FROM `doctor` WHERE username = '$username'";
        $result1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
        $name = $row1['name'];
        $existsSql = "SELECT * FROM `leave_request` WHERE username = '$username'";
        $result = mysqli_query($con, $existsSql);
        $sql = "INSERT INTO `leave_request` (`username`, `doc_name`, `reason`, `start_date`, `end_date`, `comments`) VALUES ('$username', '$name', '$reason', '$start', '$end', '$comment')";
        $result = mysqli_query($con, $sql);
        if($result){
            $sent = true; 
        } 
        else{
            $showError = "Try again";
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave scheduler</title>
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
                if($showError){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error! </strong>".$showError ."
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
                if($sent){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Request sent successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
            ?>
            <div class="heading">
                <h1>Request for leave</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_book_appointment(event)"
                        action="/rtp-doctor-appointment-booking-system/leave-request.php" name="patient-book-app"
                        id="patient-book-app" method="post">
                        <div class="form">
                            <div class="formdesign" id="udoc_name">
                                <label for="name">Reason for leave</label>
                                <input type="text" name="name" id="name"><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="udoa">
                                <label for="date-of-appointment">Start date</label>
                                <input type="date" name="date-of-appointment-start" id="doa"
                                    min="<?php echo date('Y-m-d'); ?>"><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="udoa">
                                <label for="date-of-appointment">End date</label>
                                <input type="date" name="date-of-appointment-end" id="doa"
                                    min="<?php echo date('Y-m-d'); ?>"><b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ureason">
                                <label for="reason">Additional comments</label>
                                <textarea name="reason" id="reason" cols="30" rows="10"></textarea><b><span
                                        class="formerror"></span></b>
                            </div>
                            <div class="buttons">
                                <button type="submit">Send request</button>
                                <button type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>