<?php
//memulai proses accept

//cek dahulu, apakah benar URL sudah ada GET id -> accept.php?id=id_user
if(isset($_GET['id'])){

	//inlcude atau memasukkan file koneksi ke database
	include('dbconnect.php');

	//membuat variabel $id yg bernilai dari URL GET id -> accept.php?id=id_user
	$id = $_GET['id'];

	//cek ke database apakah ada data agenda dengan $id=id_user
	$cek = mysqli_query($conn, "SELECT id_agenda FROM agenda WHERE id_agenda='$id'") or die(mysqli_error($conn));

	//jika data agenda tidak ada
	if(mysqli_num_rows($cek) == 0){

		//jika data tidak ada, maka redirect atau dikembalikan ke halaman beranda
		echo '<script>window.history.back()</script>';

	}else{

		//jika data ada di database, maka melakukan query DELETE table agenda dengan kondisi WHERE $id=id_user
		$update = mysqli_query($conn, "UPDATE agenda SET permission = 1 WHERE id_agenda='$id'") or die(mysqli_error($conn));

		//jika query accept berhasil
		if($update){

			echo 'Acepted!';		//Pesan jika proses accept berhasil
			echo '<a href="Home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

		}else{

			echo 'Something goes wrong!';		//Pesan jika proses accept gagal
			echo '<a href="Home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

		}

	}

}else{

	//redirect atau dikembalikan ke halaman beranda
	echo '<script>window.history.back()</script>';

}
?>
