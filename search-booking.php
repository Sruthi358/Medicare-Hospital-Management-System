<?php
    include 'partials/_dbconnect.php';
    if(isset($_POST['query'])){
        $output = '';
        $query = "SELECT name FROM doctor WHERE name LIKE '%" .$_POST["query"]."%'";
        $result = mysqli_query($con, $query);
        $output = '<ul class="list-unstyled">';
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $output .= '<li>'.$row["name"].'</li>';
            }
        }
        else{
            $output .= '<li>Doctor not found</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
?>