<?php
//memulai proses hapus data
session_start();
//cek dahulu, apakah benar URL sudah ada GET id -> hapus.php?id=siswa_id
if(isset($_GET['id'])){

	//inlcude atau memasukkan file koneksi ke database
	include('dbconnect.php');
	$simpanid=$_SESSION['user'];
	//membuat variabel $id yg bernilai dari URL GET id -> hapus.php?id=siswa_id
	$id = $_GET['id'];
	//cek ke database apakah ada data siswa dengan siswa_id='$id'
	$cek = mysqli_query($conn, "SELECT * FROM agenda WHERE id_agenda='$id'") or die(mysqli_error());
	$row=mysqli_fetch_array($cek);
	//jika data siswa tidak ada
	if(mysqli_num_rows($cek) == 0){

		//jika data tidak ada, maka redirect atau dikembalikan ke halaman beranda
		echo '<script>window.history.back()</script>';

	}else{//CIM UPDATE NYA YANG INI YAK<---------------------------------------------------------------------------------------------------------------
		$del = mysqli_query($conn, "DELETE FROM agenda WHERE date_agenda='$row[date_agenda]' AND time_agenda='$row[time_agenda]' AND id_friend='$simpanid'");

    //jika query DELETE berhasil
		if($del){
			echo 'agenda berhasil di hapus! ';		//Pesan jika proses hapus berhasil
			echo '<a href="Home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

		}else{

			echo 'Anda tidak bisa hapus apa yang anda accept!';		//Pesan jika proses hapus gagal
			echo '<a href="Home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

		}

	}

}else{

	//redirect atau dikembalikan ke halaman beranda
	echo '<script>window.history.back()</script>';

}
?>
