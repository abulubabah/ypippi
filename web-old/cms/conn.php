<?php
// if($_SERVER['HTTPS']!="on") { 
//     if(preg_match('/^www./',$_SERVER['HTTP_HOST'])){
//         $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//     } else {
//         $redirect = "https://www.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//     }

//     header("HTTP/1.1 301 Moved Permanently");
//     header("Location:$redirect"); 

//     exit;
// } 

// if(!preg_match('/^www./',$_SERVER['HTTP_HOST'])){
//     $redirect = "https://www.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//     header("HTTP/1.1 301 Moved Permanently");
//     header("Location: $redirect");

//     exit;
// }

// error_reporting(0);




$host = "localhost";
$user = "k0613344_ypippijkt";
$pass = "ypippijkt";
$db = "k0613344_ypippijkt_old";
// $user = "root";
// $pass = "";
// $db = "dbypippijkt";
$error = "<marquee>MOHON MAAF,Server Dalam Proses Upgrade Untuk Meningkatkan Pelayanan Bagi Pengguna Mysch.id Silahkan Kunjungi Beberapa Saat Lagi!</marquee>";

$koneksi = mysqli_connect($host,$user,$pass) or die($error);
mysqli_select_db($koneksi, $db) or die($error);
define('APP_ID', '1856646884561707');
define('APP_SECRET', '030455a77fc4961cc3a6dcd5fb632058');
$base_folder = "";
define ('DIR_CACHE','cms/dbcache/');
include_once ('cms/function/mpdo.php');
include_once ('cms/function/filemanager.php');
$filemanager = new FileManager();
$db = new mPDO($host,$user,$pass,$db);

define("USERNAME_WHMCS","");
define("PASSWORD_WHMCS","");
define("URL_API_WHMCS","");
define("AUTH","");
define("URL_AUTH","");

define("DIR_PICTURE","cms/picture/");
define("DIR_IMAGECACHE","cms/imagecache/");
include_once ('cms/function/uploader.php');
include_once ('cms/function/resize.php');
include_once ('cms/function/validasi.php');

$uploader = new Uploader();
$resize = new Resize();

clearstatcache();
?>