<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 //require_once 'Index.php';
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: Index.php");
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
<p><a href="Profile.php"> profile </a> / <a href="Invitation.php">Invitation</a> / <a href="Home.php">Agenda</a> / <a href="Contact.php">Contact</a> / <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></p>

<h3>contact</h3>

<table cellpadding="5" cellspacing="0" border="1">
  <tr bgcolor="#CCCCCC">
    <th>No.</th>
    <th>id</th>
    <th>nama</th>
    <th>email</th>
  </tr>

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

  <ons-splitter-content id="content" page="Contact.php"></ons-splitter-content>

<a href="tambahcontact.php">tambah contact</a>
<a href="home.php">Home</a>
</ons-splitter>
</body>
</html>
<?php ob_end_flush(); ?>
