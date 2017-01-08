<?php
session_start();
session_destroy();
//echo "You have been logged out...."."<a href='login.php'>Login</a>";
if(session_destroy)
{
header("location: login.php");
}
?>
