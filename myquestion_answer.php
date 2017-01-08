<?php
include("navbar.php");
if(isset($_SESSION["username"])) {
    }
else {
    header("location: index.php");
}
include("connection.php");
   
 $qid=$_GET['q'];
 $_SESSION["qid"] = $qid;
$uname=$_SESSION["username"];
$userid=$_SESSION["userId"];
$q="SELECT COUNT(aid) cnt FROM answer where qid='$qid' ";
$q1=mysqli_query($conn,$q);
$row=mysqli_fetch_row($q1);
$rows=$row[0];
$page_rows=4;
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
$query2= mysqli_query($conn,"select username,asker.uid,useremail,gitv,aid, answers,sum(vote.votes) AS v,bestanswer FROM asker left OUTER join answer on asker.uid=answer.auid left outer join (SELECT * FROM vote WHERE vtype = 'a') vote on answer.aid = vote.ansid where answer.qid ='$qid' GROUP by answer.aid ORDER BY `answer`.`bestanswer` DESC LIMIT $offset,$page_rows");

$textline2="Page <b> $pagenum</b> of <b> $last</b>";
$paginationCtrls='';
if($last!=1){
    if($pagenum>1){
        $previous=$pagenum-1;
        $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp';
        for($i=$pagenum-4;$i<$pagenum;$i++){
        if($i>0){
            $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?$pn='.$i.' & q='.$qid.'">'.$i.'</a> &nbsp;' ;
            
        }
        }
        }
    $paginationCtrls .=''.$pagenum.' &nbsp; ';
    for($i=$pagenum+1;$i <=$last; $i++){
        $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'& q='.$qid.'">'.$i.'</a> &nbsp;' ;
        if($i >=$pagenum+4) {
            break;
        }
    }
    if($pagenum !=$last){
        $next=$pagenum +1;
        $paginationCtrls .=' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> &nbsp';
    }
    }
$query = mysqli_query($conn,"SELECT username,asker.uid,useremail,gitv,qid,title,tags,content FROM question INNER JOIN asker ON question.uid=asker.uid WHERE qid='$qid' ");

$freeze=mysqli_query($conn,"SELECT * from question where qid='$qid'");
$free_result=mysqli_fetch_array($freeze);
$f = $free_result;
if ($f['state']=='FALSE'){
    ?>
<center><h3><font color=red>Question Freezed</font></h3></center>
<?php
}

$query1=mysqli_query($conn,"SELECT COUNT(qid) cnt FROM answer WHERE qid='$qid' ");
/*$query2=mysqli_query($conn,"select username, aid, answers,sum(vote.votes) AS v,bestanswer FROM asker left OUTER join answer on asker.uid=answer.auid left outer join (SELECT * FROM vote WHERE vtype = 'a') vote on answer.aid = vote.ansid where answer.qid ='$qid' GROUP by answer.aid ORDER BY `answer`.`bestanswer` DESC");*/
function vote_count($id,$type){
global $conn;
$qq="SELECT SUM(votes) as vsum from vote where ansid='$id' and vtype='$type'";
//echo $qq;
$query3=mysqli_query($conn,$qq);
$result=mysqli_fetch_assoc($query3);
$sum=$result['vsum'];
    return $sum;
}
$row1 = mysqli_fetch_array($query1);
?>
<script>
function select_tick(id){
   
    var qid = <?php echo $qid ?>;
    
        $.ajax({
        url: 'best_answer.php',
        type: 'post',
        data: {mydata:qid,mydata2:id},
        success: function(data) {
        $('.fa.fa-check.fa-2x').css("color", "grey");
        document.getElementById(id).style.color = "#46d246";
        },
        error: function(xhr, desc, err) {
          console.log(xhr);
          console.log("Details: " + desc + "\nError:" + err);
        }
      }); // end ajax call
}
    
function voteup(id){
   //alert("here");
    var names =$(id).siblings();
    console.log(names);
    var aid =names[0].value;
    //alert(aid);
    var uid =names[1].value;
    var vote=$(names[3]).html();
    var value;
    var record_exits=names[2].value;
    if($(id).hasClass('fa-thumbs-o-up')){
       
        value=1;
    }
    else {
       
        value=-1;
    }
   
    var qid = <?php echo $qid ?>;
    //alert(vote_count);
    
        $.ajax({
        url: 'votes.php',
        type: 'post',
        data: {mydata:qid,mydata2:aid,mydata3:uid,val:value,vote:vote,record:record_exits},
        success: function(data)
            {
                //alert("Ajax"+data);
             vote_value=data;
             names[3].innerHTML = vote_value;
             names[2].value = 1;
             //$("#"+names[2].id).html("I m here");
             //alert(names[2].id);
                
            },
            
        error: function(xhr, desc, err) {
          console.log(xhr);      
          console.log("Details: " + desc + "\nError:" + err);
        }
        }); 
               }
                
      // end ajax call
function vote_ques(id){
  
    var names =$(id).siblings();
    
    var qid =names[1].value;
    
    var uid =names[2].value;
    var vote=$(names[0]).html();
    var record_exits=names[3].value;
    if($(id).hasClass('fa-thumbs-o-up')){
        value=1;
    }
    else {
       
        value=-1;
    }
   
    var qid = <?php echo $qid ?>;
        $.ajax({
        url: 'question_vote.php',
        type: 'post',
        data: {mydata:qid,mydata3:uid,val:value,vote:vote,record:record_exits},
        success: function(data)
            {
                
             vote_value=data;
            
             names[0].innerHTML = vote_value;
             names[3].value = 1;
            
                
            },
            
        error: function(xhr, desc, err) {
          console.log(xhr);      
          console.log("Details: " + desc + "\nError:" + err);
        }
        }); 
               }
    
</script>

	     <?php
         
               
   
    echo"<div class='container'>";
	     echo"<div class=\"table-responsive\">";
		  echo"<table class=\"table table-striped\" position=\"center\">";
         while($row = mysqli_fetch_array($query)){
             $u_ask=$row["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
            $sc=mysqli_query($conn,$score);
             $re=mysqli_fetch_array($sc);
             $b = stripslashes($row['content']);
            $content=htmlspecialchars_decode($b);
        echo"<tr>";
          $query4=mysqli_query($conn,"SELECT 1 as record_exists,votes from vote WHERE quesid=".$row['qid']." and askid='$userid' and vtype='q'");
    $row4=mysqli_fetch_array($query4);
        echo"<td>";
             if(isset($_SESSION["username"] )){
        echo"<div class='row'>";
        echo"<div id='ques'>";
        if(vote_count($row['qid'],'q')==0)
               echo"<div class='col-sm-1'><p id='vote'>0</p>";
            else
        echo "<p id='vote'>".vote_count($row['qid'],'q')."</p>";
        echo"<input type='hidden' name='qid' value= ".$row['qid'].">";
        echo"<input type='hidden' name='userid' value= '$userid'>";          
        echo"<input type='hidden' name='record' value= ".$row4['record_exists'].">";
        echo"<i class='fa fa-thumbs-o-up' aria-hidden='true' id='up'onclick='vote_ques(this)'></i><br><br>";
            
           echo"<i class='fa fa-thumbs-o-down' aria-hidden='true' id='down' onclick='vote_ques(this)'></i><br><br></div>";}
               echo"<h4><strong>".$row['title']."<strong></h4></td></tr>";
        echo"<td><p>".$content."</p><br></div>";
             $tag_name=$row['tags'];
             $tag=explode(' ',$tag_name);
             $i=0;
             echo"<p class=rytsydcenter>Tags:";
             for($i=0;$i<=(count($tag)-1);$i++){
        echo" <a href='tags.php?q=".$tag[$i]."'>".$tag[$i]."</a>"; 
             }  
            echo"<div class='col-sm-2' style='float:right' color='red'>";
                echo"<p class=rytsydcenter> Asked by: </p>";
             
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
            echo"</div>";
       echo "</td></tr>";
         }
        echo"<tr>";
        echo"<td><span style='font-weight: bold'><p>".$row1['cnt']." Answers"."</p></span></td></tr>";
        echo"<tr>";
       echo"<p> $textline2</p>" ;
echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";
       // echo $userid;
        while($row2=mysqli_fetch_assoc($query2)){
            $u_ask=$row2["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
            $sc=mysqli_query($conn,$score);
             $re=mysqli_fetch_array($sc);
             $b = stripslashes($row2['answers']);
           $answer=htmlspecialchars_decode($b);
            
            $query3=mysqli_query($conn,"SELECT 1 as record_exists,votes from vote WHERE ansid=".$row2['aid']." and askid='$userid' ");
            #echo $query3;
            $row3=mysqli_fetch_array($query3);
               
           echo"</div>";
        echo"<tr>";
        echo"<td>";
          //echo $row3['record_exists'];
            if(isset($_SESSION["username"] )){
             echo"<div class='row'>";
             echo"<div id='voting'>";
            echo"<div class='col-sm-1'><input type='hidden' name='aid' value= ".$row2['aid'].">";
             echo"<input type='hidden' name='userid' value= '$userid'>";
            echo"<input type='hidden' name='record' value= ".$row3['record_exists'].">";
            
           if(vote_count($row2['aid'],'a')==0)
               echo"<p id='vote'>0</p>";
            else
                echo "<p id='vote'>".vote_count($row2['aid'],'a')."</p>";
           echo"<i class='fa fa-thumbs-o-up' aria-hidden='true' id='up'onclick='voteup(this)'></i><br><br>";
            
           echo"<i class='fa fa-thumbs-o-down' aria-hidden='true'id='down' onclick='voteup(this )'></i><br><br></div>";
             
            
            echo"</div>";}
            if ($f['state']=='TRUE'||isnull($f['state']))
                {
        if($row2['bestanswer']==1){
            
          echo " <div class='col-sm-1'> <i class='fa fa-check fa-2x' style='color:#46d246 ' id= ".$row2['aid']." onclick='select_tick(this.id)'aria-hidden='true'> </i></div>";}
       
         else{
          echo  "<div class='col-sm-1'><i class='fa fa-check fa-2x' style='color:#B8B8B8 ' id= ".$row2['aid']." onclick='select_tick(this.id)'aria-hidden='true'> </i></div>";}
            }
       
        echo"<div class='col-sm-10'><p>".$answer."<br>";
            echo"</div>";
       echo"<div class='col-sm-2' style='float:right' color='red'>";
                echo"<p class=rytsydcenter> Answered by: </p>";
            
              //$gitpic = "https://github.com/".$row1['username'].".png";
              
              if($row2['gitv']==1)
              {
              
                echo "<img width='25' height='25' alt='abc' src='https://github.com/".$row2['username'].".png' />";
                
              }
              else
              {
                $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $row2['useremail'] ) ) ) . "?d=" . urlencode( 'https://s29.postimg.org/9xm80cstj/defaultpic.png' );
              $source = "./profile_pictures/".$row2['username'];
              $source = trim($source);
              if(file_exists($source))
              { 
                 ?>
                  <img width='25' height='25' alt='abc' src='./profile_pictures/<?php echo $row2['username']; ?>' />
                <?php
              }
              else
              {
                 ?>
                  <img width='25' height='25' alt='abc' src='<?php echo $grav_url; ?>' / >
                <?php
              }
              }
            
            echo" <a href='profile.php?id=".$row2['uid']."'>".$row2['username']."</a></p>";
            echo "<p class=rytsydcenter> Score:".$re['user_score'];
              
            echo"</div>";
            echo"</td></tr>";
        }
        echo"</table>" ;
    
       echo"</div></div>" ;
        mysqli_close($conn);
        ?>
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
              <body>
                  <div class="container">
        <form action="post_myanswer.php" onsubmit="return validate_myanswerForm()" method="post">
                    <textarea id="summernote" name="textbox" rows="10" cols="80"></textarea>
        
        <?php if($f['state']=='TRUE'){
            ?>
        <input type="submit" value="Post Your Answer" name="submit"> 
            <?php } ?>
        </form></div>
    
  <script src="validate.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
  <script>
$(document).ready(function() {
$('#summernote').summernote({
  height: 130,                 
  minHeight: null,             
  maxHeight: null,             
  focus: true                  
});
    });
  </script>
             
</body>
</html>