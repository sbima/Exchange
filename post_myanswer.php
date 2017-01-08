<?php
session_start();
include("connection.php");
function check($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data=mysqli_real_escape_string($conn, $data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
$answer=check($conn,$_POST["textbox"]);
}
$userid=$_SESSION["userId"];
$qid=$_SESSION["qid"];
var_dump($_SESSION);
$q= " INSERT INTO answer (answers,auid,qid) VALUES ('$answer','$userid', '$qid') ";
$query = mysqli_query($conn, $q);
if ($query ==1 ) {
header("Location: myquestion_answer.php?q=$qid");
echo" Answer Posted";
}
mysqli_close($conn);
?>
