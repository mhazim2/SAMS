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

?>
<!DOCTYPE html>
<html>
<head>
  Sams
</head>
<p><a href="Profile.php"> profile </a> / <a href="Invitation.php">Invitation</a> / <a href="Index.php">Agenda</a> / <a href="Contact.php">Contact</a> / <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></p>

<h3>Agenda</h3>

<table cellpadding="5" cellspacing="0" border="1">
  <tr bgcolor="#CCCCCC">
    <th>No.</th>
    <th>date</th>
    <th>time</th>
    <th>place</th>
    <th>Subject</th>
    <th>description</th>
  </tr>

  <?php
  //iclude file koneksi ke database
  include('dbconnect.php');
  $simpanid = $_SESSION['user'];
  //query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
  $query = mysqli_query($conn, "SELECT * FROM agenda WHERE id_user_agenda='$simpanid' AND permission = 1") or die(mysqli_error());

  //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
  if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

    //jika data kosong, maka akan menampilkan row kosong
    echo '<tr><td colspan="6">Tidak ada agenda!</td></tr>';

  }else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

    //jika data tidak kosong, maka akan melakukan perulangan while
    $no = 1;	//membuat variabel $no untuk membuat nomor urut
    while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database

      //menampilkan row dengan data di database
      echo '<tr>';
        echo '<td>'.$no.'</td>';	//menampilkan nomor urut
        echo '<td>'.$data['date_agenda'].'</td>';	//menampilkan data nis dari database
        echo '<td>'.$data['time_agenda'].'</td>';	//menampilkan data nama lengkap dari database
        echo '<td>'.$data['place'].'</td>';	//menampilkan data kelas dari database
        echo '<td>'.$data['subject'].'</td>';
        echo '<td>'.$data['description'].'</td>';	//menampilkan data jurusan dari database
        if ($data['invited']==0){ // cim tambah ini aja buat conditionalnya
	         echo '<td><a href="edit.php?id='.$data['id_agenda'].'">Edit</a> / <a href="Hapus.php?id='.$data['id_agenda'].'" onclick="return confirm(\'Yakin?\')">Hapus</a></td>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
	       }
         $date_agenda = $data['date_agenda'];
         $time_agenda = $data['time_agenda'];
         $subject = $data['subject'];
	       $pendatang = mysqli_query($conn, "SELECT * FROM agenda WHERE date_agenda = '$date_agenda' AND permission=1 AND time_agenda='$time_agenda' AND subject = '$subject'") or die(mysqli_error($conn));
	       echo '<td>'.mysqli_num_rows($pendatang).'</td>'; // jumlah pendatang cim
      echo '</tr>';
      $no++;	//menambah jumlah nomor urut setiap row
    }
  }
  ?>
</table>
<a href="tambah.php">tambah agenda</a>
<?php echo count($query); ?>
</body>
</html>
<?php ob_end_flush(); ?>
