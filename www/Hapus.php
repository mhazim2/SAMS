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

	}else{
    if($row['invited'] == 0){
		$del = mysqli_query($conn, "DELETE FROM agenda WHERE id_agenda='$id'+1");
    	$del = mysqli_query($conn, "DELETE FROM agenda WHERE id_agenda='$id'");
 	}?>
<!DOCTYPE HTML>
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

	<script>
        ons.ready(function() {
            console.log("Onsen UI is ready!");
        });

        window.fn = {};
        window.fn.open = function() {
            var menu = document.getElementById('menu');
            menu.open();
        };
        window.fn.load = function(page) {
            var content = document.getElementById('content');
            var menu = document.getElementById('menu');
            content
                .load(page)
                .then(menu.close.bind(menu));
        };
        window.fn.load2 = function(page) {
            var content = document.getElementById('content');
            content
                .load(page)
        };
        document.addEventListener('show', function(event) {
            var page = event.target;
            var titleElement = document.querySelector('#toolbar-title');

            if (page.matches('#first-page')) {
                titleElement.innerHTML = 'Contact';
            } else if (page.matches('#second-page')) {
                titleElement.innerHTML = 'Agenda';
            } else if (page.matches('#third-page')) {
                titleElement.innerHTML = 'Invite';
            }
        });
        var login = function() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            if (username === 'bob' && password === 'secret') {
                ons.notification.alert('You Are Logged In');
                var content = document.getElementById('content');
                var menu = document.getElementById('menu');
                content
                    .load('home.html')
                    .then(menu.close.bind(menu));
            }
            else {
                ons.notification.alert('Incorrect username or password.');
            }
        };
        document.addEventListener('init', function(event) {
            var page = event.target;

            if (page.id === 'page1') {
                page.querySelector('#push-button').onclick = function() {
                    document.querySelector('#myNavigator').pushPage('page2.html', {data: {title: 'Page 2'}});
                };
            } else if (page.id === 'page2') {
                page.querySelector('ons-toolbar .center').innerHTML = page.data.title;
            }
        });

	</script>
</head>
<body>
<ons-page>
	<ons-toolbar>
		<div class="left">
			<ons-toolbar-button onclick="location.href='home.php'">
				<ons-icon icon="ion-android-arrow-back"></ons-icon>
			</ons-toolbar-button>
		</div>
		<div class="center">
			Hapus
		</div>
	</ons-toolbar>
	<div class="col-md-12">
		<div  style="text-align: center; margin-top: 70px;">
            <?php
            //jika query DELETE berhasil
            if($del){
                echo '<p><h3>agenda berhasil di hapus!</h3></p>';		//Pesan jika proses hapus berhasil
                echo '<a type="button" class="button" href="home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

            }else{

                echo '<p><h3>Anda tidak bisa hapus apa yang anda accept!</h3></p>';		//Pesan jika proses hapus gagal
                echo '<a type="button" class="button" href="home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

            }

            }

            }else{

                //redirect atau dikembalikan ke halaman beranda
                echo '<script>window.history.back()</script>';

            }
            ?>
		</div>
	</div>
</ons-page>
</body>
</html>

