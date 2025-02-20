<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "fectch_and_chill";

//connection
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

//check for connection

if($conn->connect_error){
    die("Failed to connect" . $conn->connect_error);
}
?>