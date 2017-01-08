<?php
include("navbar.php");
   
 if(isset($_SESSION["username"])) {
     $uname=$_SESSION["username"];
     $userid=$_SESSION["userId"];

    }


include("connection.php");


 $qid=$_GET['q'];

 //$_SESSION["qid"] = $qid;
$que="SELECT COUNT(aid) cnt FROM answer where qid='$qid' ";
$q1=mysqli_query($conn,$que);
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
$query2= mysqli_query($conn,"select asker.username,useremail,gitv, aid, answers,sum(vote.votes) AS v,bestanswer,asker.uid FROM asker left OUTER join answer on asker.uid=answer.auid left outer join (SELECT * FROM vote WHERE vtype = 'a') vote on answer.aid = vote.ansid where answer.qid ='$qid' GROUP by answer.aid ORDER BY `answer`.`bestanswer` DESC LIMIT $offset,$page_rows");

$textline2="Page <b> $pagenum</b> of <b> $last</b>";
$paginationCtrls='';
if($last!=1){
    if($pagenum>1){
        $previous=$pagenum-1;
        $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'&q='.$qid.'">Previous</a> &nbsp';
        for($i=$pagenum-4;$i<$pagenum;$i++){
        if($i>0){
            $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?$pn='.$i.'&q='.$qid.'">'.$i.'</a> &nbsp;' ;
            
        }
        }
        }
    $paginationCtrls .=''.$pagenum.' &nbsp; ';
    for($i=$pagenum+1;$i <=$last; $i++){
        $paginationCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&q='.$qid.'">'.$i.'</a> &nbsp;' ;
        if($i >=$pagenum+4) {
            break;
        }
    }
    if($pagenum !=$last){
        $next=$pagenum +1;
        $paginationCtrls .=' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'&q='.$qid.'">Next</a> &nbsp';
    }
    }

 ?>
<script>
     
     function voteup(id){
  
    var names =$(id).siblings();
    var aid =names[0].value;
    
    var uid =names[1].value;
    var vote=$(names[3]).html();
    var value;
    var record_exits=names[2].value;
    if($(id).hasClass('fa-thumbs-o-up')){
        
        value=1;
    }
    else {
        ;
        value=-1;
    }
   
    var qid = <?php echo $qid ?>;
   
        $.ajax({
        url: 'votes.php',
        type: 'post',
        data: {mydata:qid,mydata2:aid,mydata3:uid,val:value,vote:vote,record:record_exits},
        success: function(data)
            {
               
             vote_value=data;
            
             names[3].innerHTML = vote_value;
             names[2].value = 1;
            
                
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
    var up_val=$('#up').attr('value');
    var down_val=$('#down').attr('value');
    var qid = <?php echo $qid ?>;
    console.log(up_val);
    console.log(down_val);
    var record_exits=names[3].value;
    if($(id).hasClass('fa-thumbs-o-up')){
        value=1;
        if(up_val==0){
            $.ajax({
        url: 'question_vote.php',
        type: 'post',
        dataType: "json",
        data: {mydata:qid,mydata3:uid,val:value,vote:vote,record:record_exits},
        success: function(response)
            {
                
             vote_value = response['vote'];
             sum_value=response['sumvote'];
                console.log(vote_value);
             if(vote_value == 1){
                 
             $('#up').attr('value',vote_value);
             }
             if(vote_value == 0){
                  $('#down').attr('value',vote_value);
                 $('#up').attr('value',vote_value);
                 
             }
                var vote_val = parseInt($('#vote').text());
                $('#vote').text(vote_val + 1);
            },       
               
            
        error: function(xhr, desc, err) {
          console.log(xhr);      
          console.log("Details: " + desc + "\nError:" + err);
        }
},'json'); 
    
        
    }
        else{
            alert("Already Up voted");
        }
    }
    else if($(id).hasClass('fa-thumbs-o-down')) {
       
        value=-1;
        if(down_val==0){
            $.ajax({
        url: 'question_vote.php',
        type: 'post',
        dataType: "json",
        data: {mydata:qid,mydata3:uid,val:value,vote:vote,record:record_exits},
        success: function(response)
            {
                console.log(response);
             vote_value=response['vote'];
             sum_value=response['sumvote'];
             if(vote_value==0){
             $('#up').attr('value',vote_value);
             $('#down').attr('value',vote_value);
             }
             if(vote_value==-1){
                 $('#down').attr('value',vote_value);
             }
                var vote_val = parseInt($('#vote').text());
                $('#vote').text(vote_val -1);
            },       
               
            
        error: function(xhr, desc, err) {
          console.log(xhr);      
          console.log("Details: " + desc + "\nError:" + err);
        }
}); 
    }
        else{
            alert("Already Down voted");
        }
        
        }
    }
   
    
    
               
    </script>
<?php 
$query = mysqli_query($conn,"SELECT username,useremail,gitv,qid,title,content,tags,asker.uid FROM question INNER JOIN asker ON question.uid=asker.uid WHERE qid='$qid' ");
$uservote = mysqli_query($conn,"SELECT votes as vo from vote where askid='$userid' and quesid='$qid' and vtype='q'");
$freeze=mysqli_query($conn,"SELECT * from question where qid='$qid'");
$free_result=mysqli_fetch_array($freeze);
$f = $free_result;
if ($f['state']=='FALSE'){
    ?>
<center><h3><font color=red>Question Freezed</font></h3></center>
<?php
}


$query1=mysqli_query($conn,"SELECT COUNT(qid) cnt FROM answer WHERE qid='$qid' ");
$r=mysqli_fetch_array($uservote);


$row1 = mysqli_fetch_array($query1);
function vote_count($id,$type){
global $conn;
$qq="SELECT SUM(votes) as vsum from vote where ansid='$id' and vtype='$type'";
//echo $qq;
$query3=mysqli_query($conn,$qq);
$result=mysqli_fetch_assoc($query3);
$sum=$result['vsum'];
    return $sum;
}

function vote_qcount($id,$type){
global $conn;
$qq="SELECT SUM(votes) as vsum from vote where quesid='$id' and vtype='$type'";
//echo $qq;
$query3=mysqli_query($conn,$qq);
$result=mysqli_fetch_assoc($query3);
$sum=$result['vsum'];
    return $sum;
}
#echo $count; 
           
        echo "<div class='container'>";
        
	     echo"<div class='table-responsive'>";
		  echo"<table class='table table-striped' position='center'>";
         while($row = mysqli_fetch_array($query)){
             $u_ask=$row["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
            $sc=mysqli_query($conn,$score);
$re=mysqli_fetch_array($sc);
            $b = stripslashes($row['content']);
            $content=htmlspecialchars_decode($b);
             $query4=mysqli_query($conn,"SELECT 1 as record_exists,votes from vote WHERE quesid=".$row['qid']." and askid='$userid' and vtype='q' ");
    $row4=mysqli_fetch_array($query4);
             //echo $r['vo'];
            echo"<tr>";
            echo"<td>";
             if(isset($_SESSION["username"] )){
             echo"<div class='row'>";
        echo"<div id='ques'>";
        if(vote_qcount($row['qid'],'q')==0){
               echo"<div class='col-sm-1'><p id='vote'>0</p>";}
            else{
        echo "<div class='col-sm-1'><p id='vote'>".vote_qcount($row['qid'],'q')."</p>";}
                 
        echo"<input type='hidden' name='qid' value= ".$row['qid'].">";
        echo"<input type='hidden' name='userid' value= '$userid'>";          
        echo"<input type='hidden' name='record' value= ".$r['vo'].">";
        if($r['vo']==1){
        echo"<i class='fa fa-thumbs-o-up' aria-hidden='true' id='up' onclick='vote_ques(this)' value=1></i><br><br>";
        }
                 else{
                  echo"<i class='fa fa-thumbs-o-up' aria-hidden='true' id='up' onclick='vote_ques(this)' value= 0></i><br><br>";   
                 }
            if($r['vo']==-1){
           echo"<i class='fa fa-thumbs-o-down' aria-hidden='true' id='down' onclick='vote_ques(this)' value= 1></i><br><br></div>";}
                else{
                    echo"<i class='fa fa-thumbs-o-down' aria-hidden='true' id='down' onclick='vote_ques(this)' value= 0></i><br><br></div>";
                }
                    
            echo"<h4><strong>".$row['title']."</h4></strong></td></tr>";
            echo"<td><p>".$content."</p><br>";
            $tag_name=$row['tags'];
             $tag=explode(' ',$tag_name);
             $i=0;
             echo"<p class=rytsydcenter>Tags:";
             for($i=0;$i<=(count($tag)-1);$i++){
        echo" <a href='tags.php?q=".$tag[$i]."'>".$tag[$i]."</a>"; 
             }  
           
             }echo"</p><div class='col-sm-2 rytsydasker' style='float:right' color='red'>";
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
            echo "</div>";
            echo "</td></tr>";
         }
        
        echo"<tr>";
        echo"<p> $textline2</p>" ;
echo" <div id='pagination_controls'> <br>";
echo $paginationCtrls;
echo"</div>";
        echo"<td><span style='font-weight: bold;'><p>".$row1['cnt']." Answers"."</p></span></td></tr>";
        echo"<tr>";
      while($row2=mysqli_fetch_array($query2)){
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
           echo"<i class='fa fa-thumbs-o-up' aria-hidden='true' id='up1'onclick='voteup(this)'></i><br><br>";
            
           echo"<i class='fa fa-thumbs-o-down' aria-hidden='true'id='down1' onclick='voteup(this )'></i><br><br></div>";
             
            
            echo"</div>";}
            if($row2['bestanswer']==1){
                if ($f['state']=='TRUE')
                {
         echo " <div class='col-sm-1'> <i class='fa fa-check fa-2x' style='color:#46d246' id= ".$row2['aid']."aria-hidden='true'> </i></div>";}
            }
          else{
              echo " <div class='col-sm-1'> <i class='fa fa-check fa-2x' style='color:#D3D3D3' id= ".$row2['aid']."aria-hidden='true'> </i></div>";}
              
          
          
         echo"<div class='col-sm-10'>".$answer."<br></div></div>";
            echo"</p><div class='col-sm-2 rytsydasker' style='float:right' color='red'>";
            echo "<p class=rytsydcenter> Answered by:</p>";
             
            ?>
              <p> 
            <?php
              
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
              ?>
        <?php
             echo" <a href='profile.php?id=".$row2['uid']."'>".$row2['username']."</a></p>";
            echo "<p class=rytsydcenter> Score:".$re['user_score'];
            echo "</div>";
          echo "</td></tr>";
        }
                
        echo"</table>" ;
    
       echo"</div>" ;
        mysqli_close($conn);
        ?> 



        <?php
if(isset($_SESSION["username"] )){
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
        <form action="post_answer.php" onsubmit="return validate_myanswerForm()" method="post">
                   <textarea id="summernote" name="textbox"></textarea>

       <?php if($f['state']=='TRUE'){?>
        <input type="submit" value="Post Your Answer" name="submit"> 
            <?php } ?>
        </form></div>
    <?php 
} 
                  ?>
  <script src="validate.js"></script>
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

