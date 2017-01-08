<?php

include("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $obj = $_POST['myData'];
    $qid = $obj["q_id"];
    $delstate = $obj["delstate"]
        
        }

$query_admin= "UPDATE question SET delstate='$delstate' where qid=$qid";

$query_result = mysqli_query($conn, $query_admin);


mysqli_close($conn);

?>