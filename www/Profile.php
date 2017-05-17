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
 $simpanid = $_SESSION['user'];
 $cek=mysqli_query($conn, "SELECT * FROM users WHERE id_user = $simpanid");
 $row=mysqli_fetch_array($cek);
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
                Profile
            </div>
        </ons-toolbar>
        <div class="col-md-12">
            <div style="text-align: center; margin-top: 0px;">
                <ons-list>
                    <ons-list-header>Profile</ons-list-header>
                    <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
                        <div class="left">
                            <img class="list-item__thumbnail" src="https://pbs.twimg.com/profile_images/734356375665418244/TPPPHIfI.jpg"  style="height: 100px; width: 100px;" />
                        </div>
                        <div class="center">
                            <span class="list-item__title">&nbsp&nbsp&nbsp&nbsp</span>
                        </div>
                        <div class="center">
                            <span class="list-item__title">Nama</span><span class="list-item__subtitle"><?php echo $row['name']?></span>
                        </div>
                    </ons-list-item>
                    <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
                        <div class="center">
                            <span class="list-item__title">ID</span><span class="list-item__subtitle"><?php echo $row['id_user'] ?></span>
                        </div>
                    </ons-list-item>
                    <ons-list-item tappable onclick="ons.notification.alert('COMING SOON AS POSSIBLE')">
                        <div class="center">
                            <span class="list-item__title">Registered Email</span><span class="list-item__subtitle"><?php echo $row['email']?></span>
                        </div>
                    </ons-list-item>
                </ons-list>
            </div>
        </div>
    </ons-page>
</body>
</html>
