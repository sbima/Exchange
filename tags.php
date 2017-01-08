<?php
include("navbar.php");

if(isset($_SESSION["username"])) {
//echo "Logged in";
}
else {
echo "You have been logged out. log back in to view your profile";
header("location: index.php");
}
include("connection.php");
$username= $_SESSION["username"];
$uid=$_SESSION["userId"];
$q="SELECT COUNT(qid) cnt FROM question ";
$q1=mysqli_query($conn,$q);
$row=mysqli_fetch_row($q1);
$tagterm= $_GET['q'];
/*$rows=$row[0];
$page_rows=10;

$last=ceil($rows/$page_rows);
if($last<1)
{
    $last=1;
}
$pagenum=1;
if(isset($_GET['pn'])){
    $pagenum=preg_replace('#[^0-9]#','', $_GET['pn']);
}
if($pagenum<1)
{
    $pagenum=1;
}
else if($pagenum > $last){
    $pagenum=$last;
}
$offset =($pagenum-1) * $page_rows;*/
$query = mysqli_query($conn,"SELECT asker.uid,username, useremail,qid,tags,title,sum(vote.votes)  as votes FROM question left outer join asker on question.uid=asker.uid left outer join vote on question.qid=vote.quesid where tags LIKE '".$tagterm."%' OR '%".$tagterm."%' OR '".$tagterm."'
OR '%".$tagterm."'group by qid, title,username order by votes desc ");

/*
$textline2="Page <b> $pagenum</b> of <b> $last</b>";
$paginationCtrls='';
if($last!=1){
    if($pagenum>1){
        $previous=$pagenum-1;
        $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp';
        for($i=$pagenum-4;$i<$pagenum;$i++){
        if($i>0){
            $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?$pn='.$i.'">'.$i.'</a> &nbsp;' ;
            
        }
        }
        }
    $paginationCtrls .=''.$pagenum.' &nbsp; ';
    for($i=$pagenum+1;$i <=$last; $i++){
        $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;' ;
        if($i >=$pagenum+4) {
            break;
        }
    }
    if($pagenum !=$last){
        $next=$pagenum +1;
        $paginationCtrls .=' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> &nbsp';
    }
}
*/


function answer_count($id){
    global $conn;
$query1="SELECT COUNT(qid) as cnt FROM answer WHERE qid='$id' ";
$q=mysqli_query($conn,$query1);
$result=mysqli_fetch_assoc($q);
$count=$result['cnt'];
    return $count;
}
function vote_count($id,$type){
global $conn;
$qq="SELECT SUM(votes) as vsum from vote where quesid='$id' and vtype='$type'";
//echo $qq;
$query3=mysqli_query($conn,$qq);
$result=mysqli_fetch_assoc($query3);
$sum=$result['vsum'];
    return $sum;
}
?>

  
<!DOCTYPE html>
    <html>
        
    <body>
        <div class="container">
   
        <h2> Questions</h2>
        <?php
//echo"<p> $textline2</p>" ;
/*echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";*/
echo"<div class='table-responsive'>";
		  echo"<table class='table table-striped' >";
         while($r = mysqli_fetch_array($query)){
        echo"<tr>";
        echo"<td>";
             $u_ask=$r["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
$sc=mysqli_query($conn,$score);
$re=mysqli_fetch_array($sc);
        echo"<div class='row'>";
         echo "<div class='col-sm-1'>";
         if(vote_count($r['qid'],'q')==0)
               echo"<p id='vote'>0</p>";
            else
        echo "<p id='vote'>".vote_count($r['qid'],'q')."</p>";
        echo"<p>votes</p>";
        echo"</div>";
         echo "<div class='col-sm-1'>";
         if(answer_count($r['qid'])==0)
               echo"<p id='answer'>0</p>";
            else
        echo "<p id='answer'>".answer_count($r['qid'])."</p>";
        echo"<p>answers</p>";
        echo"</div>";
        echo "<div class='col-sm-10'>";
        echo"<a href='answer.php?q=".$r['qid']."'><h4>".$r['title']."</h4></a><br>";
        $tag_name=$r['tags'];
             $tag=explode(' ',$tag_name);
             $i=0;
             echo"<p class=rytsydcenter>Tags:";
             for($i=0;$i<=(count($tag)-1);$i++){
        echo" <a href='tags.php?q=".$tag[$i]."'>".$tag[$i]."</a>"; 
             }  
        echo"<div class='col-sm-2' style='float:right' color='red'>";
        echo"<p class=rytsydcenter> Asked by:</p>".$r['username'];?>
            <?php
              $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $r['useremail'] ) ) ) . "?d=" . urlencode( 'https://s29.postimg.org/9xm80cstj/defaultpic.png' );
              $source = "./profile_pictures/".$r['username'];
              $source = trim($source);
              if(file_exists($source))
              { 
                 ?>
                  <img width='25' height='25' alt='abc' src='./profile_pictures/<?php echo $r['username']; ?>' />
                <?php
              }
              else
              {
                 ?>
                  <img width='25' height='25' alt='abc' src='<?php echo $grav_url; ?>' / >
                <?php
              }
              
            ?>
          <?php echo" <p class=rytsydcenter> Score:".$re['user_score'];?>
        
        <?php
             echo"</div></div>";
        echo "</td></tr>";
             echo"</div>";
         }
        
       
       echo"</table>" ;
           
/*echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";*/
mysqli_close($conn);
?>
        </div>  
        </body>
</html>
