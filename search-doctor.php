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
    <title>Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <style>
        /* Hide the data table */
        #doctorTable_wrapper {
            display: none;
        }

        .card-container {
            margin-top: 1rem;
        }
    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
    <?php include 'partials/_patient-header.php'; ?>
    <div class="right">
        <div class="heading">
            <h1>Search doctor</h1>
        </div>
        <form class="d-flex" role="search" id="searchForm">
            <input class="form-control me-2 w-6" type="search" placeholder="Search" aria-label="Search"
                id="searchInput">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
        <div class="row card-container" id="doctorList">
            <!-- Cards will be rendered here -->
        </div>
        <!-- Hidden table for DataTables -->
        <table id="doctorTable" class="display" style="width:100%; display:none;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Speciality</th>
                    <th>Languages</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM doctor";
                    $result = mysqli_query($con, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['speciality'].'</td>
                            <td>'.$row['languages'].'</td>
                            <td>'.$row['photo'].'</td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            var table = $('#doctorTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "lengthChange": false
            });

            function renderCards(data) {
                var cardHtml = '';
                data.each(function (value) {
                    cardHtml += '<div class="col-md-4 my-4">' +
                        '<div class="card" style="width: 18rem;">' +
                        '<img src="' + value[3] + '" class="card-img-top" alt="..." height = "270px">' +
                        '<div class="card-body lh-1">' +
                        '<h5 class="card-title" style="font-size:20px; color:grey;">' + value[0] + '</h5>' +
                        '<p class="card-text" style="font-size:13px;">' + value[1] + '</p>' +
                        '<p class="card-text" style="font-size:13px;">' + value[2] + '</p>' +
                        '<p class="card-text" style="font-size:12px;">MON-SAT 9:30 AM - 5:30 PM</p>' +
                        '<a href="book-appointment.php?name=' + encodeURIComponent(value[0]) + '&speciality=' + encodeURIComponent(value[1]) + '" class="btn btn-primary" style="font-size:13px;">Book appointment</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });
                $('#doctorList').html(cardHtml);
            }

            renderCards(table.rows().data());

            $('#searchForm').on('submit', function (e) {
                e.preventDefault();
                table.search($('#searchInput').val()).draw();
                renderCards(table.rows({ search: 'applied' }).data());
            });

            // Add event listener for input event on search input field
            $('#searchInput').on('input', function () {
                // Check if the search input field is empty
                if ($(this).val() === '') {
                    // Clear the search and redraw the table to reset the search
                    table.search('').draw();
                    // Render all cards again
                    renderCards(table.rows().data());
                }
            });

            $('#doctorTable').on('draw.dt', function () {
                renderCards(table.rows({ search: 'applied' }).data());
            });
        });

    </script>
</body>

</html>