<?php

include("navbar.php");
if(isset($_SESSION["username"])) {
    }
else {
    header("location: index.php");
}

 include("connection.php");
$username= $_SESSION["username"];
$uid=$_SESSION["userId"];
$q="SELECT COUNT(qid) cnt FROM question where qid='$uid' ";
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
$query = mysqli_query($conn,"SELECT username,useremail,gitv,qid,title,asker.uid,tags FROM question INNER JOIN asker ON question.uid='$uid' and asker.username='$username' LIMIT $offset,$page_rows");


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
$query1="SELECT COUNT(qid) cnt FROM answer WHERE qid='$id' ";
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
}?>
<!DOCTYPE html>

<html>
    <head>
        <!--Start of Zendesk Chat Script-->
                <?php
            if($_SESSION["user_role"]!="administrator")
            {
                ?>
                <script type="text/javascript">
                window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
                d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
                _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
                $.src="https://v2.zopim.com/?4R6qwk4IPQ0PsV8UEQlVTHmfTiLFg9ER";z.t=+new Date;$.
                type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
                </script>
            <?php
            }
            ?>
            <!--End of Zendesk Chat Script-->
    </head>
    <body>   <div class="container">
    
        <h3> Questions</h3>
</div></body></html>

        <?php
echo" <div class='container'>";
echo"<p> $textline2</p>" ;
echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";
	     echo"<div class=\"table-responsive\">";
		  echo"<table class=\"table table-striped\" position=\"center\">";
         while($row = mysqli_fetch_assoc($query)){
             $u_ask=$row["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
              $sc=mysqli_query($conn,$score);
             $re=mysqli_fetch_array($sc);
        echo"<tr>";
        echo"<td>";
             echo"<div class='row'>";
         echo "<div class='col-sm-1'>";
         if(vote_count($row['qid'],'q')==0)
               echo"<p id='vote'>0</p>";
            else
        echo "<p id=''>".vote_count($row['qid'],'q')."</p>";
        echo"<p>votes</p>";
        echo"</div>";
         echo "<div class='col-sm-1'>";
         if(answer_count($row['qid'])==0)
               echo"<p id='answer'>0</p>";
            else
        echo "<p id='answer'>".answer_count($row['qid'])."</p>";
        echo"<p>answers</p>";
        echo"</div>";
        echo "<div class='col-sm-10'>";
             echo"<a href='myquestion_answer.php?q=".$row['qid']."'><h4>".$row['title']."</h4></a><br>";
           $tag_name=$row['tags'];
             $tag=explode(' ',$tag_name);
             $i=0;
             echo"<p class=rytsydcenter>Tags:";
             for($i=0;$i<=(count($tag)-1);$i++){
        echo" <a href='tags.php?q=".$tag[$i]."'>".$tag[$i]."</a>"; 
             }      
         echo"</p><div class='col-sm-2 rytsydasker' style='float:right' color='red'>";
            echo "<p class=rytsydcenter> Asked by:</p>";
            ?>
          <p> 
            <?php
              
              //$gitpic = "https://github.com/".$row1['username'].".png";
              
              if($row['gitv']==1)
              {
              
                echo "<img width='25' height='25' alt='abc' src='https://github.com/".$row['username'].".png' />";
                
              }
              else
              {
                $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $row['useremail'] ) ) ) . "?d=" . urlencode( 'https://s29.postimg.org/9xm80cstj/defaultpic.png' );
              $source = "./profile_pictures/".$row['username'];
              $source = trim($source);
              if(file_exists($source))
              { 
                 ?>
                  <img width='25' height='25' alt='abc' src='./profile_pictures/<?php echo $row['username']; ?>' />
                <?php
              }
              else
              {
                 ?>
                  <img width='25' height='25' alt='abc' src='<?php echo $grav_url; ?>' / >
                <?php
              }
              }
              ?>
          <?php
            echo" <a href='profile.php?id=".$row['uid']."'>".$row['username']."</a></p>";
            echo "<p class=rytsydcenter> Score:".$re['user_score'];
             
             ?>
        <?php
        echo"</div>";
        echo "</td></tr>";
         }
        
       
       echo"</table>" ;
    
       echo"</div>" ;
        echo"</div>";
             mysqli_close($conn);
            ?>
        
