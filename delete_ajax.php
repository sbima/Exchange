<?php

include("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $qid=$_POST["quesid1"];
}

$query_admin= "delete from vote where quesid = $qid";

mysqli_query($conn, $query_admin);

$query_admin= "delete from answer where qid = $qid";

mysqli_query($conn, $query_admin);

$query_admin= "delete from question where qid = $qid";

mysqli_query($conn, $query_admin);

mysqli_close($conn);

?>