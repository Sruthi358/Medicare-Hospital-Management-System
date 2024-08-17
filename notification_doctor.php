<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    // Check for any rejected request
    $rejectedLeaveSql = "SELECT * FROM `leave_request` WHERE username='$username' AND status='Rejected' ORDER BY time DESC";
    $rejectedResult = mysqli_query($con, $rejectedLeaveSql);
    $rejectedLeave = mysqli_num_rows($rejectedResult) > 0;
    // Check for any accepted request
    $acceptedLeaveSql = "SELECT * FROM `leave_request` WHERE username='$username' AND status='Accepted' ORDER BY time DESC";
    $acceptedResult = mysqli_query($con, $acceptedLeaveSql);
    $acceptedLeave = mysqli_num_rows($acceptedResult) > 0;
    // Check for any pending request
    $pendingSql = "SELECT * FROM `leave_request` WHERE username='$username' AND status='Pending' ORDER BY time DESC";
    $pendingResult = mysqli_query($con, $pendingSql);
    $pendingLeave = mysqli_num_rows($pendingResult) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor-module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
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
    <?php include 'partials/_doctor-header.php';?>
    <div class="right">
        <?php if ($rejectedLeave)
            while ($row = mysqli_fetch_assoc($rejectedResult)) {
                // $doc_name = $row['doc_name'];
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Your request for leave have been cancelled from " . $row['start_date'] . " to" . $row['end_date'] . ".
                <p style='font-size: 13px; color:green; display: flex; justify-content: end;'>". $row['time'] ."</p>
                <!-- <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button> -->
            </div>";
            }
            if ($acceptedLeave)
            while ($row = mysqli_fetch_assoc($acceptedResult)) {
                // $doc_name = $row['doc_name'];
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Your request for leave have been accepted from " . $row['start_date'] . " to" . $row['end_date'] . ".
                <p style='font-size: 13px; color:green; display: flex; justify-content: end;'>". $row['time'] ."</p>
                <!-- <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button> -->
            </div>";
            }
            if ($pendingLeave)
            while ($row = mysqli_fetch_assoc($pendingResult)) {
                // $doc_name = $row['doc_name'];
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                Your request for leave has been sent from " . $row['start_date'] . " to" . $row['end_date'] . ".
                <p style='font-size: 13px; color:green; display: flex; justify-content: end;'>". $row['time'] ."</p>
                <!-- <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button> -->
            </div>";
            }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('#myTable').DataTable();
            });
        </script>

</body>

</html>