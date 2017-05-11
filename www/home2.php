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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta http-equiv="Content-Security-Policy" content="default-src * data:; style-src * 'unsafe-inline'; script-src * 'unsafe-inline' 'unsafe-eval'">
  <script src="components/loader.js"></script>
  <script src="lib/onsenui/js/onsenui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="components/loader.css">
  <link rel="stylesheet" href="lib/onsenui/css/onsenui.css">
  <link rel="stylesheet" href="lib/onsenui/css/onsen-css-components.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<!--<h2>SAMS</h2>-->
<!--<p><a href="Invitation.php">Invitation</a> / <a href="Index.php">Agenda</a> / <a href="Contact.php">Contact</a> / <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></p>-->

<!--<h3>Agenda</h3>-->

<!--<table cellpadding="5" cellspacing="0" border="1">-->
<ons-page>
  <!--<tr bgcolor="#CCCCCC">-->
  <!--<ons-list>
    <ons-list-item>No.</ons-list-item>
    <ons-list-item>date</ons-list-item>
    <ons-list-item>time</ons-list-item>
    <ons-list-item>place</ons-list-item>
    <ons-list-item>Subject</ons-list-item>
    <ons-list-item>description</ons-list-item>
  </ons-list>-->

  <?php
  //iclude file koneksi ke database
  include('dbconnect.php');
  $simpanid = $_SESSION['user'];
  //query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
  $query = mysqli_query($conn, "SELECT * FROM agenda WHERE id_user_agenda='$simpanid' AND permission = 1") or die(mysqli_error());

  //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
  if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

    //jika data kosong, maka akan menampilkan row kosong
    echo '<on-list><!--<td colspan="6">--><ons-list-item>Tidak ada agenda!</ons-list-item></ons-list>';

  }else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

    //jika data tidak kosong, maka akan melakukan perulangan while
    $no = 1;	//membuat variabel $no untuk membuat nomor urut
    while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database

      //menampilkan row dengan data di database
      echo '<ons-list>';
        echo '<ons-list-item>'.$no.'</ons-list-item>';	//menampilkan nomor urut
        echo '<ons-list-item>'.$data['date_agenda'].'</ons-list-item>';	//menampilkan data nis dari database
        echo '<ons-list-item>'.$data['time_agenda'].'</ons-list-item>';	//menampilkan data nama lengkap dari database
        echo '<ons-list-item>'.$data['place'].'</ons-list-item>';	//menampilkan data kelas dari database
        echo '<ons-list-item>'.$data['subject'].'</ons-list-item>';
        echo '<ons-list-item>'.$data['description'].'</ons-list-item>';	//menampilkan data jurusan dari database
        echo '<ons-list-item><a href="edit.php?id='.$data['id_agenda'].'">Edit</a> / <a href="hapus.php?id='.$data['id_agenda'].'" onclick="return confirm(\'Yakin?\')">Hapus</a></ons-list-item>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
      echo '</ons-list>';

      $no++;	//menambah jumlah nomor urut setiap row
    }
  }
  ?>
</ons-page>
<a href="tambah.php">tambah agenda</a>
</body>
</html>
<?php ob_end_flush(); ?>
