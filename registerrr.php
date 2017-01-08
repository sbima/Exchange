<?php
$invalid =true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include("connection.php");
if (isset($_POST["username"]))

$myusername = mysqli_real_escape_string($conn,$_POST['username']);
//$useremail = mysqli_real_escape_string($conn,($_POST['useremail']));
$useremail = $_POST['useremail'];
//$hash = md5( strtolower( trim($useremail) ) );
    
if (isset($_POST["password"]))

$mypassword = mysqli_real_escape_string($conn,($_POST['password']));
#$image = $_POST["image"];
$sql=mysqli_query($conn,"SELECT * FROM asker WHERE username='$myusername' limit 1");
 if(mysqli_num_rows($sql)>=1)
   {
    //echo "name already exists";
     $invalid = false;
   }
 else
    {
      
     $query= "INSERT INTO asker (username, useremail, password) VALUES ('$myusername','$useremail','$mypassword')";
     $result = mysqli_query($conn,$query);
     //mysqli_query($conn,$query) or die('Error, insert query failed');
     if($result){
       header("Location: login2.php");
     }
     else {
         echo "fail";
         echo mysqli_error($conn);
     }
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
    <title> signup
    </title>
  </head>
  <body>
   <br> <div class="container">
    <br><div class="row">
             <div class="col-sm-6">
   
                 <img class="img-responsive" src="images/exchange.PNG "style="width:400px;height:90px;"></div><br>
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
              <a href='login.php'>Login
              </a>
            </li>
          </ul>
        </nav>
              </center>
              </div></div> </div> </div>
      
      <div class="container">
          <div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-4">
                <center><h2> Sign up</h2></center>
                <script src="validate.js"></script>
    
	           <form name="signup_validform" class="form" onsubmit="return validate_signupform()" method="post" role="form" accept-charset="utf-8">
                    <input type="text" class="form-control" value="" placeholder="Enter Username" name="username"><br>
                    <input type="email" class="form-control" value="" placeholder="Enter Email" name="useremail"><br>
                    <input type="password" class="form-control" value="" placeholder="Password" name="password"><br>
                    <input type="password" class="form-control" value="" placeholder="Confirm_Password" name="confirmpassword"><br>

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
                    <br>
            
                  </form>
                  <?php
                    if($invalid == false) {
                    echo "<center>";
                        echo "<font color='red'>User Name already Exists</font>";
                        echo "</center>";
                        }
                  ?>
              </div>
 
              <div class="col-sm-4"></div>
          </div>
      </div>

    <center><footer id="foot01"></footer></center>

    <script src="footer.js">
    </script> 
    </body>
    </html>

