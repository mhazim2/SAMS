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
		<a href=Home.php> back </a>
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
			echo '<script>window.history.back()</script>';

		}else{

			//jika data ditemukan, maka membuat variabel $data
			$data = mysqli_fetch_assoc($show);	//mengambil data ke database yang nantinya akan ditampilkan di form edit di bawah

		}
		?>
		<ons-page id="tambahAgenda">
			<ons-toolbar>
				<div class="left"><a href="home.php"><ons-back-button >Back</ons-back-button></a></div>
				<div class="center">
					Tambah Agenda
				</div>
			</ons-toolbar>
				<form action="edit-proses.php" method="post">		
					<div class="col-md-12">
						<div  style="text-align: center; margin-top: 70px;">
							<input type="hidden" name="id" value="<?php echo $id; ?>"/>
							<p>
								<ons-input id="subject" modifier="underbar" type="text" name="subject" value="<?php echo $data['subject']; ?>" class="form-control" placeholder="Subject" size="33" float required/>
							</p>
							<p>
								<ons-input id="place" modifier="underbar" type="text" name="place" value="<?php echo $data['place']; ?>" class="form-control" placeholder="Place" size="33" float required/>
							</p>
							<p>
								<ons-input id="namefriend" modifier="underbar" type="text" name="namefriend" class="form-control" placeholder="Invite Friend" size="33" float/>
							</p>
							<p>
								<ons-input id="timeagenda" modifier="underbar" type="time" name="timeagenda" value="<?php echo $data['time_agenda']; ?>" class="form-control" size="33" required/>
							</p>
							<p>
								<ons-input id="dateagenda" modifier="underbar" type="date" name="dateagenda" value="<?php echo $data['date_agenda']; ?>" class="form-control" size="33" required/>
							</p>
							<p>
								<section style="padding: 0 8px 8px">
								<textarea class="textarea" type="textarea" name="description" value="<?php echo $data['description']; ?>" style="width: 80%; height: 120px;"></textarea>
								</section>
							</p>
							<p>
								<ons-input class="button" type="submit" name="simpan" value="Simpan" float/>
							</p>
						</div>
					</div>
				</form>
		</ons-page>
	</body>
</html>
