<?php
$conn=mysqli_connect('localhost','root','','auth');
if(mysqli_connect_errno()){
    echo 'failed to connect to mysql' . mysqli_connect_errno();
}
define('ROOT_URL','http://localhost:4432/login/note.php');
?>