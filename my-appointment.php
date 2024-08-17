<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    //to retrieve the name of the doctor from the doctor table
    $existsSql = "select name from doctor where username='$username'";
    $result = mysqli_query($con, $existsSql);
    if ($result && mysqli_num_rows($result) > 0){
        $row1 = mysqli_fetch_assoc($result);
        $doctorName = $row1['name'];
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_appointment'])) {
        $patientUsername = $_POST['username'];
        $appointmentDate = $_POST['doa'];
        $appointmentTime = $_POST['toa'];
        // Fetch appointment details before deleting
        $fetchSql = "SELECT * FROM `appointment` WHERE `username`='$patientUsername' AND `doc_name`='$doctorName' AND `doa`='$appointmentDate' AND `toa`='$appointmentTime'";
        $appointment = mysqli_fetch_assoc(mysqli_query($con, $fetchSql));
        // Insert into appointment_history
        $historySql = "INSERT INTO `appointment_history` (`username`, `doc_name`, `doa`, `toa`, `speciality`, `reason`,`status`) VALUES ('{$appointment['username']}', '{$appointment['doc_name']}', '{$appointment['doa']}', '{$appointment['toa']}', '{$appointment['speciality']}', '{$appointment['reason']}','unread')";
        mysqli_query($con, $historySql);
        // Delete appointment
        $deleteSql = "DELETE FROM `appointment` WHERE `username`='$patientUsername' AND `doc_name`='$doctorName' AND `doa`='$appointmentDate' AND `toa`='$appointmentTime'";
        mysqli_query($con, $deleteSql);
        echo "<script>alert('Appointment has been cancelled.');</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/view-patient-doctor.css">
</head>

<body>
    <?php include 'partials/_doctor-header.php';?>
    <main>
        <div class="right">
            <div class="heading">
                <h1>My Appointments</h1>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table id="myTable" class="table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Type</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                               $sql = "SELECT r.name, a.username, a.doa, a.toa, a.type, a.reason 
                               FROM `registration` AS r, `appointment` AS a 
                               WHERE r.username = a.username AND doc_name = '$doctorName'";
                                $result = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    if(strtotime($row['doa'] . ' ' . $row['toa']) > time()){
                                        echo '<tr>
                                            <td>'.$row['name'] .'</td>
                                            <td>'.$row['doa'] .'</td>
                                            <td>'.$row['toa'] .'</td>
                                            <td>'.$row['type'] .'</td>
                                            <td>'.$row['reason'] .'</td>
                                            <td>
                                                <form method="POST">
                                                    <input type="hidden" name="username" value="' . $row['username'] . '">
                                                    <input type="hidden" name="doa" value="' . $row['doa'] . '">
                                                    <input type="hidden" name="toa" value="' . $row['toa'] . '">
                                                    <button type="submit" name="cancel_appointment" class="btn btn-sm btn-primary">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>';
                                    }
                                    else{
                                        // Display without the cancel button for past appointments
                                        echo '<tr>
                                    <td>'.$row['name'] .'</td>
                                    <td>'.$row['doa'] .'</td>
                                    <td>'.$row['toa'] .'</td>
                                    <td>'.$row['type'] .'</td>
                                    <td>'.$row['reason'] .'</td>
                                    <td></td>
                                </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>