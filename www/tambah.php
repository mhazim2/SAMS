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
    <ons-page id="tambahAgenda">
        <ons-toolbar>
            <div class="left">
                <ons-toolbar-button onclick="location.href='home.php'">
                    <ons-icon icon="ion-android-arrow-back"></ons-icon>
                </ons-toolbar-button>
            </div>
            <div class="center">
                Tambah Agenda
            </div>
        </ons-toolbar>
        <!--<p><a href="index.php">Back</a>-->

        <form action="tambah.php" method="post">
            <div class="col-md-12">
                <div  style="text-align: center; margin-top: 70px;">
                    <p>
                        <ons-input id="subject" modifier="underbar" type="text" name="subject" class="form-control" placeholder="Subject" size="33" float required/>
                    </p>
                    <p>
                        <ons-input id="place" modifier="underbar" type="text" name="place" class="form-control" placeholder="Place" size="33" float required/>
                    </p>
                    <p>
                        <ons-input id="namefriend" modifier="underbar" type="text" name="namefriend" class="form-control" placeholder="Invite Friend" size="33" float/>
                    </p>
                    <p>
                        <ons-input id="timeagenda" modifier="underbar" type="time" name="timeagenda" class="form-control" size="33" required/>
                    </p>
                    <p>
                        <ons-input id="dateagenda" modifier="underbar" type="date" name="dateagenda" class="form-control" size="33" required/>
                    </p>
                    <p>
                        <section style="padding: 0 8px 8px">
                            <textarea class="textarea" type="textarea" name="description" placeholder="Type here" style="width: 80%; height: 120px;"></textarea>
                        </section>
                    </p>
                    <p>
                    <span><a class="button" onclick="location.href='home.php'">Kembali</a></span>&nbsp&nbsp&nbsp&nbsp&nbsp<span><input class="button" type="submit" name="tambah" value="Tambah" /></span>
                        <!--<input type="button" class="button" onclick="location.href='home.php'"  value="Kembali"/>-->
                    </p>
                </div>
            </div>
        </form>

        <?php
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
        ?>

        <?php
        if($cek){
            $input1 = mysqli_query($conn, "INSERT INTO agenda VALUES(NULL, '$simpanid', '$idfriend', '$dateagenda', '$timeagenda', '$place', '$subject', '$description', '1', '0')") or die(mysqli_error($conn));
            $input2 = mysqli_query($conn, "INSERT INTO agenda VALUES(NULL, '$idfriend', '$simpanid', '$dateagenda', '$timeagenda', '$place', '$subject', '$description', '0', '1')") or die(mysqli_error($conn));
        }
        //jika query input sukses
        if($input1 && $input2 ){
            ?>
            <script>ons.notification.alert('Data berhasil di tambahkan! <?php echo $namefriend; ?> ');</script>
            <!--<h3>
                <?php //echo 'Data berhasil di tambahkan!'; echo $namefriend; //Pesan jika proses tambah sukses ?>
            </h3>-->
            <?php //echo '<a class="button" href="tambah.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

        }else{

        //echo '<h3>Nama tidak valid atau nama belum ada dikontak!</h3>';		//Pesan jika proses tambah gagal
        ?> <script>ons.notification.alert('Nama tidak valid atau nama belum ada dikontak!');</script> <?php
            //echo '<a class="button" href="tambah.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

        }
        }else{	//jika tidak terdeteksi tombol tambah di klik

            //redirect atau dikembalikan ke halaman tambah
            echo '<script>window.history.back()</script>';

        }?>
    </ons-page>
</body>
</html>
