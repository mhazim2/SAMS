<?php
include('dbconnect.php');
$task=$_POST['task'];
$input = mysqli_query($conn, "INSERT INTO tasks VALUES(NULL, '$task')") or die(mysqli_error($conn));
if($input){
  echo bisa;
}
 ?>
