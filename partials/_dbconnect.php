<?php
    //connection to the database
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "medicare";

    //create a connection
    $con = mysqli_connect($server, $username, $password, $database);

    //die if connection was not successful
    if(!$con){
        die("connection to this database failed due to " . mysqli_connect_error());
    }
    // else{
    //     echo "success";
    // }
?>
