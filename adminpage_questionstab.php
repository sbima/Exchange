<?php 

if(isset($_SESSION["username"])) {
//echo "Logged in";
}
else {
echo "You have been logged out. log back in to view your profile";
header("location: index.php");
}

$username= $_SESSION["username"];
$uid=$_SESSION["userId"];
$q="SELECT COUNT(qid) cnt FROM question ";
$q1=mysqli_query($conn,$q);
$row=mysqli_fetch_row($q1);
$rows=$row[0];
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
$offset =($pagenum-1) * $page_rows;
$query = mysqli_query($conn,"SELECT username,useremail,gitv,qid,asker.uid, title,sum(vote.votes) as votes FROM question left outer join asker on question.uid=asker.uid left outer join vote on question.qid=vote.quesid group by username,qid, title order by votes desc LIMIT $offset,$page_rows");

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


function answer_count($id){
    global $conn;
$query1="SELECT COUNT(qid) as cnt FROM answer WHERE qid='.$id.' ";
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

<?php
echo"<p> $textline2</p>" ;
echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";
echo"<div class='table-responsive'>";
		  echo"<table class='table table-striped' >";
         while($r = mysqli_fetch_array($query)){
              $u_ask=$r["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
$sc=mysqli_query($conn,$score);
$re=mysqli_fetch_array($sc);
        echo"<tr>";
        echo"<td>";
        echo"<div class='row'>";
         echo "<div class='col-sm-1'>";
         if(vote_count($r['qid'],'q')==0)
               echo"<p id='vote'>0</p>";
            else
        echo "<p id=''>".vote_count($r['qid'],'q')."</p>";
        echo"<p>votes</p>";
        echo"</div>";
         echo "<div class='col-sm-1'>";
         if(answer_count($r['qid'])==0)
               echo"<p id='answer'>0</p>";
            else
        echo "<p id='answer'>".answer_count($r['qid'])."</p>";
        echo"<p>answers</p>";
        echo"</div>";
        echo "<div class='col-sm-8'>";
        echo"<a href='admin_answer.php?q=".$r['qid']."'><h4>".$r['title']."</h4></a><br>";
        echo"</div>";
         echo"</p><div class='col-sm-2 rytsydasker' style='float:right' color='red'>";
            echo "<p class=rytsydcenter> Asked by:</p>";
            ?>
          <p> 
             <?php
              
              //$gitpic = "https://github.com/".$row1['username'].".png";
              
              if($r['gitv']==1)
              {
              
                echo "<img width='25' height='25' alt='abc' src='https://github.com/".$r['username'].".png' />";
                
              }
              else
              {
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
              }
            echo" <a href='profile.php?id=".$r['uid']."'>".$r['username']."</a></p>";
            echo "<p class=rytsydcenter> Score:".$re['user_score'];
             echo"</div>";
        echo "</td></tr>";
?>

        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 

        <!-- include summernote css/js-->
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

        <script src="edit_save.js"></script>
<!--<tr>
<td><div class='row'>
        <div class='col-sm-6'></div>
        <div class='col-sm-4'>
            <button type="button" id="edit" onclick="edit()" class="btn btn-info">Edit</button> &nbsp;
            <button id="save" class="btn btn-primary" onclick="save()" type="button">Save</button> &nbsp;
            <button type="button" class="btn btn-danger">Delete</button> &nbsp;

        </div>
        <div class='col-sm-2'>
            <label class="switch">
                <input type="checkbox" checked>
                <div class="slider round"></div>
            </label>
        </div>
    </div>
</td>
</tr>-->
             
<?php             
             echo"</div>";
         }
        
       
       echo"</table>" ;
        echo "</div>";
           
echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";
mysqli_close($conn);
?>