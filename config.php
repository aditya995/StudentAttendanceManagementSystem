<?php
/* for local installation */
$host = 'localhost';
$user = 'root';
$password = '';
$dbname ='data';

/* for original Web server *

$host = 'localhost';
$user = '1373190';
$password = 'adityadnj';
$dbname ='1373190';
/*************/

/* for original Web server 

http://ams-proj001.infinityfreeapp.com/ *
$host = 'sql212.epizy.com';
$user = 'epiz_29875699';
$password = 'GZkJU2aapigNio';
$dbname ='epiz_29875699_55';
/*************/

//Set DSN ( Data source name )
$dsn = 'mysql:host='. $host .';dbname='. $dbname;

// Create a PDO instance ( PHP data object )
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
