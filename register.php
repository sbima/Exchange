<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include("connection.php");
if (isset($_POST["username"]))

$myusername = mysqli_real_escape_string($conn,$_POST['username']);

if (isset($_POST["password"]))

$mypassword = mysqli_real_escape_string($conn,($_POST['password']));
#$image = $_POST["image"];
$sql=mysqli_query($conn,"SELECT * FROM asker WHERE username='$myusername' limit 1");
 if(mysqli_num_rows($sql)>=1)
   {
    echo "name already exists";
   }
 else
    {
     $query= "INSERT INTO asker (username,password) VALUES ('$myusername','$mypassword')";
     mysqli_query($conn,$query);
     mysqli_query($conn,$query) or die('Error, insert query failed');
     mysqli_close($conn);
     }
}

?>


<html>
  <head>
    <title>EXchange
    </title>
    <link href="site.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <title> Login
    </title>
  </head>
  <body>
   <br>  <div class="container" id="wrap">
    <br>
             <div class="col-sm-6">
   
                 <img class="img-responsive" src="images/exchange.PNG "style="width:400px;height:90px;"></div><br>
      <br>


      <div id="menu"><div class="col-sm-6">
          <center>
        <nav id="nav01">
          <ul id='menu'>
            <li>
              <a href='index.php'>Home
              </a>
            </li>
            <li>
              <a href='login.php'>Login
              </a>
            </li>
              <li>
              <a href='register.php'>Register
              </a>
            </li>
          </ul>
        </nav>
          </center></div></div> 
      <br>
     <br>
        <script src="validate.js"></script>
           
	 
       
            <form onsubmit="return validate_loginForm()" method="post" accept-charset="utf-8" class="form" role="form">  
               <center> <h2>Register</h2></center><br>
                    <div class="col-md-5 col-md-offset-3">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <input type="text" name="E-mail" value="" class="form-control input-lg" placeholder="E-mail ID"  />                        </div>   
                    </div><br>
                    <input type="text" name="username" value="" class="form-control input-lg" placeholder="Enter Username"  /><br>
                <input type="password" name="password" value="" class="form-control input-lg" placeholder="Password"/><br>
<!--                <input type="password" name="confirm_password" value="" class="form-control input-lg" placeholder="Confirm Password"/>     <br>     <input type="file" name="image" class="form-control input-lg" id="fileToUpload"><br>-->
                <div class="col-sm-4">
                <center>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button></center>
               </div>
                </div>
                
                
            </form>
        
          </div>
      
    <center><footer id="foot01"></footer></center>

      <script src="footer.js"></script>
    </body>
</html>
