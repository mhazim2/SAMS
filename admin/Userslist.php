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

 $dataadmin=mysqli_query($conn, "SELECT * FROM admin");
 $dataadminrow=mysqli_fetch_array($dataadmin);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>SAMS ADMIN</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    SAMS
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="Agendalist.php">
                        <i class="pe-7s-note2"></i>
                        <p>Agenda List</p>
                    </a>
                </li>
                <li class="active">
                    <a href="Userslist.php">
                        <i class="pe-7s-note2"></i>
                        <p>Users List</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
		<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Users List</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <p>
                  Admin bio
                  <b class="caret"></b>
                </p>
                            </a>
                            <ul class="dropdown-menu">
                              <li><b>Name :</b></li>
                              <li><?php echo "  ". $dataadminrow['name_admin']; ?></li>
                              <li><b>Email :</b></li>
                              <li><?php echo "  ". $dataadminrow['email_admin'] ?></li>
                            </ul>
                      </li>
                        <li>
                            <a href="logout.php?logout">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="header">
                                <h4 class="title">Users</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
																			<th>No.</th>
                                      <th>ID</th>
                                    	<th>Name</th>
                                    	<th>Email</th>
                                    </thead>
                                    <tbody>
																			<?php
                                      //iclude file koneksi ke database
																			include('dbconnect.php');
																			$simpanid = $_SESSION['user'];
																			//query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
																			$query = mysqli_query($conn, "SELECT * FROM agenda") or die(mysqli_error());

																			//query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
																			$query = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error());

																			//cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
																			if(mysqli_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong

																				//jika data kosong, maka akan menampilkan row kosong
																				echo '<tr><td colspan="6">Tidak ada Users!</td></tr>';

																			}else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)

																				//jika data tidak kosong, maka akan melakukan perulangan while
																				$no = 1;	//membuat variabel $no untuk membuat nomor urut
																				while($data = mysqli_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database

																					//menampilkan row dengan data di database
																					echo '<tr>';
																						echo '<td>'.$no.'</td>';	//menampilkan nomor urut
																						echo '<td>'.$data['id_user'].'</td>';
																						echo '<td>'.$data['name'].'</td>';
																						echo '<td>'.$data['email'].'</td>';
																						echo '<td class="td-actions text-right">
                                                    <form class="" action="gethapususer.php?id='.$data['id_user'].'"" method="post">
                                                      <button onclick="return confirm(\'Yakin?\')" type="submit" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                      </button>
                                                    </form>
                                                  </td>';	//menampilkan link edit dan hapus dimana tiap link terdapat GET id -> ?id=siswa_id
																					echo '</tr>';

																					$no++;	//menambah jumlah nomor urut setiap row
																				}
																			}
																			?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>


    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>


</html>
