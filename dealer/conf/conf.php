<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (!defined('homeUrl')) define('homeUrl', 'http://' .$_SERVER['HTTP_HOST']. '/dealer-php-native/');
if (!defined('EOL')) define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../vendor/PHPExcel/Classes/PHPExcel.php';

$servername = 'localhost';
$username   = 'root';
$password   = '';
$dbname     = 'dealer';

$options    = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $conn   = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    break;
}
