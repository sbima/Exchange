<?php
include("navbar.php");

if(isset($_SESSION["username"])) {
//echo "Logged in";
}
else{
    //echo "<center><h3>You have been logged out. log back in to view your profile</h3></center>";
    
    header("location: index.php");
}

include("connection.php");
if(isset($_SESSION["username"]))
{
    $username= $_SESSION["username"];
}
if(isset($_SESSION["userId"]))
{
    $uid=$_SESSION["userId"];
}

//$useremail=$_SESSION["useremail"];
$query = mysqli_query($conn,"SELECT username,gitv, useremail, asker.uid, qid, title,tags, sum(votes) v from vote,question,asker WHERE vtype = 'q' and quesid=qid and question.uid=asker.uid GROUP by quesid ORDER BY v desc limit 5");
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
 $query3=mysqli_query($conn,$qq);
 $result=mysqli_fetch_assoc($query3);
 $sum=$result['vsum'];
     return $sum;
 }
?>

  
<!DOCTYPE html>
    <html>
        <head>
            <!--Start of Zendesk Chat Script-->
            <?php
            if(isset($_SESSION["user_role"]))
            {
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
            }
            ?>
            <!--End of Zendesk Chat Script-->
        </head>
    <body>
        <div class="container">
   
        <h3> Questions</h3>
        <?php
	     echo"<div class=\"table-responsive\">";
		  echo"<table class=\"table table-striped\" position=\"center\">";
  
        while($row = mysqli_fetch_array($query)){
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
         echo "<p>".vote_count($row['qid'],'q')."</p>";
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
         echo"<a href='answer.php?q=".$row['qid']."'><h4>".$row['title']."</h4></a><br>";
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
             
             
            
        echo"</div>";
        echo "</td></tr>";
             echo"</div>";
         }
        
       
       echo"</table>" ;
          echo"</div>";  

mysqli_close($conn);
?>
