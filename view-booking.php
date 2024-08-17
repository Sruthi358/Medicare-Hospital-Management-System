<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $delete = false;
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; //gets patient username
    if(isset($_GET['delete']) && isset($_GET['speciality']) && isset($_GET['doc_name']) && isset($_GET['doa']) && isset($_GET['toa'])){
        $username = $_GET['delete'];
        $speciality = $_GET['speciality'];
        $docName = $_GET['doc_name'];
        $doa = $_GET['doa'];
        $toa = $_GET['toa'];
         // Use parameterized query to prevent SQL injection
        $stmt = $con->prepare("DELETE FROM `appointment` WHERE `username` = ? AND `speciality` = ? AND `doc_name` = ? AND `doa` = ? AND `toa` = ?");
        $stmt->bind_param("sssss", $username, $speciality, $docName, $doa, $toa);
        if ($stmt->execute()) {
            $delete = true;
        }
        $stmt->close(); // Use parameterized query to prevent SQL injection
        $stmt = $con->prepare("DELETE FROM `appointment` WHERE `username` = ? AND `speciality` = ? AND `doc_name` = ? AND `doa` = ? AND `toa` = ?");
        $stmt->bind_param("sssss", $username, $speciality, $docName, $doa, $toa);
        if ($stmt->execute()) {
            $delete = true;
        }
        $stmt->close();
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient-module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/view-patient-doctor.css">
</head>

<body>
    <?php include 'partials/_patient-header.php';?>
    <div class="right">
        <?php
            if($delete){
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success! </strong> Cancelled successfully <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
        ?>
        <div class="heading">
            <h1>View booking</h1>
        </div>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                            <td><button 
                                            id="d'.$row['username'].'"
                                            class="delete btn btn-sm btn-primary"
                                            data-speciality="'.$row['speciality'].'"
                                            data-doc_name="'.$row['doc_name'].'"
                                            data-doa="'.$row['doa'].'"
                                            data-toa="'.$row['toa'].'">
                                            Cancel
                                        </button></td>
                                        </tr>';
                                    } else {
                                        // Display without the cancel button for past appointments
                                        echo '<tr>
                                            <td>'.$row['speciality'] .'</td>
                                            <td>'.$row['doc_name'] .'</td>
                                            <td>'.$row['doa'] .'</td>
                                            <td>'.$row['toa'] .'</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "order": [[2, 'desc']], // Sort by the third column (Date) in ascending order
                "columnDefs": [
                    { "type": "date", "targets": 2 } // Define the date type for the third column
                ]
            });
        });
    </script>
    <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                const username = e.target.id.substr(1);
                const speciality = e.target.getAttribute('data-speciality');
                const docName = e.target.getAttribute('data-doc_name');
                const doa = e.target.getAttribute('data-doa');
                const toa = e.target.getAttribute('data-toa');

                if (confirm("Want to cancel it!")) {
                    window.location = `/rtp-doctor-appointment-booking-system/view-booking.php?delete=${username}&speciality=${encodeURIComponent(speciality)}&doc_name=${encodeURIComponent(docName)}&doa=${encodeURIComponent(doa)}&toa=${encodeURIComponent(toa)}`;
                }
            });
        });
    </script>

</body>

</html>