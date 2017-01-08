<?php
include("navbar.php");

if(isset($_SESSION["username"])) {
//echo "Logged in";
}
else {
echo "You have been logged out. log back in to view your profile";
header("location: index1.php");
}
include("connection.php");
$username= $_SESSION["username"];
$uid=$_SESSION["userId"];
$useremail=$_SESSION["useremail"];
$query = mysqli_query($conn,"SELECT username,qid,title FROM question INNER JOIN asker ON question.uid=asker.uid ");
?>

  
<!DOCTYPE html>
    <html>
    <body>
        <div class="container">
   
        <h3> Questions</h3></div></body></html>
        <?php
echo"<div class='container'>";
	     echo"<div class=\"table-responsive\">";
		  echo"<table class=\"table table-striped\" position=\"center\">";
         while($row = mysqli_fetch_array($query)){
        echo"<tr>";
        echo"<td><a href='answer.php?q=".$row['qid']."'><h4>".$row['title']."</h4></a><br>";
        echo"<div class='col-sm-2' style='float:right' color='red'>";
            echo "<p class=rytsydcenter> Asked by:".$row['username'];
             ?>
             <img width='15' height='20' src='./profile_pictures/<?php echo $row['username']; ?>' onerror='this.src="./profile_pictures/defaultpic.png";'/>
        <?php
            
        echo"</div>";
        echo "</td></tr>";
             echo"</div>";
         }
        
       
       echo"</table>" ;

mysqli_close($conn);
?>
      
