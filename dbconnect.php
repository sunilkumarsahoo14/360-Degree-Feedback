<?php
$HOST = "localhost:3307";
$USERNAME = "root";
$PASSWORD = "";
$DB_NAME = "feedback";

$conn = new mysqli($HOST, $USERNAME, $PASSWORD, $DB_NAME);

if($conn->connect_error){
    die($conn->connect_error);
}
// else{
//     echo "Database Connected"; 
// }
?>