<?php
include("connection.php");

$qid=$_POST['mydata'];
$uid=$_POST['mydata3'];
$value=$_POST['val'];;
$vote=$_POST['vote'];
$record_exits=$_POST['record'];
$vote_count=(int)$vote+(int)$value;
$query="select count(votes) as v from vote where quesid='$qid' and askid='$uid' and vtype='q'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
//echo $record_exits;
if($row['v']==0){
$query1="INSERT INTO vote(quesid,askid,votes,vtype) VALUES ('$qid','$uid',$value,'q') ";
$sql=mysqli_query($conn,$query1);
//echo $query1;
}
elseif(($vote_count >= -1 && $vote_count<= 1) && $row['v']!=0 ){
    $query2="UPDATE vote SET votes='$vote_count' WHERE quesid='$qid' and askid='$uid' and vtype='q'";
    $sql=mysqli_query($conn,$query2);
}
/*if($query1){
    echo"query 1";
}
else{
    echo"query1 not executed";
}

if($query2){
    echo"query 2";
}
else{
    echo"query2 not executed";
}*/
//echo $query2;


$query3="SELECT votes as sum_vote from vote WHERE quesid='$qid' and vtype='q' and askid='$uid'";
$sql3=mysqli_query($conn,$query3);
$row = mysqli_fetch_array($sql3);
/*if($sql3){
    echo"query 3";
}
else{
    echo"query not executed";
}*/
$query4="SELECT SUM(votes) as sum_vote from vote WHERE quesid='$qid' and vtype='q' group by quesid";
$sql4=mysqli_query($conn,$query4);
$row1 = mysqli_fetch_array($sql4);

print_r(json_encode( ['vote' => $row['sum_vote'],'sumvote' => $row1['sum_vote']]));
?>