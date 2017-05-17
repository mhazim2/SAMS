<?php
//mulai proses tambah data
session_start();?>
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

		<ons-page id="editAgenda">
			<ons-toolbar>
                <div class="left">
                    <ons-toolbar-button onclick="location.href='home.php'">
                        <ons-icon icon="ion-android-arrow-back"></ons-icon>
                    </ons-toolbar-button>
                </div>
				<div class="center">
					Detail Agenda
				</div>
			</ons-toolbar>
            <?php


            ?>
				<form action="edit-proses.php" method="post">
					<div class="col-md-12">
						<div  style="text-align: center; margin-top: 70px;">
                            <?php
                            //proses mengambil data ke database untuk ditampilkan di form edit berdasarkan siswa_id yg didapatkan dari GET id -> edit.php?id=siswa_id

                            //include atau memasukkan file koneksi ke database
                            include('dbconnect.php');

                            //membuat variabel $id yg nilainya adalah dari URL GET id -> edit.php?id=siswa_id
                            $id = $_GET['id'];

                            //melakukan query ke database dg SELECT table siswa dengan kondisi WHERE siswa_id = '$id'
                            $show = mysqli_query($conn, "SELECT * FROM agenda WHERE id_agenda='$id'");

                            //cek apakah data dari hasil query ada atau tidak
                            if(mysqli_num_rows($show) == 0){

                                //jika tidak ada data yg sesuai maka akan langsung di arahkan ke halaman depan atau beranda -> index.php
                                //echo '<script>window.history.back()</script>';

                            }else{

                                //jika data ditemukan, maka membuat variabel $data
                                $data = mysqli_fetch_assoc($show);	//mengambil data ke database yang nantinya akan ditampilkan di form edit di bawah

                            }
                            ?>
							<input type="hidden" name="id" value="<?php echo $id; ?>"/>
							<p>
								<ons-input id="subject" modifier="underbar" type="text" name="subject" value="<?php echo $data['subject']; ?>" class="form-control" placeholder="Subject" size="33" float required/>
							</p>
							<p>
								<ons-input id="place" modifier="underbar" type="text" name="place" value="<?php echo $data['place']; ?>" class="form-control" placeholder="Place" size="33" float required/>
							</p>
							<p>
								<ons-input id="timeagenda" modifier="underbar" type="time" name="timeagenda" value="<?php echo $data['time_agenda']; ?>" class="form-control" size="33" required/>
							</p>
							<p>
								<ons-input id="dateagenda" modifier="underbar" type="date" name="dateagenda" value="<?php echo $data['date_agenda']; ?>" class="form-control" size="33" required/>
							</p>
							<p>
								<section style="padding: 0 8px 8px">
								<textarea class="textarea" name="description" style="width: 80%; height: 120px;"><?php echo $data['description']; ?></textarea>
								</section>
							</p>
							<p>
								<input class="button" type="submit" name="simpan" value="Simpan" float/>
							</p>
						</div>
					</div>
				</form>

            <?php
            //mulai proses edit data

            //cek dahulu, jika tombol simpan di klik
            if(isset($_POST['simpan'])){

                //inlcude atau memasukkan file koneksi ke database
                //Sinclude('dbconnect.php');
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
                    //echo 'sukses';
                }
                //jika query update sukses
                if(empty($subject) & empty($place) & empty($dateagenda) &empty($timeagenda)){
                    ?>
                    <script>ons.notification.alert('Data tidak lengkap');</script>
                    <?php
                }else if($update1 & $update2){
                    ?>
                    <script>ons.notification.alert('Data berhasil di simpan!');</script>
                    <?php //echo 'Data berhasil di simpan! ';		//Pesan jika proses simpan sukses
                    //echo '<a href="Home.php?id='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman edit
                    //echo 'sukses';
                }else{
                    ?>
                    <script>ons.notification.alert('Hanya pengundang yang berhak merubah agenda!');</script>
                    <?php //echo 'Hanya pengundang yang berhak merubah agenda! ';		//Pesan jika proses simpan gagal
                    //echo '<a href="edit.php?id='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman edit
                    //echo 'gagal';
                }


            }else{	/*//jika tidak terdeteksi tombol simpan di klik

                //redirect atau dikembalikan ke halaman edit
                //echo '<script>window.history.back()</script>';
                $id = $_GET['id'];

                //melakukan query ke database dg SELECT table siswa dengan kondisi WHERE siswa_id = '$id'
                $show = mysqli_query($conn, "SELECT * FROM agenda WHERE id_agenda='$id'");

                //cek apakah data dari hasil query ada atau tidak
                if(mysqli_num_rows($show) == 0){

                    //jika tidak ada data yg sesuai maka akan langsung di arahkan ke halaman depan atau beranda -> index.php
                    //echo '<script>window.history.back();</script>';
                    ?>
                        <script>ons.notification.alert('Data berhasil di simpan!');</script>
                    <?php

                }else{

                    //jika data ditemukan, maka membuat variabel $data
                    $data = mysqli_fetch_assoc($show);	//mengambil data ke database yang nantinya akan ditampilkan di form edit di bawah
                    ?>
                    <!--<script>ons.notification.alert('Data berhasil di simpan!');</script>-->
                    <?php
                }*/
            }

            ?>
		</ons-page>
	</body>
</html>
