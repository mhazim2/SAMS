<?php
include('dbconnect.php');
$id=$_GET['id'];
$hapus = mysqli_query($conn, "DELETE FROM tasks WHERE id='$id'") or die(mysqli_error($conn));
if($hapus){
  header("Location: dashboard.php");
}
 ?>
