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
        <ons-page>
            <ons-toolbar>
                <div class="left">
                    <ons-toolbar-button onclick="location.href='home.php'">
                        <ons-icon icon="ion-android-arrow-back"></ons-icon>
                    </ons-toolbar-button>
                </div>
                <div class="center">
                    Tambah Contact
                </div>
            </ons-toolbar>
            <form action="tambahcontact.php" method="post">
                <div class="col-md-12">
                    <div  style="text-align: center; margin-top: 70px;">
                        <p>
                            <ons-input type="text" modifier="underbar" name="idfriendcontact" placeholder="ID Friend" float required></ons-input>
                        </p>
                        <p>
                            <span><a class="button" onclick="location.href='home.php'">Kembali</a></span>&nbsp&nbsp&nbsp&nbsp&nbsp<span><input class="button" type="submit" name="add" value="Add"></span>
                        </p>
                    </div>
                </div>
            </form>

            <?php
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
                    ?>
                    <script>ons.notification.alert('Data berhasil di tambahkan!');</script>
                    <?php
                    //echo 'Data berhasil di tambahkan! ';		//Pesan jika proses tambah sukses
                    //echo '<a href="home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

                }else{
                    ?>
                    <script>ons.notification.alert('Invalid user id or contact already exist!');</script>
                    <?php
                    //echo 'Invalid user id or contact already exist! ';		//Pesan jika proses tambah gagal
                    //echo '<a href="tambahcontact.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah

                }
            }else{	//jika tidak terdeteksi tombol tambah di klik
                //redirect atau dikembalikan ke halaman tambah
                echo '<script>window.history.back()</script>';
            }
            ?>
        </ons-page>
    </body>
</html>
