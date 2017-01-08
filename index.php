
<!DOCTYPE html>
<html>
  <head>
    <style>
      .carousel-inner > .item > img,
      .carousel-inner > .item > a > img {
        display: block;
        max-width: 100%;
        height: 300px !important;
      }
      .carousel-control {
        &.left, &.right {
          background-image: none;
          @include reset-filter();
        }
      }
    </style>
    <title>EXchange
    </title>
    <link href="site.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
    </script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
    </script>
  </head>
    
  <body>
    <?php  
include("connection.php");
$query=mysqli_query($conn,"SELECT username, useremail,gitv,asker.uid, qid, title, sum(votes) v from vote,question,asker WHERE vtype = 'q' and quesid=qid and question.uid=asker.uid GROUP by quesid ORDER BY v desc limit 5");
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
} 
?>
    <br> <div class="container">
    <br><div class="row">
             <div class="col-sm-6">
   
                 <img class="img-responsive" src="images/exchange.PNG " style=width:400px;height:100px alt= "image" ></div><br>
      <br>

      <div id="menu"><div class="col-sm-6">
          
        <nav id="nav01">
          <ul id='menu1'>
            <li>
              <a href='index.php'>Home
              </a>
            </li>
            <li>
              <a href='registerrr.php'>Sign up
              </a>
            </li>
            <li>
              <a href='login.php'>Log in
              </a>
            </li>
              <li>
              <a href='help.html'> Help
              </a>
            </li>
          </ul>
        </nav>
         </div></div>
      <br>
      <br>
      <br>
      <br>
      
        <h3> &nbsp; &nbsp; &nbsp; &nbsp;Questions</h3></div>
        
      <div class="container">
	     <div class="table-responsive">
		  <table class="table table-striped" >
        <?php 
        while($row = mysqli_fetch_array($query)){
            $u_ask=$row["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
            $sc=mysqli_query($conn,$score);
$re=mysqli_fetch_array($sc);
        echo" <tr> ";
        echo" <td> ";
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
        echo"<h4>".$row['title']."</h4></a><br>";
        echo"<div class='col-sm-2' style='float:right' color='red'>";
            echo "<p class=rytsydcenter> Asked by: </p>";
             ?>
              
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
            echo" <a href='profile.php?id=".$row['uid']."'>".$row['username']."</a></p>";
            echo "<p class=rytsydcenter> Score:".$re['user_score'];
              ?>
              
        <?php
            
        echo"</div>";
        echo "</td></tr>";
             echo"</div>";
         }
        
       
       echo"</table>" ;
      echo"</div>" ;
mysqli_close($conn);
?>
      <center>
        <footer id="foot01">
        </footer>
      </center>
              </div></div></div></div>
    <script src="footer.js">
    </script> 
  </body
    </html>
