<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }

 $error = false;

 if( isset($_POST['btn-login']) ) {

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs

  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }

  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }

  // if there's no error, continue to login
  if (!$error) {

   $password = hash('sha256', $pass); // password hashing using SHA256
   echo $password;

   $res=mysqli_query($conn, "SELECT id_user, name, password FROM users WHERE email='$email'");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
   if( $count == 1 && $row['password']==$password ) {
    $_SESSION['user'] = $row['id_user'];
    $simpanid = $row['id_user'];
    //echo $row['id_user'];
    header("Location: home.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }

  }

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
          .load('./home.php') 
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

    /*(function (window, $) {
  
      $(function() {
        
        
        $('.ripple').on('click', function (event) {
          event.preventDefault();
          
          var $div = $('<div/>'),
              btnOffset = $(this).offset(),
              xPos = event.pageX - btnOffset.left,
              yPos = event.pageY - btnOffset.top;
          

          
          $div.addClass('ripple-effect');
          var $ripple = $(".ripple-effect");
          
          $ripple.css("height", $(this).height());
          $ripple.css("width", $(this).height());
          $div
            .css({
              top: yPos - ($ripple.height()/2),
              left: xPos - ($ripple.width()/2),
              background: $(this).data("ripple-color")
            }) 
            .appendTo($(this));

          window.setTimeout(function(){
            $div.remove();
          }, 2000);
        });
        
      });
      
    })(window, jQuery);*/

  </script>
</head>
  <body>
      
    <ons-page>
      
      <ons-toolbar>
        <div class="center">
          SAMS Login
        </div>
      </ons-toolbar>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        <div class="col-md-12">
          <?php
            if ( isset($errMSG) ) {
          ?>          
            <?php echo $errMSG; ?>          
          <?php
            }
          ?>          
        

          <div style="text-align: center; margin-top: 70px;">
            <p>
              <!--<ons-input id="username" modifier="underbar" type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" float/></ons-input>-->
              <ons-input id="username" modifier="underbar" type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" float/>
            </p>
            <p>
              <?php echo $emailError; ?>
            </p>
            <p>
              <!--<ons-input id="password" modifier="underbar" type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" float></ons-input>-->
              <ons-input id="password" modifier="underbar" type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" float/>
            </p>
            <p>
              <?php echo $passError; ?>
            </p>
            <p style="margin-top: 30px;">
              <button type="submit" class="button" name="btn-login">Sign In</button>
              <!--<ons-button type="submit" name="btn-login" onclick="login()">Sign in</ons-button>-->
            </p>
            <p>
              <label><a class="button2" href="register.php">Sign Up Here...</a></label>
            </p>
          </div>
    
        </div>
      </form>
    </ons-page>
  </body>
</html>
