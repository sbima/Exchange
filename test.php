<?php

include("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $obj = $_POST['myData'];
    
    $qid = $obj["q_id"];
    
    $check = $_POST['param'];
       
}
if ($check == "freeze"){
	$state = $obj["state"];
	$query_admin= "UPDATE question SET state='$state' where qid=$qid";
    $query_result = mysqli_query($conn, $query_admin);
  }
if ($check == "del"){
	$delstate = $obj["state"];
	$query_admin= "UPDATE question SET delstate='$delstate' where qid=$qid";
    $query_result = mysqli_query($conn, $query_admin);
  }



mysqli_close($conn);

?>