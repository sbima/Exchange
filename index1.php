<?php  
include("connection.php");
$query = mysqli_query($conn,"SELECT username,qid,title FROM question INNER JOIN asker ON question.uid=asker.uid "); 
?>
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
    <br> <div class="container">
    <br><div class="row">
             <div class="col-sm-6">
   
                 <img class="img-responsive" src="images/exchange.PNG "style="width:400px;height:100px;"></div><br>
      <br>

      <div id="menu"><div class="col-sm-6">
          <center>
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
          </ul>
        </nav>
            </div></div></div> </div>
      <div class="container">
    <div class="row">
          <div class="col-sm-2"></div>
          <div class="col-sm-8"><h3> Welcome to EXchange. Please login to view your Profile.</h3></div>
          <div class="col-sm-2"></div>
          </div>
      </div>
      
              
               
      
      <br>
      <br>
     
        <center><h3> Questions</h3></center>
        <?php
      echo"<div class='container'>";
echo"<div class=\"table-responsive\">";
echo"<table class=\"table table-striped\" position=\"center\">";
while($row = mysqli_fetch_array($query)){
echo"<tr>";
echo"<td><a href='answer.php?q=".$row['qid']."'><h4>".$row['title']."</h4></a><br>";
echo"<div class='col-sm-2' style='float:right' color='red'>";
            echo"<p class=rytsydcenter> Asked by:".$row['username'];
        echo"</div>";
    
}
echo"</table>" ;
echo"</div>" ;
      echo"</div>" ;
mysqli_close($conn);
?>
      <center>
        <footer id="foot01">
        </footer>
      </center>
    </div>
    <script src="footer.js">
    </script> 
  </body
    </html>
