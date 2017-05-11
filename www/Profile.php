<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 //require_once 'Index.php';
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 $simpanid = $_SESSION['user'];
 $cek=mysqli_query($conn, "SELECT * FROM users WHERE id_user = $simpanid");
 $row=mysqli_fetch_array($cek);
?>

<!DOCTYPE html>
<html>
<head>
  Sams
</head>
<p><a href="Profile.php"> profile </a> / <a href="Invitation.php">Invitation</a> / <a href="Index.php">Agenda</a> / <a href="Contact.php">Contact</a> / <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></p>

<h3>Profile</h3>

<table cellpadding="3" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>:</td>
    <td><?php echo $row['id_user'] ?></td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td><?php echo $row['name']?></td>
  </tr>
  <tr>
    <td>Registered Email</td>
    <td>:</td>
    <td><?php echo $row['email']?></td>
  </tr>
</table>
</body>
</html>
