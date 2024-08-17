<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "select name from `doctor` where username = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name  = $row['name'];
    // Fetch unread and accepted notifications 
    $notificationsSql = "SELECT * FROM `leave_request` WHERE `username`='$username' AND `status`='Accepted' AND `status_read` = 'unread'";
    $notificationsResult = mysqli_query($con, $notificationsSql);
    $accepted = mysqli_num_rows($notificationsResult) > 0;
    // Fetch unread and rejected notifications 
    $notificationsSql = "SELECT * FROM `leave_request` WHERE `username`='$username' AND `status`='Rejected' AND `status_read` = 'unread'";
    $rejectedResult = mysqli_query($con, $notificationsSql);
    $hasCancelled = mysqli_num_rows($rejectedResult) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor-module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
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
        <div class="badge">
            <button type="button" class="btn btn-primary position-relative"
                onclick="window.location.href = 'notification_doctor.php';"> Notification
                <!-- <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"> -->
                <span class="visually-hidden">New alerts</span>
                </span>
            </button>
        </div>
        <hr>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Welcome
                <?php echo $name; ?>!
            </h4>
            <p>Thank you for joining withs us. We are always trying to get you a complete service.
                <br>
                You can view your daily schedule.
            </p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to logout <a href="logout.php">by clicking here!</a></p>
        </div>
        <?php 
            if($accepted){
                while($row1 = mysqli_fetch_assoc($notificationsResult)){
                    $appointmentId = $row1['sno'];
                    $doc_name = $row1['doc_name'];
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    Your Request for the leave from ".$row1['start_date'] ." to ". $row1['end_date'] ." has been accepted.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick='dismissNotification($appointmentId)'></button>
            </div>";
                }
            }
            if($hasCancelled){
                while($row1 = mysqli_fetch_assoc($rejectedResult)){
                    $appointmentId = $row1['sno'];
                    $doc_name = $row1['doc_name'];
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    Your Request for the leave from ".$row1['start_date'] ." to ". $row1['end_date'] ." has been cancelled.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick='dismissNotification($appointmentId)'></button>
            </div>";
                }
            }
        ?>
        <?php include 'partials/_all-numbers.php'; ?>
        <div class="row">
            <h3>Upcoming appointments</h3>
            <div class="container">
                <div class="table-responsive">
                    <table id="myTable" class="table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <br>
                            <?php
                                //to fetch the appointments for particular doctor
                                $sql = "select * from `appointment` where `doc_name` = '$name'";
                                $result = mysqli_query($con, $sql);
                                
                                while($row = mysqli_fetch_assoc($result)){
                                    $username1 = $row['username'];
                                    $sql1 = "select * from `registration` where username='$username1'";
                                    $result1 = mysqli_query($con, $sql1);
                                    $row1=  mysqli_fetch_assoc($result1);
                                    if(strtotime($row['doa'] . ' ' . $row['toa']) > time()) {
                                        echo '<tr>
                                            <td>'.$row1['name'] .'</td>
                                            <!--<td>'.$row['speciality'] .'</td>-->
                                            <!--<td>'.$row['doc_name'] .'</td>-->
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