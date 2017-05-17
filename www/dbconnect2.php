<?php

 // this will avoid mysqli_connect() deprecation error.
 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 // but I strongly suggest you to use PDO or mysqlii.

 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'sams');

 $conn = mysqli_connect(DBHOST,DBUSER,DBPASS);
 $dbcon = mysqli_select_db($conn, DBNAME);

 if ( !$conn ) {
  die("Connection failed : " . mysqli_error($conn));
 }

 if ( !$dbcon ) {
  die("Database Connection failed : " . mysqli_error($conn));
 }
