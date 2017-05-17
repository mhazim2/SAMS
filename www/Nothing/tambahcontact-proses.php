<?php
//mulai proses tambah data
session_start();
//cek dahulu, jika tombol tambah di klik
if(isset($_POST['add'])){

	//inlcude atau memasukkan file koneksi ke database
	include('dbconnect.php');
	$simpanid = $_SESSION['user'];
	//jika tombol tambah benar di klik maka lanjut prosesnya
	$idfriendcontact		= $_POST['idfriendcontact'];	//membuat variabel $nis dan datanya dari inputan NIS
	//cekdulu bor
	$res1=mysqli_query($conn, "SELECT * FROM users WHERE id_user='$idfriendcontact'");
	$count1 = mysqli_num_rows($res1);
	$res2=mysqli_query($conn, "SELECT * FROM contact WHERE id_friend_contact='$idfriendcontact' AND id_user_contact='$simpanid'");
	$count2 = mysqli_num_rows($res2);
	//melakukan query dengan perintah INSERT INTO untuk memasukkan data ke database
	if($count1==1 && $count2==0){
	$input1 = mysqli_query($conn, "INSERT INTO contact VALUES(NULL, '$simpanid', '$idfriendcontact')") or die(mysqli_error());
    $input2 = mysqli_query($conn, "INSERT INTO contact VALUES(NULL, '$idfriendcontact', '$simpanid')") or die(mysqli_error());
	}
	//jika query input sukses
	if($input1 && $input2 ){
		echo 'Data berhasil di tambahkan! ';		//Pesan jika proses tambah sukses
		echo '<a href="../home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

	}else{

		echo 'Invalid user id or contact already exist! ';		//Pesan jika proses tambah gagal
		echo '<a href="../tambahcontact.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

	}

}else{	//jika tidak terdeteksi tombol tambah di klik

	//redirect atau dikembalikan ke halaman tambah
	echo '<script>window.history.back()</script>';

}
?>
