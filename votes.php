<?php
include("connection.php");

$qid=$_POST['mydata'];
$aid=$_POST['mydata2'];
$uid=$_POST['mydata3'];
$value=$_POST['val'];;
$vote=$_POST['vote'];
$record_exits=$_POST['record'];
//echo $record_exits;
$vote_count=(int)$vote+(int)$value;
/*$query="SELECT 1 as rec_exists,votes from vote WHERE ansid='$aid' and askid='$uid'";
$s=mysqli_query($conn,$query);
$r = mysqli_fetch_array($s);*/
//echo $r['rec_exists'];
if($record_exits!=1){
$query1="INSERT INTO vote(ansid,quesid,askid,votes,vtype) VALUES ('$aid', '$qid', '$uid',$value,'a') ";
$sql=mysqli_query($conn,$query1);
//echo $query1;
}
elseif(($vote_count >= -1 && $vote_count<= 1) && $record_exits==1){
    $query2="UPDATE vote SET votes='$vote_count' WHERE ansid='$aid' and askid='$uid'";
    $sql2=mysqli_query($conn,$query2);
//echo $query2;
}
$query3="SELECT SUM(votes) as sum_vote from vote WHERE ansid='$aid' group by ansid";
$sql3=mysqli_query($conn,$query3);
$row = mysqli_fetch_array($sql3);
echo $row['sum_vote'];


//
//$query=mysqli_query($conn,"UPDATE answer SET bestanswer = '1' where qid= $qid and aid=$aid");
?>