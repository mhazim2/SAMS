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
	$cek = mysqli_query($conn, "SELECT * FROM contact WHERE id_contact='$id'") or die(mysqli_error());
	$row=mysqli_fetch_array($cek);
	$id1 = $row['id_user_contact'];
	$id2 = $row['id_friend_contact'];
	//jika data siswa tidak ada
	if(mysqli_num_rows($cek) == 0){

		//jika data tidak ada, maka redirect atau dikembalikan ke halaman beranda
		echo '<script>window.history.back()</script>';

	}else{
		$del1 = mysqli_query($conn, "DELETE FROM contact WHERE id_user_contact='$id1' AND id_friend_contact='$id2'");
    $del2 = mysqli_query($conn, "DELETE FROM contact WHERE id_friend_contact='$id1' AND id_user_contact='$id2'");

    //jika query DELETE berhasil
		if($del1 && $del2){
			echo 'contact berhasil di hapus! ';		//Pesan jika proses hapus berhasil
			echo '<a href="Contact.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

		}else{

			echo 'contact gagal dihapus';		//Pesan jika proses hapus gagal
			echo '<a href="Contact.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

		}

	}

}else{

	//redirect atau dikembalikan ke halaman beranda
	echo '<script>window.history.back()</script>';

}
?>
