<?php
$invalid =true;
$incaptcha = true;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include("connection.php");

if (isset($_POST["username"]))
$myusername = mysqli_real_escape_string($conn,$_POST['username']);
if (isset($_POST["password"]))
$mypassword = mysqli_real_escape_string($conn,($_POST['password']));
    
if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha){
      //header("Location: login.php");
      $incaptcha = false;
       // echo 'captcha failed. Do not try to spam';
    }
    $secretKey = "6Ldt_w0UAAAAAGQFgLBoyO4txLp7Xk_3pCjBpjGW";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
      //header("Location: login.php");
        echo ' ';
    } else {
      echo ' ';
    }
      
if($incaptcha != false){
    $query = mysqli_query($conn,"SELECT * FROM asker WHERE username = '$myusername' and password = '$mypassword' limit 1");  
if(mysqli_num_rows($query)==1){
session_start();
$data=mysqli_fetch_array($query,1);
$_SESSION["username"]=$_POST["username"];
$_SESSION["userId"]=$data["uid"];
$_SESSION["useremail"]=$data["useremail"];
$_SESSION["user_role"]=$data["role"];
$_SESSION["gitvar"]=$data["gitv"];
//echo $data["gitv"];
header("Location: login1.php");
mysqli_free_result($data);
}
else
{
$invalid = false;
}
}

mysqli_close($conn);
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
              </nav></center>
          </div></div> </div>
      
        <center><h2> Log in</h2></center>

        <script src="validate.js"></script>
        <form name="login_validform" class="form-signin" onsubmit="return validate_loginForm()" method="post">
            <input type="text" class="form-control" placeholder="Enter Username" name="username"><br>
            <input type="password" class="form-control" placeholder="Password" name="password"><br>
            <div class="g-recaptcha" data-sitekey="6Ldt_w0UAAAAAFAaD0R2KeqY3JUFATREE09YflEx"></div>
            <br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            
            <?php
                if($invalid == false) {
                    echo "<center><font color='red'>Invalid username or password</font></center>";
                }
            ?>
            
            <?php
                if($incaptcha == false) {
                    echo "<center><font color='red'>captcha failed. Do not try to spam</font></center>";
                     exit;
                }
            
            ?>
            
        </form>
      <center> <h4> <a href="https://github.com/login/oauth/authorize?scope=user:email&client_id=dc34aa87acaf62b14fdc">Login with Github </a></h4> </center>
        
 <br>
       

    <center><footer id="foot01"></footer></center>
      
       </div>
      
    <script src="footer.js">
    </script> 
    </body>
    </html>