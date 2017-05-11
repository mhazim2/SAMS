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
	//ambil id teman
	$ambil1 = mysqli_query($conn, "SELECT * FROM users WHERE name='$namefriend'") or die(mysqli_error($conn));
	$row= mysqli_fetch_array($ambil1);
	$idfriend=$row[id_user];
	$ambil2 = mysqli_query($conn, "SELECT * FROM contact WHERE id_friend_contact='$idfriend' AND id_user_contact= '$simpanid'") or die(mysqli_error($conn));
	$cek = mysqli_num_rows($ambil2);
	//melakukan query dengan perintah INSERT INTO untuk memasukkan data ke database

	if($cek){
	$input1 = mysqli_query($conn, "INSERT INTO agenda VALUES(NULL, '$simpanid', '$idfriend', '$dateagenda', '$timeagenda', '$place', '$subject', '$description', '1', '0')") or die(mysqli_error($conn));
  $input2 = mysqli_query($conn, "INSERT INTO agenda VALUES(NULL, '$idfriend', '$simpanid', '$dateagenda', '$timeagenda', '$place', '$subject', '$description', '0', '1')") or die(mysqli_error($conn));
}
	//jika query input sukses
	if($input1 && $input2 ){
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
