<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $delete = false;
    include 'partials/_dbconnect.php';
    if(isset($_GET['delete'])){
        $username = $_GET['delete'];
        $sql = "DELETE FROM `doctor` WHERE `username` = '$username'";
        $result = mysqli_query($con, $sql);
        $delete = true;
    }        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View doctor</title>
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
    <?php include 'partials/_admin-header.php';?>
    <main>
        <div class="right">
            <?php
                if($delete){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success! </strong> Deleted successfully <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            ?>
            <div class="heading">
                <h1>View doctors</h1>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table id="myTable" class="table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Sno</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">DOB</th>
                                <th scope="col">Phone number</th>
                                <th scope="col">Languages</th>
                                <th scope="col">Qualification</th>
                                <th scope="col">Speciality</th>
                                <th scope="col">Address</th>
                                <th scope="col">Username</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "select * from `doctor`";
                                $result = mysqli_query($con, $sql);
                                $snou = 0;
                                while($row = mysqli_fetch_assoc($result)){
                                    $snou = $snou + 1;
                                    echo '<tr>
                                    <td scope="row">'.$snou .'</td>
                                    <td>'.$row['name'] .'</td>
                                    <td><img src= "'.$row['photo'] .'" height="100px"></td>
                                    <td>'.$row['email'] .'</td>
                                    <td>'.$row['dob'] .'</td>
                                    <td>'.$row['phone'] .'</td>
                                    <td>'.$row['languages'] .'</td>
                                    <td>'.$row['qualification'] .'</td>
                                    <td>'.$row['speciality'] .'</td>
                                    <td>'.$row['area'] .','.$row['city'] .'<br>'.$row['state'] .','.$row['code'] .'</td>
                                    <td>'.$row['username'] .'</td>
                                    <td><button id="d'.$row['username'].'" class="delete btn btn-sm btn-primary">Delete</button></td>
                                </tr>';
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
    <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                username = e.target.id.substr(1,)
                if (confirm("Want to delete it!")) {
                    console.log("yes");
                    window.location = `/rtp-doctor-appointment-booking-system/view-doctor.php?delete=${username}`;
                }
                else {
                    console.log("no");
                }
            })
        })
    </script>
</body>

</html>