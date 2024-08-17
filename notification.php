<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "select name from `registration` where username = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name  = $row['name'];

    $sql1 = "select * from `doctor`";
    $result1 = mysqli_query($con, $sql1);
    $numd = mysqli_num_rows($result1);

    $sql2 = "select * from `appointment`";
    $result2 = mysqli_query($con, $sql2);
    $numb = mysqli_num_rows($result2);

    $sql3 = "select * from `registration`";
    $result3 = mysqli_query($con, $sql3);
    $numr = mysqli_num_rows($result3);

    // Check for any past appointments that no longer exist (deleted)
    $cancelledAppointmentsSql = "SELECT * FROM `appointment_history` WHERE username='$username' ORDER BY time DESC";
    $cancelledResult = mysqli_query($con, $cancelledAppointmentsSql);
    $hasCancelled = mysqli_num_rows($cancelledResult) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient-module</title>
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
    <?php
    include 'partials/_patient-header.php';
    ?>
    <div class="right">
        <?php if ($hasCancelled)
            while ($row = mysqli_fetch_assoc($cancelledResult)) {
                $doc_name = $row['doc_name'];
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                Your appointment with doctor " . $row['doc_name'] . " has been cancelled. At time " . $row['toa'] . " on " . $row['doa'] . ". Please check your schedule and book another slot.
                <p style='font-size: 13px; color:green; display: flex; justify-content: end;'>" . $row['time'] . "</p>
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