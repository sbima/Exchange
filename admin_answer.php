
<?php
include("navbar.php");
   
 if(isset($_SESSION["username"])) {
     $uname=$_SESSION["username"];
     $userid=$_SESSION["userId"];

    }


include("connection.php");


 $qid=$_GET['q'];
 $_SESSION["qid"] = $qid;
 ?>
<script>
     ga('send', {
  hitType: 'pageview',
  page: location.pathname
});
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
    $query = mysqli_query($conn,"SELECT asker.uid,username,useremail,gitv,qid,title,state,content FROM question INNER JOIN asker ON question.uid=asker.uid WHERE qid='$qid' ");

    $query1=mysqli_query($conn,"SELECT COUNT(qid) cnt FROM answer WHERE qid='$qid' ");
    $query2=mysqli_query($conn,"select username,asker.uid,aid,useremail, answers,sum(vote.votes) AS v,bestanswer FROM asker left OUTER join answer on asker.uid=answer.auid left outer join (SELECT * FROM vote WHERE vtype = 'a') vote on answer.aid = vote.ansid where answer.qid ='$qid' GROUP by answer.aid ORDER BY `answer`.`bestanswer` DESC");
    $row1 = mysqli_fetch_array($query1);
        function vote_count($id,$type)
        {
            global $conn;
            $qq="SELECT SUM(votes) as vsum from vote where ansid='$id' and vtype='$type'";
            $query3=mysqli_query($conn,$qq);
            $result=mysqli_fetch_assoc($query3);
            $sum=$result['vsum'];
            return $sum;
        } 
?>
<div class='container'>
    <div class='table-responsive'>
        <table class='table table-striped' position='center'>
            
            
<?php
        
    while($row = mysqli_fetch_array($query))
    {
        $u_ask=$row["uid"];
        $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
        $sc=mysqli_query($conn,$score);
        $re=mysqli_fetch_array($sc);
        $b = stripslashes($row['content']);
        $content=htmlspecialchars_decode($b);
        $query4=mysqli_query($conn,"SELECT 1 as record_exists,votes from vote WHERE quesid=".$row['qid']." and  askid='$userid' and vtype='q' ");
        $row4=mysqli_fetch_array($query4);
?>
            <tr>
                <td>
<?php
            
             if(isset($_SESSION["username"] )){
?>
                <div class='row'>
                    <div id='ques'>
<?php      
        if(vote_count($row['qid'],'q')==0){
?>
    
                    <div class='col-sm-1'>
<?php
        echo"<p id='vote'>0</p>";
        }
        else
            echo "<p id='vote'>".vote_count($row['qid'],'q')."</p>";
        echo"<input type='hidden' name='qid' value= ".$row['qid'].">";
        echo"<input type='hidden' name='userid' value= '$userid'>";          
        echo"<input type='hidden' name='record' value= ".$row4['record_exists'].">";
        echo"<i class='fa fa-thumbs-o-up' aria-hidden='true' id='up'onclick='vote_ques(this)'></i><br><br>";
            
           echo"<i class='fa fa-thumbs-o-down' aria-hidden='true' id='down' onclick='vote_ques(this)'></i><br><br>";
?>
           
                    </div>
                    
                    <div class='col-sm-8'>
<?php
    }
            echo"<h4 class='click2edit' name='admintitle'><strong>".$row['title']."</h4></strong>";
?>
                    </div>
                    </div>
                </div>
                </td>
            </tr>
         
<link href="site2.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 

        <!-- include summernote css/js-->
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

        
            
            <tr>
                <td>
                    <div class='row'>
                        <div class='col-sm-8'>
                            
<?php
            echo"<div class='clicktoedit' name='admincontent'>".$content."</div><br>";
?>
              </div>
                    
                       
                
<?php
           echo"</p><div class='col-sm-2 rytsydasker' style='float:right' color='red'>";
            echo "<p class=rytsydcenter> Asked by:</p>";
            ?>
             <p> <?php
              
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
            echo"<a href='profile.php?id=".$row['uid']."'>".$row['username']."</a></p>";
            echo "<p class=rytsydcenter> Score:".$re['user_score']."</p>  </div>";
                  ?>          
                            <br>
                            <br>
                         <div class='col-sm-7'></div>
                        <div class='col-sm-5'>
                              &nbsp;
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <button type="button" id="edit" onclick="edit()" class="btn btn-info">Edit</button> &nbsp; 
            <button id="save" class="btn btn-primary" onclick="save()" type="button">Save</button> &nbsp;
            <button id="dele" class="btn btn-danger" onclick="dele()" type="button">Delete</button> &nbsp;
                                              
            <?php 
            
            if ($row["state"] == "TRUE"){
            echo "<input type='checkbox' value = ".$qid." name='freeze-checkbox' data-on-text='Freeze' data-off-text='Unfreeze' checked>"; 
            } else {
            echo "<input type='checkbox' value = ".$qid." name='freeze-checkbox' data-on-text='Freeze' data-off-text='Unfreeze' >";  
            }; ?>
                        
                       
                        
                    </div>
            </td></tr>
    <?php
           
         }
        
    ?>
                
        </table>
<!--        <script src="edit_save.js"></script>-->
        <script src="bootstrap-switch.js"></script>
        <script>
            var edit = function() {
                        $('.click2edit').summernote({focus: true});
                        $('.clicktoedit').summernote({focus: true});
                    };

            var save = function() {
                var makrup = $('.click2edit').summernote('code');
                var makrup1 = $('.clicktoedit').summernote('code');
                $('.click2edit').summernote('destroy');
                $('.clicktoedit').summernote('destroy');
    
                var quesid1 = "<?php echo $qid; ?>"
                $.post("admin_ajax.php",
                {
                    'title1': makrup,
                    'content1': makrup1,
                    'quesid1': quesid1
                },
                function(response){
                    console.log(response)
                });
    
            };
            
            function dele() {
                var quesid1 = "<?php echo $qid; ?>"
                $.post("delete_ajax.php",
                {
                    'quesid1': quesid1
                },
                function(response){
                    location.replace("adminpage.php")
                });
            }

            $("[name='freeze-checkbox']").bootstrapSwitch();
            $("[name='freeze-checkbox']").on('switchChange.bootstrapSwitch', function (event, state) {
                  if (state == true){
                    new_state = "TRUE"
                  }
                  if (state == false){
                    new_state = "FALSE"
                  }
                  //console.log(state);
                  var formdata = {};
                  formdata["state"] = new_state;
                  formdata["q_id"] = this.value;


                      $.ajax({
                        url: 'test.php',
                        type: 'post',
                        data: {myData:formdata,param:"freeze"},
                        success: function(data) {

                            //location.reload();

                        },
                        error: function(xhr, desc, err) {
                          console.log(xhr);
                          console.log("Details: " + desc + "\nError:" + err);
                        }
                      }); // end ajax call

                });

        </script>
    </div>
</div>
                
        