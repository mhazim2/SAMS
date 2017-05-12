<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 //require_once 'Index.php';
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: Index.php");
  exit;
 }

?>
<!DOCTYPE html>
<html>
<head>
  Sams
</head>
<p><a href="Profile.php"> profile </a> / <a href="Invitation.php">Invitation</a> / <a href="Home.php">Agenda</a> / <a href="Contact.php">Contact</a> / <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></p>

<h3>contact</h3>

<table cellpadding="5" cellspacing="0" border="1">
  <tr bgcolor="#CCCCCC">
    <th>No.</th>
    <th>id</th>
    <th>nama</th>
    <th>email</th>
  </tr>

  <?php
  //iclude file koneksi ke database
  $simpanid = $_SESSION['user'];
  //query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
  $query = mysqli_query($conn, "SELECT * FROM contact INNER JOIN users ON id_friend_contact = id_user WHERE id_user_contact='$simpanid' ORDER BY name") or die(mysqli_error($conn));

  //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
  if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

    //jika data kosong, maka akan menampilkan row kosong
    echo '<tr><td colspan="6">Tidak ada contact!</td></tr>';

  }else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

    //jika data tidak kosong, maka akan melakukan perulangan while
    $no = 1;	//membuat variabel $no untuk membuat nomor urut
    while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database

      //menampilkan row dengan data di database
      echo '<tr>';
        echo '<td>'.$no.'</td>';	//menampilkan nomor urut
        echo '<td>'.$data['id_friend_contact'].'</td>';	//menampilkan data nis dari database
        echo '<td>'.$data['name'].'</td>';	//menampilkan data nama lengkap dari database
        echo '<td>'.$data['email'].'</td>';	//menampilkan data kelas dari database
        echo '<td><a href="Hapuscontact.php?id='.$data['id_contact'].'" onclick="return confirm(\'Yakin?\')">Hapus</a></td>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
      echo '</tr>';

      $no++;	//menambah jumlah nomor urut setiap row
    }
  }
  ?>
</table>
<a href="tambahcontact.php">tambah contact</a>
</body>
</html>
<?php ob_end_flush(); ?>
