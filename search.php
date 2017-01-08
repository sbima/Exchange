<?php  
 include("connection.php");
 $search= $_GET['term'];
$output_arr=[];
 if(isset($_GET['term']))  
 {  
      $output = '';  
      $query = "SELECT * FROM asker WHERE username LIKE '".$_GET['term']."%' ORDER BY username ASC";  
     if( $result = mysqli_query($conn, $query))    {
      
           while($row = mysqli_fetch_array($result))  
           {  
            $output_arr[]= $row['username'];
            //header("Location: login1.php?=")
           }  
      }  }
      /*else  
      {  
           $output. = "User Not Found";  
      }  
      */
      echo json_encode($output_arr); 
   
 ?> 