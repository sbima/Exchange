<!DOCTYPE html>
<html>
    
<head>
    <link href="site.css" rel="stylesheet">
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
      
  <body>
   
      <?php
    include ('navbar.php');
      include("connection.php");
      $username= $_SESSION["username"];
      $useremail = $_SESSION["useremail"];
      //$hash = md5( strtolower( trim($useremail) ) );
      $id=$_SESSION["userId"];
      if(isset($_GET['id'])){
      $uid=$_GET['id'];
      $query1=mysqli_query($conn,"SELECT * FROM asker WHERE uid='$uid'");
          $row1 = mysqli_fetch_assoc($query1);
      }
      elseif(isset($_GET['name']))
      {
      $uname=$_GET['name'];
        $query1=mysqli_query($conn,"SELECT * FROM asker WHERE username='$uname'");
          $row1 = mysqli_fetch_assoc($query1);
      }
      elseif(isset($_SESSION["username"]))
      {
      $uname=$_SESSION["username"];
        $query1=mysqli_query($conn,"SELECT * FROM asker WHERE username='$uname'");
          $row1 = mysqli_fetch_assoc($query1);
      }
      
      
      ?>
 
    <div class="container">  
      <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-2">
              <?php
              
              //$gitpic = "https://github.com/".$row1['username'].".png";
              
              if($row1['gitv']==1)
              {
            
                echo "<img width='180' height='220' alt='abc' src='https://github.com/".$row1['username'].".png' />";
                  
              }
              else
              {
                $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $useremail ) ) ) . "?d=" . urlencode( 'https://s29.postimg.org/9xm80cstj/defaultpic.png' );
                  $source = "./profile_pictures/".$row1['username'];
                  $source = trim($source);
                  if(file_exists($source))
                  {
                     ?>
                      <img width='180' height='220' alt='abc' src='./profile_pictures/<?php echo $row1['username']; ?>' />
                    <?php
                  }
                  else
                  {
                     ?>
                      <img width='180' height='220' alt='abc' src='<?php echo $grav_url; ?>' / >
                    <?php
                  }  
              }
              ?>
              
              
              
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-4">
              <h2> <?php echo $row1['username'] ?> </h2>
             
              <?php
    
            if($row1['uid']==$_SESSION["userId"])
                 {
                    if($row1['gitv']==0)
                    {
                    echo"<form enctype='multipart/form-data' action='uploader.php' method='POST'>";
                    echo"<input type='hidden' name='MAX_FILE_SIZE' value='500000' />";
                    echo"<label for='phone'>Upload Profile Picture:</label>";
                    echo"<input name='uploadedfile' type='file' /><br />";
                    echo"<input type='submit' value='Upload Image'/>";
                    echo"</form>";
                    echo "<br>
                    <form enctype='multipart/form-data' action='delete_image.php'>
                        <input type='submit' value='Delete Image'/>
                    </form>";
                    }
               }?>
              
         </div>
          <div class='col-sm-4'></div>  
        
     </div></div> 
                  <br>
      
    <div class="col-sm-1"></div> <div class="col-sm-11"><h3 id="center"> Your Questions</h3> </div>  
<?php
        

      if(isset($_GET['id'])){
      $query = mysqli_query($conn,"SELECT username,qid,title FROM question INNER JOIN asker ON question.uid=asker.uid WHERE asker.uid='$uid' ");}
      elseif(isset($_GET['name'])){
          $query = mysqli_query($conn,"SELECT username,qid,title FROM question INNER JOIN asker ON question.uid=asker.uid WHERE asker.username='$uname'");}
      elseif(isset($_SESSION["username"]))
      {
       $query = mysqli_query($conn,"SELECT username,qid,title FROM question INNER JOIN asker ON question.uid=asker.uid WHERE asker.username='$uname'");}
        echo "<div class='row'><div class='col-sm-1'></div>";
        echo "<div class='col-sm-10'>";
	     echo"<div class='table-responsive'>";
		  echo"<table class='table table-striped'>";
         while($row = mysqli_fetch_assoc($query)){
        echo"<tr>";
        echo"<td><a href='myquestion_answer.php?q=".$row['qid']."'><h4>".$row['title']."</h4></a><br>";
             
        echo"</div>";
        echo "</td></tr>";
         }
     