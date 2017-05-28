<?php
//mulai proses tambah data
session_start();
//cek dahulu, jika tombol SUBMIT di klik <-------cim
if(isset($_POST['submit'])){

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

	if(isset($_POST['submit'])){
		if(!empty($_POST['check_list'])) {
			// Counting number of checked checkboxes.
			$checked_count = count($_POST['check_list']);
			echo "You have invited following ".$checked_count." friend(s): <br/>";
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['check_list'] as $selected) {
				echo "<p>".$selected ."</p>";
			}
			foreach($_POST['check_list'] as $selected) {
				$input = mysqli_query($conn, "INSERT INTO agenda VALUES(NULL, '$selected', '$simpanid', '$dateagenda', '$timeagenda', '$place', '$subject', '$description', '0', '1')") or die(mysqli_error($conn));;
			}
			echo "<br/><b>Note :</b> <span>Similarily, You Can Also Perform CRUD Operations using These Selected Values.</span>";
		}
		else{
			echo "<b>Please Select Atleast One Option.</b>";
		}
	}

	//jika query input sukses
	if($input){
		echo 'Data berhasil di tambahkan! '; echo $namefriend;		//Pesan jika proses tambah sukses
		echo '<a href="tambah.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

	}else{

		echo 'nama tidak valid atau nama belum ada dikontak! ';		//Pesan jika proses tambah gagal
		echo '<a href="tambah.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

	}

}else{	//jika tidak terdeteksi tombol tambah di klik

	//redirect atau dikembalikan ke halaman tambah
	echo '<script>window.history.back()</script>';

}
?>
