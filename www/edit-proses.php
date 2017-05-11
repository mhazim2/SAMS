<?php
//mulai proses edit data

//cek dahulu, jika tombol simpan di klik
if(isset($_POST['simpan'])){

	//inlcude atau memasukkan file koneksi ke database
	include('dbconnect.php');
	//jika tombol tambah benar di klik maka lanjut prosesnya
	$id			= $_POST['id'];
  $subject		= $_POST['subject'];		//membuat variabel $subject dan datanya dari inputan subject
	$place	 		= $_POST['place'];			//membuat variabel $place dan datanya dari inputan place
	$dateagenda	= $_POST['dateagenda'];	//membuat variabel $dateagenda dan datanya dari inputan dateagenda
	$timeagenda	= $_POST['timeagenda'];
	$description= $_POST['description'];

	$cek = mysqli_query($conn, "SELECT * FROM agenda WHERE id_agenda='$id'") or die(mysqli_error($conn));
	$row=mysqli_fetch_array($cek);
	//melakukan query dengan perintah UPDATE untuk update data ke database dengan kondisi WHERE siswa_id='$id' <- diambil dari inputan hidden id
	if($row['invited']==0){
	$update1 = mysqli_query($conn, "UPDATE agenda SET id_friend='$row[id_friend]', subject='$subject', place='$place', date_agenda='$dateagenda', time_agenda='$timeagenda', description='$description' WHERE id_agenda='$id'") or die(mysqli_error($conn));
	$update2 = mysqli_query($conn, "UPDATE agenda SET id_user_agenda='$row[id_friend]', subject='$subject', place='$place', date_agenda='$dateagenda', time_agenda='$timeagenda', description='$description', permission='0' WHERE id_agenda='$id'+1") or die(mysqli_error($conn));
	}
	//jika query update sukses
	if($update1 & $update2){

		echo 'Data berhasil di simpan! ';		//Pesan jika proses simpan sukses
		echo '<a href="Home.php?id='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman edit

	}else{

		echo 'Hanya pengundang yang berhak merubah agenda! ';		//Pesan jika proses simpan gagal
		echo '<a href="edit.php?id='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman edit

	}

}else{	//jika tidak terdeteksi tombol simpan di klik

	//redirect atau dikembalikan ke halaman edit
	echo '<script>window.history.back()</script>';

}
?>
