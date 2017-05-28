

<?php
//mulai proses tambah data
session_start();
//cek dahulu, jika tombol tambah di klik
if(isset($_POST['tambah'])){

  //inlcude atau memasukkan file koneksi ke database
  include('dbconnect.php');
  $simpanid = $_SESSION['user'];
                                  //jika tombol tambah benar di klik maka lanjut prosesnya
  $subject		= $_POST['subject'];	//membuat variabel $nis dan datanya dari inputan NIS
  $place	 		= $_POST['place'];	//membuat variabel $nama dan datanya dari inputan Nama Lengkap
  $namefriend	= $_POST['namefriend'];	//membuat variabel $kelas dan datanya dari inputan dropdown Kelas
  $dateagenda	= $_POST['dateagenda'];	//membuat variabel $jurusan dan datanya dari inputan dropdown Jurusan
  $timeagenda	= $_POST['timeagenda'];
  $description= $_POST['description'];
  $cek = mysqli_query($conn, "SELECT * FROM agenda WHERE date_agenda='$dateagenda' AND time_agenda='$timeagenda'");
  //CIM NGECEK KALO AGENDA TABRAKAN
  if(mysqli_num_rows($cek)==0){
  $input = mysqli_query($conn, "INSERT INTO agenda VALUES(NULL, '$simpanid', '$simpanid', '$dateagenda', '$timeagenda', '$place', '$subject', '$description', '1', '0')") or die(mysqli_error($conn));
}
  //jika query input sukses
  if($input){
    echo 'Data berhasil di tambahkan! '; echo count($cek);		//Pesan jika proses tambah sukses
    echo '<a href="tambah.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

  }else{
    header('Location:Home.php');

}
}
?>

<!DOCTYPE html>
  <html>
  <head>
  	<title>Test doang</title>
  </head>
  <body>
  	<h2>Undang Teman ke ACRA</h2>

  	<p><a href="Home.php">Back</a>
      // ketambah proses cimmmmmm
      <form action="tambah-proses.php" method="post">
    		<table cellpadding="3" cellspacing="0">
    			<tr>
    				<td><input type="hidden" name="subject" value="<?php echo $subject; ?>" required></td>
    			</tr>
    			<tr>
    				<td><input type="hidden" name="place" value="<?php echo $place; ?>" size="30" required></td>
    			</tr>
          <tr>
            <td><input type="hidden" name="timeagenda" value="<?php echo $timeagenda; ?>" size="30" required></td>
    			</tr>
          <tr>
    				<td><input type="hidden" name="dateagenda" value="<?php echo $dateagenda; ?>" size="30" required></td>
    			</tr>
          <tr>
    				<td><input type="hidden" name="description" value="<?php echo $description; ?>" size="255"></td>
    			</tr>
          <tr>
            <td>Invite</td>
            <td></td>
            <td>
              <form action="php_checkbox.php" method="post">
                <?php
                $teman = mysqli_query($conn, "SELECT * FROM contact INNER JOIN users ON contact.id_friend_contact=users.id_user WHERE id_user_contact=$simpanid");
                while($data=mysqli_fetch_assoc($teman)){
                  echo '<input type="checkbox" name="check_list[]" value="'.$data['id_user'].'"><label>'.$data['name'].'</label>';
                }
                 ?>
                <input type="submit" name="submit" Value="Submit"/>
                <!----- Including PHP Script ----->
                <?php include 'checkbox.php';?>
              </form>
            </td>
          </tr>
    	</form>
  </body>
  </html>
