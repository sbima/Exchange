<?php
include("connection.php");

if(isset($_GET['code']))
    {
        
            $code = $_GET['code'];
            $post = http_build_query(array(
                'client_id' => 'dc34aa87acaf62b14fdc',
                'redirect_url' => 'http://localhost/rajyalakshmi_cs518/login.php',
                'client_secret' => '38ecc42d9339676a16f908db853cf02c589d3216',
                'code' => $code,
            ));
            
            $context = stream_context_create(
                array(
                    "http" => array(
                        "method" => "POST",
                        'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                                    "Content-Length: ". strlen($post) . "\r\n".
                                    "Accept: application/json" ,  
                        "content" => $post,
                    )
                )
            );

            $json_data = file_get_contents("https://github.com/login/oauth/access_token", false, $context);
            $r = json_decode($json_data , true);
            $access_token = $r['access_token'];
            $scope = $r['scope']; 

            /*- Get User Details -*/
            $url = "https://api.github.com/user?access_token=".$access_token."";
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $data = file_get_contents($url, false, $context); 
            $user_data  = json_decode($data, true);
        
            $username1 = $user_data['login'];
        echo $username1;
    
            /*- Get User e-mail Details -*/                
            $url = "https://api.github.com/user/emails?access_token=".$access_token."";
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $emails =  file_get_contents($url, false, $context);
            $email_data = json_decode($emails, true);
            $email_id = $email_data[0]['email'];
            $email_primary = $email_data[0]['primary'];
            $email_verified = $email_data[0]['verified'];
        
          // $_SESSION["username"]=$username1;
    
            $query = mysqli_query($conn,"SELECT * FROM asker WHERE username = '$username1' limit 1");  
            
            //$queryy = mysqli_query($conn,"INSERT INTO asker (gitv) VALUES (1)");
            //$somearray[] = $query;
    
            //echo $query["username"];
            if(mysqli_num_rows($query)==1)
            {
                //echo "hello";
                session_start();
                
                $data=mysqli_fetch_array($query,1);
                
                $_SESSION["username"]=$username1;
                
                 
                $_SESSION["userId"]=$data["uid"];
                
                //echo $data["uid"];
                $_SESSION["useremail"]=$data["useremail"];
                //echo $data["useremail"];
                $_SESSION["user_role"]=$data["role"];
                $_SESSION["gitvar"]=$data["gitv"];
                //$_SESSION["gitvar"]="true";
                //echo $data["role"];
                header("Location: login1.php");

            }
            else
            {
            $query1= "INSERT INTO asker (username, useremail, password, gitv) VALUES ('$username1','$email_id','defaultpass',1)";
                $result = mysqli_query($conn,$query1);
                $query2 = mysqli_query($conn,"SELECT * FROM asker WHERE username = '$username1' limit 1");
               
                if(mysqli_num_rows($query2)==1)
                {
                    session_start();
                
                    $data1=mysqli_fetch_array($query2,1);

                    $_SESSION["username"]=$username1;


                    $_SESSION["userId"]=$data1["uid"];

                    //echo $data["uid"];
                    $_SESSION["useremail"]=$data1["useremail"];
                    //echo $data["useremail"];
                    $_SESSION["user_role"]=$data1["role"];
                    $_SESSION["gitvar"]=$data["gitv"];
                    //$_SESSION["gitvar"]="true";
                    //echo $data["role"];
                    header("Location: login1.php");
                }
                else 
                {
                    echo "fail";
                    echo mysqli_error($conn);
                }  
            }
    
}  
            
?>