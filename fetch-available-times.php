<?php
// Include database connection
include 'partials/_dbconnect.php';
// Retrieve doctor name and date of appointment from POST request
$docName = $_POST['docName'];
$doa = $_POST['doa'];
// Query to fetch booked appointment times for the selected doctor and date
$sql = "SELECT toa FROM appointment WHERE doc_name = '$docName' AND doa = '$doa'";
$result = mysqli_query($con, $sql);
// Fetch booked appointment times
$bookedTimes = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookedTimes[] = $row['toa'];
    }
}
// Fetch the doctor's leave period
$leaveSql = "SELECT * FROM leave_request WHERE doc_name='$docName' AND status='Accepted' AND '$doa' BETWEEN start_date AND end_date";
$leaveResult = mysqli_query($con, $leaveSql);
$onLeave = mysqli_num_rows($leaveResult) > 0;
// Define array of all possible appointment times
$allTimes = [
    '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', 
    '12:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM'
];
// Generate HTML options for the select dropdown
$options = '<option value="#">Select</option>';
foreach ($allTimes as $time) {
    if ($onLeave) {
        // If the doctor is on leave, disable all options and color them red
        $options .= "<option value='$time' disabled style='color: red;'>$time</option>";
    } else {
        // Check if the time is booked
        $disabled = in_array($time, $bookedTimes) ? 'disabled' : '';
        $style = in_array($time, $bookedTimes) ? 'style="color: red;"' : '';
        $options .= "<option value='$time' $disabled $style>$time</option>";
    }
}
echo $options;
// Close database connection
mysqli_close($con);
?>
