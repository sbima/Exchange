<!DOCTYPE html>
<html>
<meta charset="utf-8">
<style> /* set the CSS */

.bar { fill: steelblue; }

</style>
<?php
#session_start();
include("connection.php");
$filename = "data";
$file2="tag";
$filedate = "date";
$file3=fopen('./date','w');
$fileopen=fopen('./tag','w');
$fp = fopen('./data', 'w');
$query = mysqli_query($conn,"SELECT 
CASE WHEN score IS NULL THEN 0 ELSE score END uscore, 
asker.uid ,
asker.username,
CASE WHEN acount IS NULL THEN 0 ELSE acount END acount,
CASE WHEN qcount IS NULL THEN 0 ELSE qcount END qcount
from asker left outer join 
(SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid
left outer join (SELECT count(*) as acount, auid from answer group by auid) usr_ans on asker.uid = usr_ans.auid
left outer join (select count(*) as qcount, uid from question group by uid) usr_que on asker.uid = usr_que.uid");
$query2=mysqli_query($conn,"SELECT count(*) tagcount,tags from question group by tags");
$query3=mysqli_query($conn,"SELECT count(*), DATE_FORMAT(date,'%Y-%M') from question group by DATE_FORMAT(date,'%Y-%M')");
    
$list2=array("tagname,tagcount");
$list = array("score,id,username,acount,qcount");
$list3=array("questions,date");
foreach ($list3 as $line4)
  {
  fputcsv($file3,explode(',',$line4));
  } 
while($row3=mysqli_fetch_row($query3)){
    fputcsv($file3, $row3);
}
 foreach ($list2 as $line2)
  {
  fputcsv($fileopen,explode(',',$line2));
  } 
    
while($row2 = mysqli_fetch_array($query2)){
$tag_name=$row2['tags'];
$tag=explode(' ',$tag_name);

    for($i=0;$i<=(count($tag)-1);$i++){
        
        print $tag[$i];
        echo"\n";
        //$tagcount=$row2['tagcount'];
        //print $tagcount;
        $list3 = array("$tag[$i],$row2[tagcount]");
 foreach ($list3 as $line3)
  {
  fputcsv($fileopen,explode(',',$line3));
  } 
    }
  

   
 
 }
foreach ($list as $line)
  {
  fputcsv($fp,explode(',',$line));
  }
 while($row = mysqli_fetch_row($query)){
  fputcsv($fp, $row);
 }
    if (file_exists($filename)) {
     header("location: d.php");
 } 
    else {
     echo "The file does not exist";
 }
exit;
?>

