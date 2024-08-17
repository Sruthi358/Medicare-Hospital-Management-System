<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    // Check for any past requests that no longer exist (deleted)
    $requestLeaveSql = "SELECT * FROM `leave_request` Where `status`='Pending' ORDER BY time DESC";
    $cancelledResult = mysqli_query($con, $requestLeaveSql);
    $hasCancelled = mysqli_num_rows($cancelledResult) > 0;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accept'])) {
      $doctorUsername = $_POST['username'];
      $specialityMain = $_POST['doa'];
      $name = $_POST['name'];
      $start = $_POST['start'];
      $end = $_POST['end'];
      //update the status to accept
      $sql = "UPDATE `leave_request` SET `status` = 'Accepted' WHERE `username` = '$doctorUsername' AND `doc_name`='$name' AND `start_date`='$start' AND `end_date`='$end'";
      mysqli_query($con,$sql);
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reject'])) {
    $doctorUsername = $_POST['username'];
    $specialityMain = $_POST['doa'];
    $name = $_POST['name'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    //update the status to accept
    $sql = "UPDATE `leave_request` SET `status` = 'Rejected' WHERE `username` = '$doctorUsername' AND `doc_name`='$name' AND `start_date`='$start' AND `end_date`='$end'";
    mysqli_query($con,$sql);
}

// Check for any accepted request
$acceptedLeaveSql = "SELECT * FROM `leave_request` WHERE status='Accepted' ORDER BY time DESC";
$acceptedResult = mysqli_query($con, $acceptedLeaveSql);
$acceptedLeave = mysqli_num_rows($acceptedResult) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Set schedule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/utils.css">
  <link rel="stylesheet" href="css/module-header.css">
  <link rel="stylesheet" href="css/module-rightpart-common.css">
  <link rel="stylesheet" href="css/add-update-doctor.css">
  <link rel="stylesheet" href="css/js-validation-erros.css">
</head>

<body>
  <?php include 'partials/_admin-header.php';?>
  <main>
    <div class="right">
      <div class="heading">
        <h1>Set schedule</h1>
        <br>
      </div>
      <div class="whole">
        <div class='accordion' id='accordionPanelsStayOpenExample' style='width: 800px;'>
          <?php 
              if ($hasCancelled)
                  while ($row = mysqli_fetch_assoc($cancelledResult)) {
                      $name = $row['doc_name'];
                      $sql1 = "SELECT * from `doctor` where `name` = '$name'";
                      $result1 = mysqli_query($con,$sql1);
                      $row1 = mysqli_fetch_assoc($result1);
                      $speciality = $row1['speciality'];
                  echo "
                  <div class='accordion-item'>
                    <h2 class='accordion-header'>
                      <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapseOne' aria-expanded='true' aria-controls='panelsStayOpen-collapseOne'>
                        Request from ". $row['doc_name']."
                      </button>
                    </h2>
                    <div id='panelsStayOpen-collapseOne' class='accordion-collapse collapse show'>
                      <div class='accordion-body'>
                        <strong>Reason:&nbsp;</strong> ".$row['reason']."
                        <br><br>
                        Doctor ". $row['doc_name']." who is working as  
                        ". $speciality." has requested for a leave from ". $row['start_date']." to ". $row['end_date'] ."<br><br>".$row['comments']."<br><br>
                        <!--<button type = 'submit' class='btn-xs small-button
                        btn-success mt-3' style='width: 70px; height: 33px; background-color: green;'>Accept</button>
                        <button type = 'submit' class='btn-xs small-button btn-success mt-3' style='width: 70px; height: 33px; background-color: rgb(185, 11, 11);'>Reject</button>-->
                        <form method='POST'>
                                      <input type='hidden' name='username' value='" . $row1['username'] . "'>
                                      <input type='hidden' name='doa' value='". $speciality ."'>
                                      <input type='hidden' name='name' value='". $row['doc_name'] ."'>
                                      <input type='hidden' name='start' value='". $row['start_date'] ."'>
                                      <input type='hidden' name='end' value='". $row['end_date'] ."'>
                                      <div class='button' style='display: flex; justify-content: start; align-items: start;'>
                                        <button type = 'submit' name='accept' class='btn-xs small-button
                        btn-success mt-3' style='width: 70px; height: 33px; background-color: green;'>Accept</button>
                        <button type = 'submit' name='reject' class='btn-xs small-button btn-success mt-3' style='width: 70px; height: 33px; background-color: rgb(185, 11, 11);'>Reject</button>
                                      </div>
                                  </form>
                      </div>
                    </div>
                  </div>";
             }
          ?>

          <hr>
          <hr>
          <div class="heading">
        <h1>Doctor who are on leave</h1>

        <br>
      </div>
      <?php  
        
          if ($acceptedLeave)
          while ($row = mysqli_fetch_assoc($acceptedResult)) {
              $doc_name = $row['doc_name'];
              $specialitySql = "Select * from doctor where name='$doc_name'";
              $specialityResult = mysqli_query($con,$specialitySql);
              $row1 = mysqli_fetch_assoc($specialityResult);
              echo "<div class='alert alert-light alert-dismissible fade show' role='alert'>
              ".$doc_name." working as ".$row1['speciality']." is on leave from " . $row['start_date'] . " to" . $row['end_date'] . ".
              <p style='font-size: 13px; color:green; display: flex; justify-content: end;'>". $row['time'] ."</p>
              <!-- <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button> -->
          </div>";
          }
      ?>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>