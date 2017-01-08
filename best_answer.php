<?php
include("connection.php");
$qid=$_POST['mydata'];
$aid=$_POST['mydata2'];
$color=$_POST['mydata3';]
if(!$color=="#46d246"){
$query1=mysqli_query($conn,"UPDATE answer SET bestanswer = '0' where qid= $qid ");
}

$query=mysqli_query($conn,"UPDATE answer SET bestanswer = '1' where qid= $qid and aid=$aid");
?>
