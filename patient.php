<?php
    session_start();
    //If not logged in
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "select name from `registration` where username = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name  = $row['name'];
    // Fetch unread notifications
    $notificationsSql = "SELECT * FROM `appointment_history` WHERE `username`='$username' AND `status`='unread'";
    $notificationsResult = mysqli_query($con, $notificationsSql);
    $hasCancelled = mysqli_num_rows($notificationsResult) > 0;
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
            /* Adjust the value as needed */
            margin-right: 20px;
            /* Adjust the value as needed */
        }

        .badge {
            display: flex;
            justify-content: end;
        }
    </style>
</head>

<body>
    <?php include 'partials/_patient-header.php'; ?>
    <div class="right">
        <div class="badge">
            <button type="button" class="btn btn-primary position-relative"
                onclick="window.location.href = 'notification.php';"> Notification
                <span
                    class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </button>
        </div>
        <hr>
        <div class="alert alert-success" role="alert">
            <h5 class="alert-heading">Welcome <b>
                    <h3>
                        <?php echo $name; ?>!
                    </h3>
                </b></h5>
            <p>Haven't any idea about doctors? no problem let's jumping to <b>doctor's</b> section. <br>
                Track your past and future appointments history.
            </p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to logout <a href="logout.php">by clicking here!</a></p>
        </div>
        <!-- to display message -->
        <?php 
        if($hasCancelled){
            while($row1 = mysqli_fetch_assoc($notificationsResult)){
                $appointmentId = $row1['id'];
                $doc_name = $row1['doc_name'];
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                Your appointment with doctor ". $row1['doc_name'] ." has been cancelled. At time ". $row1['toa']." on ". $row1['doa'] .". Please check your schedule and book another slot.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick='dismissNotification($appointmentId)'></button>
                </div>";
            }
        }
        ?>
        <?php include 'partials/_all-numbers.php'; ?>
        <div class="row">
            <h3>Your upcoming bookings</h3>
            <div class="container">
                <div class="table-responsive">
                    <table id="myTable" class="table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Speciality</th>
                                <th scope="col">Doctor's name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <br>
                            <?php
                                $sql = "select * from `appointment` where username='$username'";
                                $result = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    if(strtotime($row['doa'] . ' ' . $row['toa']) > time()) {
                                        echo '<tr>
                                            <td>'.$row['speciality'] .'</td>
                                            <td>'.$row['doc_name'] .'</td>
                                            <td>'.$row['doa'] .'</td>
                                            <td>'.$row['toa'] .'</td>
                                            <td>'.$row['reason'] .'</td>
                                        </tr>';
                                    } 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
            // "scrollX": true;
        });
    </script>
    <!-- to mark message as read -->
    <script>
        function dismissNotification(appointmentId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'mark_notification_read.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + appointmentId);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log('Notification marked as read.');
                }
            };
        }
    </script>
</body>

</html>