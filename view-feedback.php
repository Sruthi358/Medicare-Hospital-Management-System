<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
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

        .badge {
            display: flex;
            justify-content: end;
        }
    </style>
</head>

<body>
    <?php  include 'partials/_admin-header.php';?>
    <div class="right">
        <div class="heading">
            <h1>View feedback</h1>
        </div>
        <div class="container">
            <div class="table-responsive">
                <table id="myTable" class="table display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Patient's name</th>
                            <th scope="col">Doctor's name</th>
                            <th scope="col">Speciality</th>
                            <th scope="col">Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "select * from `feedback`";
                            $result = mysqli_query($con, $sql);
                            $snou = 0;
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<tr>
                                <td>'.$row['name'] .'</td>
                                <td>'.$row['doc_name'] .'</td>
                                    <td>'.$row['speciality'] .'</td>
                                    <td>'.$row['feedback'] .'</td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
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