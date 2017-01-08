<?php 
session_start();
?>
<html>
    <head>
        <style>
            
        </style>
      <title>EXchange</title>
        <link href="site.css" rel="stylesheet">
      <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <link href="bootstrap-switch.css" rel="stylesheet">
        
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-88921590-1', 'auto');
      ga('send', 'pageview');

    </script>
    <title> Login</title>
    </head>
    <body>
       
    <script src="func.js"></script>
        
    <div class="container">
        <div class="row">
             <div class="col-sm-4">
    <img class="img-responsive" src="images/exchange.PNG"style="width:200px;height:80px;"><br></div>

            
        
        <?php if(isset($_SESSION["username"])) {

    $uid=$_SESSION["userId"];
    $useremail=$_SESSION["useremail"];
    //$query = mysqli_query("SELECT asker.uid,username, useremail from asker on question.uid=asker.uid");
    //$r = mysqli_fetch_array($query);
    echo "<div class='col-sm-8'> <input type='text' class='search-term' name='s' placeholder='Search user' id='Search_Text'> 
    <button type='button' class='btn btn-info' onclick='search()'>
          <span class='glyphicon glyphicon-search'></span>
        </button>&nbsp &nbsp";
        
    echo"<a href='help.php' class='btn btn-info btn-lg'>
             Help Page
          </a> &nbsp &nbsp";
          
    echo "<a href='profile.php?id=$uid'class='btn btn-info btn-lg'>";
              
              //$gitpic = "https://github.com/".$row1['username'].".png";
              
              if($_SESSION["gitvar"]==1)
              {
            
                echo "<img width='25' height='25' alt='abc' src='https://github.com/".$_SESSION['username'].".png'";
                echo "/>".$_SESSION["username"]."</a> &nbsp &nbsp"; 
              }
              else
              {
                $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $useremail ) ) ) . "?d=" . urlencode( 'https://s29.postimg.org/9xm80cstj/defaultpic.png' );
                  $source = "./profile_pictures/".$_SESSION['username'];
                  $source = trim($source);
                  if(file_exists($source))
                  { 
                    //echo "inside"; 
                   echo "<img width='25' height='25' alt='abc' src='./profile_pictures/".$_SESSION['username']; 
                   echo "'/>".$_SESSION["username"]."</a> &nbsp &nbsp";

                  }
                  else
                  {
                     //echo "huf";
                   echo "<img width='25' height='25' alt='abc' src='$grav_url' / >".$_SESSION["username"]."</a> &nbsp &nbsp";

                  }
              }
   
    echo"<a href='logout.php' class='btn btn-info btn-lg'>";
            echo"<span class='glyphicon glyphicon-log-out'>";
           echo" </span> Log out";
          echo"</a> &nbsp &nbsp";
          
    if($_SESSION["user_role"]=="administrator"){
        echo "<a href='adminpage.php' class='btn btn-info btn-lg'> Administration </a>";
    }
     echo "</div>";
}
?>
   </div>     
    <br>
        <br>
        <br>
    <center>
    <div id="menu">
    <nav id="nav01">
    <ul id='menu1'>
    <li><a href='login1.php'>Home</a></li>
    <li><a href='question.php'>Ask Question</a></li>
    <li><a href='allquestions.php'>All Questions</a></li>
    <li><a href='myquestion.php'>My Questions</a></li>
    <li><a href='visual.php'>Visualization</a></li>   
    </ul>
    </nav>
        </div>
        </center>
      <br>
        <br>
        <br>
        </div>
            </body>
</html>
<script type="text/javascript">
$(function() {
    
    //autocomplete
    $(".search-term").autocomplete({
        source: "search.php",
        minLength: 1
    });                

});
function search(){
    var uname=document.getElementById('Search_Text').value;
    console.log(uname);
    window.location.href="profile.php?name="+uname;
}
</script>