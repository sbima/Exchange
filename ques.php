<?php
include("connection.php");
session_start();
function check($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data=mysqli_real_escape_string($conn, $data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $title=check($conn, $_POST["title"]);
    $content=check($conn, $_POST["textbox"]);
    $tags=check($conn,$_POST["tags"]);
}

$userid=$_SESSION["userId"];
$q="INSERT INTO question (uid, title, content,tags,date) VALUES ('$userid', '$title', '$content','$tags',now()) ";
$query = mysqli_query($conn, $q);
if ($query ==1 ) {
        header("Location: allquestions.php");
        echo" Question Posted";
}
mysqli_close($conn);
?>
