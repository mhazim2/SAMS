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
          <ons-icon size="45px" icon="md-face"></ons-icon>
        </ons-tab>
        <ons-tab id="tab2" label="Tab 2" page="tab2.php" active>
          <ons-icon size="45px" icon="md-calendar"></ons-icon>
        </ons-tab>
        <ons-tab label="Tab 3" page="tab3.php">
          <ons-icon size="35px" icon="md-android"></ons-icon>
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

        //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
        if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

            //jika data kosong, maka akan menampilkan row kosong
            echo '<tr><td colspan="6">Tidak ada contact!</td></tr>';

        }else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

            //jika data tidak kosong, maka akan melakukan perulangan while
            $no = 1;	//membuat variabel $no untuk membuat nomor urut
            while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database

            //menampilkan row dengan data di database
            echo '<tr>';
                echo '<td>'.$no.'</td>';	//menampilkan nomor urut
                echo '<td>'.$data['id_friend_contact'].'</td>';	//menampilkan data nis dari database
                echo '<td>'.$data['name'].'</td>';	//menampilkan data nama lengkap dari database
                echo '<td>'.$data['email'].'</td>';	//menampilkan data kelas dari database
                echo '<td><a href="Hapuscontact.php?id='.$data['id_contact'].'" onclick="return confirm(\'Yakin?\')">Hapus</a></td>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
            echo '</tr>';

            $no++;	//menambah jumlah nomor urut setiap row
            }
        }
        ?>
        </table>
        <a href="tambahcontact.php">tambah contact</a>
      <ons-list>
        <ons-list-header>Me</ons-list-header>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="http://www.aveleyman.com/Gallery/ActorsN/49595-7390.jpg">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-header>Contact</ons-list-header>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="https://pbs.twimg.com/profile_images/734356375665418244/TPPPHIfI.jpg">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="https://www.memecomic.id/data/meme_bg/17e7440e75a647ef0607e4680def62de.jpg">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="https://thetab.com/blogs.dir/90/files/2017/01/9-ucl.jpg">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="http://i.imgur.com/UIfNJYN.png">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="http://i.imgur.com/UIfNJYN.png">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="http://i.imgur.com/UIfNJYN.png">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="http://i.imgur.com/UIfNJYN.png">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>
        <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
          <div class="left">
            <img class="list-item__thumbnail" src="http://i.imgur.com/UIfNJYN.png">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>           
      </ons-list>
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
            echo '<on-list><!--<td colspan="6">--><ons-list-item>Tidak ada agenda!</ons-list-item></ons-list>';

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
                echo '<ons-list-item><a class="button" href="edit.php?id='.$data['id_agenda'].'">Edit</a> &nbsp&nbsp <a class="button" href="hapus.php?id='.$data['id_agenda'].'" onclick="return confirm(\'Yakin?\')">Hapus</a></ons-list-item>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
            echo '</ons-list>';

            $no++;	//menambah jumlah nomor urut setiap row
            }
        }
        ?>

        <ons-fab onclick="fn.load('tambah.php')" position="bottom right">
            <ons-icon icon="md-plus"></ons-icon>
        </ons-fab>      
    </ons-page>
  </ons-template>

  <ons-template id="tab3.php">
    <ons-page id="third-page">
      <ons-list>
        <ons-list-header>Default</ons-list-header>
        <ons-list-item>Item A</ons-list-item>
        <ons-list-item>Item B</ons-list-item>

        <ons-list-header>Tappable / Ripple</ons-list-header>
        <ons-list-item tappable>Tap me</ons-list-item>

        <ons-list-header>Chevron</ons-list-header>
        <ons-list-item modifier="chevron" tappable>Chevron</ons-list-item>

        <ons-list-header>Thumbnails and titles</ons-list-header>
        <ons-list-item>
          <div class="left">
            <img class="list-item__thumbnail" src="http://placekitten.com/g/40/40">
          </div>
          <div class="center">
            <span class="list-item__title">Cutest kitty</span><span class="list-item__subtitle">On the Internet</span>
          </div>
        </ons-list-item>

        <ons-list-header>Icons</ons-list-header>
        <ons-list-item>
          <div class="left">
            <ons-icon icon="md-face" class="list-item__icon"></ons-icon>
          </div>
          <div class="center">
            Icon
          </div>
        </ons-list-item>

        <ons-list-header>Switch</ons-list-header>
        <ons-list-item>
          <div class="center">
            Turn it on
          </div>
          <div class="right">
            <ons-switch></ons-switch>
          </div>
        </ons-list-item>

        <ons-list-header>Switch and icon</ons-list-header>
        <ons-list-item>
          <div class="left">
            <ons-icon icon="md-face" class="list-item__icon"></ons-icon>
          </div>
          <div class="center">
            Icon and switch
          </div>
          <div class="right">
            <ons-switch></ons-switch>
          </div>
        </ons-list-item>

        <ons-list-header>No divider</ons-list-header>
        <ons-list-item modifier="nodivider">Item A</ons-list-item>
        <ons-list-item modifier="nodivider">Item B</ons-list-item>

        <ons-list-header>Long divider</ons-list-header>
        <ons-list-item modifier="longdivider">Item A</ons-list-item>
        <ons-list-item modifier="longdivider">Item B</ons-list-item>
      </ons-list>

      <br />

      <ons-list modifier="inset">
        <ons-list-header>Inset list</ons-list-header>
        <ons-list-item modifier="longdivider">Item A</ons-list-item>
        <ons-list-item modifier="longdivider">Item B</ons-list-item>
      </ons-list>

      <br />
    </ons-page>
  </ons-template>

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
