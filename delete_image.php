<?php
include("connection.php");
//$username= $_SESSION["username"];
session_start();
if(isset($_SESSION["username"]))
{
$uname=$_SESSION["username"];
$query1=mysqli_query($conn,"SELECT * FROM asker WHERE username='$uname'");
$row1 = mysqli_fetch_assoc($query1);
unlink("./profile_pictures/".$row1['username']);
header("Location: profile.php");
}
//unlink('test.html');

?>