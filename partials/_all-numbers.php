<?php 
    $sql1 = "select * from `doctor`";
    $result1 = mysqli_query($con, $sql1);
    $numd = mysqli_num_rows($result1);
    // Get the current datetime
    $currentDateTime = date('Y-m-d H:i:s');
    
    // Query to count upcoming bookings
    $sqlUpcoming = "SELECT COUNT(*) as upcoming_count FROM `appointment` WHERE CONCAT(`doa`, ' ', `toa`) > '$currentDateTime'";
    $resultUpcoming = mysqli_query($con, $sqlUpcoming);
    $rowUpcoming = mysqli_fetch_assoc($resultUpcoming);
    $numUpcomingBookings = $rowUpcoming['upcoming_count'];

    $sql3 = "select * from `registration`";
    $result3 = mysqli_query($con, $sql3);
    $numr = mysqli_num_rows($result3);

     echo "<div class='container px-3 text-center'>
                <div class='row gx-5'>
                    <div class='col'>
                        <div class='custom-card'>
                            <div class='p-1'>No. of doctors: $numd</div>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='custom-card'>
                            <div class='p-1'>No. of bookings: $numUpcomingBookings</div>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='custom-card'>
                            <div class='p-1'>No. of patients: $numr</div>
                        </div>
                    </div>
                </div>
            </div>";
?>