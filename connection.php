<?php
define("DB_SERVER","localhost");
define("DB_USER","admin");
define("DB_PASSWORD","M0n@rch$");
define("DB_NAME","stackoverflow");
// Create connection
$conn =  mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (mysqli_connect_error()) {
die("Connection failed: " . mysqli_connect_error);
} 
//mysqli_close($conn)
?>
