<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 //require_once 'Index.php';
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

?>

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

    /*document.addEventListener('init', function(event) {
        var page = event.target;

        if (page.id === 'second-page') {
            page.querySelector('#onfab').onclick = function() {
                document.querySelector('#myNavigator2').pushPage('tambahContact.html', {data: {title: 'Page 2'}});
            };
        } else if (page.id === 'page2') {
            page.querySelector('ons-toolbar .center').innerHTML = page.data.title;
        }
    });*/

  </script>
</head>
<body>
  <ons-splitter>
    <ons-splitter-side id="menu" side="left" width="220px" collapse swipeable>
      <ons-page>
        
        <ons-list>
          <ons-list-item onclick="fn.load('home.php')" tappable>
            Home
            <!--<ons-button modifier="quiet" onclick="fn.load('home.html')">Home</ons-button>-->
          </ons-list-item>
          <ons-list-item onclick="fn.load('logout.php?logout')" tappable>
            Sign Out
          </ons-list-item>
          <ons-list-item onclick="fn.load('about.html')" tappable>
            About
          </ons-list-item>
        </ons-list>
        
      </ons-page>
    </ons-splitter-side>
    <ons-splitter-content id="content" page="home.php"></ons-splitter-content>
  </ons-splitter>

  <ons-template id="home.php">
    <ons-page>
      <ons-toolbar>
        <div class="left">
          <ons-toolbar-button onclick="fn.open()">
            <ons-icon icon="ion-navicon, material:md-menu"></ons-icon>
          </ons-toolbar-button>
        </div>
        <div class="center" id="toolbar-title">
        </div>
      </ons-toolbar>
      <!--<p style="text-align: center; opacity: 0.6; padding-top: 20px;">
        Swipe right to open the menu!
      </p>-->
      <ons-tabbar position="auto">
        <ons-tab label="Tab 1" page="tab1.php">
          <ons-icon size="40px" icon="md-accounts"></ons-icon>
        </ons-tab>
        <ons-tab id="tab2" label="Tab 2" page="tab2.php" active>
          <ons-icon size="35px" icon="md-calendar"></ons-icon>
        </ons-tab>
        <ons-tab label="Tab 3" page="tab3.php">
          <ons-icon size="35px" icon="md-notifications"></ons-icon>
        </ons-tab>
      </ons-tabbar>
    </ons-page>
  </ons-template>

  <ons-template id="@login.php">
    <ons-page>
      <ons-toolbar>
        <div class="left">
          <ons-toolbar-button onclick="fn.open()">
            <ons-icon icon="ion-navicon, material:md-menu"></ons-icon>
          </ons-toolbar-button>
        </div>
        <div class="center">
          Login
        </div>
      </ons-toolbar>
      <!--<ons-tabbar position="auto">
          <ons-tab label="Tab 1" page="tab1.html" active>
          </ons-tab>
          <ons-tab label="Tab 2" page="tab2.html">
          </ons-tab>
      </ons-tabbar>-->
      <div style="text-align: center; margin-top: 70px;">
        <p>
          <ons-input id="username" modifier="underbar" placeholder="Username" float></ons-input>
        </p>
        <p>
          <ons-input id="password" modifier="underbar" type="password" placeholder="Password" float></ons-input>
        </p>
        <p style="margin-top: 30px;">
          <ons-button onclick="login()">Sign in</ons-button>
        </p>
      </div>
    </ons-page>
  </ons-template>

  <ons-template id="about.html">    
    <ons-page>
      <ons-toolbar>
        <div class="left">
          <ons-toolbar-button onclick="fn.open()">
            <ons-icon icon="ion-navicon, material:md-menu"></ons-icon>
          </ons-toolbar-button>
        </div>
        <div class="center">
        </div>
      </ons-toolbar>
      <ons-navigator id="myNavigator" page="page1.html"></ons-navigator>
      <!--<ons-tabbar position="auto">
          <ons-tab label="Tab 1" page="tab1.html" active>
          </ons-tab>
          <ons-tab label="Tab 2" page="tab2.html">
          </ons-tab>
      </ons-tabbar>-->
    </ons-page>
  </ons-template>  

  <ons-template id="tab1.php">
    <ons-page id="first-page">
      <!--<p style="text-align: center;">
        Contact
      </p>-->
        <?php
        //iclude file koneksi ke database
        $simpanid = $_SESSION['user'];
        //query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
        $query = mysqli_query($conn, "SELECT * FROM contact INNER JOIN users ON id_friend_contact = id_user WHERE id_user_contact='$simpanid' ORDER BY name") or die(mysqli_error($conn));
        ?>
        <ons-list>
            <ons-list-header>Me</ons-list-header>
            <ons-list-item tappable ripple onclick="fn.load('Profile.php')">
                <div class="left">
                    <ons-icon class="list-item__thumbnail" icon="md-account-circle" size="45px" style="color: mediumseagreen;"/>
                </div>
                <div class="center">
                    <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
                </div>
            </ons-list-item>
            <ons-list-header>
                Contact
                <!--<p><a style="text-decoration: none;" href="tambahcontact.php">tambah contact</a></p>-->
            </ons-list-header>
            <?php
                //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
                if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

                    //jika data kosong, maka akan menampilkan row kosong
                    echo '<ons-list-item>Tidak ada contact!</ons-list-item>';

                }else {    //else ini artinya jika data hasil query ada (data diu database tidak kosong)

                    //jika data tidak kosong, maka akan melakukan perulangan while
                    $no = 1;    //membuat variabel $no untuk membuat nomor urut
                    while ($data = mysqli_fetch_assoc($query)) {    //perulangan while dg membuat variabel $data yang akan mengambil data di database

                        //menampilkan row dengan data di database
                        //echo '<ons-list>';
                        //echo '<ons-list-item>'.$no.'</ons-list-item>';	//menampilkan nomor urut
                        //echo '<ons-list-item>'.$data['id_friend_contact'].'</ons-list-item>';	//menampilkan data nis dari database
                        echo '<ons-list-item>
                                <div class="left">
                                    <ons-icon class="list-item__thumbnail" icon="md-account-circle" size="45px" style="color: mediumseagreen;" tappable onclick="ons.notification.confirm(\'COMING SOON AS POSSIBLE\')"/>
                                </div>
                                <div class="center">
                                    <span class="list-item__title">' .$data['name']. '</span><span class="list-item__subtitle">' .$data['email']. '</span>
                                </div>
                                <div class="right">
                                    <a style="text-decoration: none;" href="Hapuscontact.php?id=' . $data['id_contact'] . '" onclick="return confirm(\'Yakin?\')">Hapus</a>
                                </div>
                            </ons-list-item>';
                        //echo '<ons-list-item>'.$data['email'].'</ons-list-item>';	//menampilkan data kelas dari database
                        //echo '<ons-list-item><a href="Hapuscontact.php?id=' . $data['id_contact'] . '" onclick="return confirm(\'Yakin?\')">Hapus</a></ons-list-item>';    //menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
                        //echo '</ons-list>';

                        $no++;    //menambah jumlah nomor urut setiap row
                    }
                }
            ?>
        </ons-list>
        <ons-fab onclick="fn.load('tambahcontact.php')" position="bottom right">
            <!--<ons-icon position="bottom right" icon="ion-android-person-add"></ons-icon>-->
            <ons-icon position="bottom right" icon="md-account-add">
        </ons-fab>
        <br />
    </ons-page>
  </ons-template>

  <ons-template id="tab2.php">
    <ons-page id="second-page">
      <!--<p style="text-align: center;">
        This is the second page.
      </p>-->
        <br />
        <?php
        //iclude file koneksi ke database
        include('dbconnect.php');
        $simpanid = $_SESSION['user'];
        //query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
        $query = mysqli_query($conn, "SELECT * FROM agenda WHERE id_user_agenda='$simpanid' AND permission = 1") or die(mysqli_error());

        //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
        if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

            //jika data kosong, maka akan menampilkan row kosong
            echo '<ons-list><!--<td colspan="6">--><ons-list-item>Tidak ada agenda!</ons-list-item></ons-list>';

        }else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

            //jika data tidak kosong, maka akan melakukan perulangan while
            $no = 1;	//membuat variabel $no untuk membuat nomor urut
            while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database

                //menampilkan row dengan data di database
                echo '<ons-list modifier="inset">';
                echo '<ons-list-header tappable>'.$data['date_agenda'].'</ons-list-header>';	//menampilkan data nis dari database
                echo '<ons-list-item modifier="longdivider" tappable>'.$data['subject'].'</ons-list-item>';
                echo '<ons-list-item modifier="longdivider" tappable><div class="center"><span class="list-item__title">'.$data['place'].'</span><span class="list-item__subtitle">'.$data['time_agenda'].'</div></ons-list-item>';	//menampilkan data kelas dari database
                //echo '<ons-list-item>'.$data['time_agenda'].'</ons-list-item>';	//menampilkan data nama lengkap dari database
                //echo '<ons-list-item>'.$no.'</ons-list-item>';	//menampilkan nomor urut
                //echo '<ons-list-item>'.$data['description'].'</ons-list-item>';	//menampilkan data jurusan dari database
                echo '<ons-list-item><a class="button" href="edit.php?id='.$data['id_agenda'].'">Detail</a> &nbsp&nbsp <a class="button" href="Hapus.php?id='.$data['id_agenda'].'" onclick="return confirm(\'Yakin?\')">Hapus</a></ons-list-item>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
                echo '</ons-list><br/>';

                $no++;	//menambah jumlah nomor urut setiap row
            }
        }
        ?>


        <?php /*
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
                }

                //jika query DELETE berhasil
                if($del){
                    echo 'agenda berhasil di hapus! ';		//Pesan jika proses hapus berhasil
                    //echo '<a href="Home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

                }else{

                    echo 'Anda tidak bisa hapus apa yang anda accept!';		//Pesan jika proses hapus gagal
                    //echo '<a href="Home.php">Kembali</a>';	//membuat Link untuk kembali ke halaman beranda

                }

            }

        }else{

            //redirect atau dikembalikan ke halaman beranda
            echo '<script>window.history.back()</script>';

        }
        */ ?>
        <ons-fab onclick="fn.load('tambah.php')" position="bottom right">
            <ons-icon icon="md-plus"></ons-icon>
        </ons-fab>
        <br />
        <!--<ons-navigator id="myNavigator2" page="page1.html"></ons-navigator>-->

    </ons-page>
  </ons-template>

  <ons-template id="tab3.php">
    <ons-page id="third-page">
        <br/>
        <?php
        //iclude file koneksi ke database
        include('dbconnect.php');
        $simpanid = $_SESSION['user'];
        //query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
        $query = mysqli_query($conn, "SELECT * FROM agenda WHERE id_user_agenda= '$simpanid' AND permission = 0") or die(mysqli_error($conn));
        //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
        if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

            //jika data kosong, maka akan menampilkan row kosong
            echo '<ons-list-item>Tidak ada undangan!</ons-list-item>';

        }else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

            //jika data tidak kosong, maka akan melakukan perulangan while
            $no = 1;	//membuat variabel $no untuk membuat nomor urut
            while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database
                $query2 = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$data[id_friend]'") or die(mysqli_error($conn));
                $row = mysqli_fetch_array($query2);
                //menampilkan row dengan data di database
                echo '<ons-list modifier="inset">';
                echo '<ons-list-header>'.$no.'</ons-list-header>';	//menampilkan nomor urut
                echo '<ons-list-item>From     : '.$row['name'].'</ons-list-item>';
                echo '<ons-list-item>Subject  : '.$data['subject'].'</ons-list-item>';
                echo '<ons-list-item>Waktu    : '.$data['time_agenda'].'</ons-list-item>';	//menampilkan data nama lengkap dari database
                echo '<ons-list-item>Tanggal  : '.$data['date_agenda'].'</ons-list-item>';	//menampilkan data nis dari database
                echo '<ons-list-item>Tempat   : '.$data['place'].'</ons-list-item>';	//menampilkan data kelas dari database
                echo '<ons-list-item>Deskripsi : '.$data['description'].'</ons-list-item>';	//menampilkan data jurusan dari database
                echo '<ons-list-item><a type="button" class="button" href="Accept.php?id='.$data['id_agenda'].'" onclick="return confirm(\'Yakin?\')">Accept</a></ons-list-item>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
                echo '</ons-list>';

                $no++;	//menambah jumlah nomor urut setiap row
            }
            //echo $_SESSION['user'];
        }
        ?>
      <br/>
    </ons-page>
  </ons-template>

  <!--<ons-template id="tambahAgenda.php">
      <ons-page id="tambahAgenda">
          <ons-toolbar>
              <div class="left"><ons-back-button onclick="fn.load('home.php')">Back</ons-back-button></div>
              <div class="center">
                  Tambah Agenda
              </div>
          </ons-toolbar>
          <!--<p><a href="index.php">Back</a>

          <form action="tambah-proses.php" method="post">
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
                          <button class="button" type="submit" name="tambah" value="Tambah" ></button>
                      </p>
                  </div>
              </div>
          </form>
      </ons-page>
  </ons-template>-->

  <ons-template id="page1.html">
        <ons-page id="page1">
            <ons-toolbar>
            <div class="center">Page 1</div>
            </ons-toolbar>
            <img class="center" src="https://2.bp.blogspot.com/-9JJ1XwBuKNw/WO2Fkx4jVQI/AAAAAAAAdmc/0StyzxPkJtQMR6bL5IHKBMKO46sLLJNmQCLcB/s400/majutsu%2B-%2B02.jpg" alt="Mountain View" >
            
            <p>This is the first page.</p>

            <ons-button id="push-button">Push page</ons-button>
        </ons-page>
  </ons-template>

  <ons-template id="page2.html">
        <ons-page id="page2">
            <ons-toolbar>
            <div class="left"><ons-back-button>Back</ons-back-button></div>
            <div class="center"></div>
            </ons-toolbar>

            <p>This is the second page.</p>
            <p><a href="logout.php?logout">Sign Out</a></p>
        </ons-page>
    </ons-template>

</body>
</html>
