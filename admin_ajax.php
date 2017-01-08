<?php

include("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $tit=$_POST["title1"];
    $cont=$_POST["content1"];
    $qid=$_POST["quesid1"];
}

$query_admin= "UPDATE question SET title='$tit', content='$cont' where qid=$qid";

$query_result = mysqli_query($conn, $query_admin);

//if ($query_result) {
////        header("Location: admin_answer.php");
//        echo "Question updated";
//}
//else
//   echo "question not updated";

mysqli_close($conn);

?>