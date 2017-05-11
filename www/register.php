<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: home.php");
 }
 include_once 'dbconnect.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {

  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  }

  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT email FROM users WHERE email='$email'";
   $result = mysqli_query($conn, $query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }

  // password encrypt using SHA256();
  $password = hash('sha256', $pass);

  // if there's no error, continue to signup
  if( !$error ) {

   $query = "INSERT INTO users(name,email,password) VALUES ('$name','$email','$password')";
   $res = mysqli_query($conn, $query);

   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now";
    unset($name);
    unset($email);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Registration failed";
   }

  }


 }
?>
<!DOCTYPE html>
<html>
<head>
    <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Coding Cage - Login & Registration System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
    <link rel="stylesheet" href="style.css" type="text/css" />-->
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

        (function (window, $) {

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
            
        })(window, jQuery);
    </script>
</head>
    <body>
        <ons-page>
            <ons-toolbar>
                <div class="center">
                    SAMS Sign Up
                </div>
            </ons-toolbar>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <div class="col-md-12">
                    <?php
                        if ( isset($errMSG) ) {
                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <div style="text-align: center; margin-top: 70px;">
                    <p>
                        <!--<ons-input id="username" modifier="underbar" type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" float/></ons-input>-->
                        <ons-input id="name" modifier="underbar" type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" float/>
                    </p>
                    <p>
                        <?php echo $nameError; ?>
                    </p>
                    <p>
                        <!--<ons-input id="username" modifier="underbar" type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" float/></ons-input>-->
                        <ons-input id="username" modifier="underbar" type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" float/>
                    </p>
                    <p>
                        <?php echo $emailError; ?>
                    </p>
                    <p>
                        <!--<ons-input id="password" modifier="underbar" type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" float></ons-input>-->
                        <ons-input id="password" modifier="underbar" type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" float/>
                    </p>
                    <p>
                        <?php echo $passError; ?>
                    </p>
                    <p style="margin-top: 30px;">
                        <button type="submit" class="button" name="btn-signup">Sign Up</button>
                        <!--<ons-button type="submit" name="btn-login" onclick="login()">Sign in</ons-button>-->
                    </p>
                    <p>
                        <a class="" href="index.php">Sign In Here...</a>
                    </p>
                    </div>                    
                </div>
            </form>
            
        </ons-page>
        
    </body>
</html>
<?php ob_end_flush(); ?>
