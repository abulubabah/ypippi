<?php
session_start ();
$tampil=1;
$akses="publik";
$negara="indonesia";
$bahasa="id";
$lisensi="www.mysch.id";
$folder="cms";
$linkcdn="storage.googleapis.com/s.mysch.id";
$smtp_host='smtp.gmail.com';
$smtp_connection_type='ssl';
$smtp_port=465;
$smtp_username='smtpsistem@gmail.com';
$smtp_password=31031997;
$smtp_emailsistem='info@www.ypippijkt.localhost';

if (empty($_GET['link'])) { $link=""; } else { $link=strtok($_GET['link'],"'"); }
if (empty($_GET['kategori'])) { $kategori=""; } else { $kategori=strtok($_GET['kategori'],"'"); }
if (empty($_GET['no'])) { $no=""; } else { $no=strtok($_GET['no'],"'"); }
if (empty($_GET['linkhal'])) { $linkhal=""; } else { $linkhal=strtok($_GET['linkhal'],"'"); }
if (empty($_GET['act'])) { $act=""; } else { $act=strtok($_GET['act'],"'"); }
if (empty($_GET['page'])) { $page=""; } else { $page=strtok($_GET['page'],"'"); }

if (empty($_SESSION['uname']) or empty($_SESSION['pword'])) { $akses=="publik";} else { $akses="member"; }
	
$subdomain="www.ypippijkt.localhost";
$linksubasli="www.ypippijkt.localhost";
$linksub="www.ypippijkt.localhost/simpen";
$domain="www.ypippijkt.localhost/cms";

include ("$folder/conn.php");
$qsetting=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
$jsetting=mysqli_num_rows($qsetting);
$dsetting=mysqli_fetch_array($qsetting);
$unameakun=$dsetting['username'];
$deskripsi=$dsetting['deskripsi'];
$namaweb=$dsetting['judul'];
$subnamaweb=$dsetting['subjudul'];
$judulweb=$dsetting['judul'];
$kata_kunci=$dsetting['kata_kunci'];
$tipe_header=$dsetting['tipe_header'];
$header=$dsetting['header']; if ($header=="") { $header="header.jpg"; }
$logo=$dsetting['logo']; if ($logo=="") { $logo="logo.png"; }
$header_kanan=$dsetting['header_kanan']; 
$footer=$dsetting['footer']; 
$kolom=$dsetting['kolom'];
$favicon=$dsetting['favicon']; if ($favicon=="") { $favicon="favicon.png"; } 

if ($akses=="admin")  {
	if ($link=="") { $judulweb="Halaman Admin"; }
	else { 
		$qhalaman=mysqli_query($koneksi, "SELECT * FROM halamanadmin WHERE module='$link'"); $dhalaman=mysqli_fetch_array($qhalaman); 
		if (empty($act)) { $judulweb="Manajemen ".$dhalaman['judul']; } else { $judulweb=$act." ".$dhalaman['judul']; }
	}	
}
else {
	if($link==""){ $judulweb="Simpen ".$judulweb;  }
	elseif ($link=="panduan")  { $judulweb="Panduan Simpen"; }
	elseif ($link=="kontak")  { $judulweb="Kontak Kami"; }
	elseif ($link=="tentang")  { $judulweb="Tentang Simpen"; }
	elseif ($link=="lihat")  { $judulweb="Lihat Hasil"; }
	elseif ($link=="cetak")  { $judulweb="Cetak Hasil"; }
}
$theme=$dsetting['theme'];  if ($theme=="") { $theme="evoblue"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<meta name="title" content="PSB <?php echo $judulweb;?>"/>
	<meta name="description" content="pengumuman ujian online <?php echo $deskripsi;?>"/>
	<meta name="keywords" content="simpen, pengumuman ujian, pengumuman ujian online , <?php  echo $kata_kunci;?>"/>
	<meta name="copyright" content="<?php echo $lisensi;?>"/>	
	<meta name="author" content="<?php echo $lisensi;?>"/>	
	<meta name="geo.placename" content="<?php echo $negara;?>"/>
	<meta name="geo.country" content="<?php echo $bahasa;?>"/>
	<meta name="content-language" content="<?php echo $bahasa;?>"/>
	<link rel="shortcut icon" href="//<?php echo $domain."/picture/".$favicon;?>"/>
	<link  rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/theme/<?php echo $theme;?>/style.css"/>
	<link  rel="stylesheet" type="text/css" href="//<?php echo $linkcdn;?>/font/font.css"/>
        <link  rel="stylesheet" type="text/css" href="//<?php echo $linkcdn;?>/css/jquery.countdown.css"/>
	<script type="text/javascript" src="//<?php echo $linkcdn;?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="//<?php echo $linkcdn;?>/js/jquery.countdown.js"></script>				
	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/ajax.js"></script>
	<title><?php echo $judulweb;?></title>
</head><?php 
	if ($link=="logout") { 
		unset($_SESSION['nama']);
		unset($_SESSION['uname']);
		unset($_SESSION['pword']);
		unset($_SESSION['kat']); ?>
		<meta http-equiv="refresh" content="0; url=//<?php echo $linksub;?>"/><?php
	} 
	include ("$folder/function/function.ppdb.php"); ?>
	<body>
		<center>
		<div id="container">
			<div id="head">
				<center>
				<div class="head" style="margin-top:10px;text-align:left;">
					<a href="//<?php echo $linksub;?>">
					<img src="//<?php echo $domain."/picture/".$logo;?>" height="90" alt="Logo" align="left" style="margin:0px 15px 0px 0px;">
					<span style="font-size:16px;">Sistem Informasi Pengumuman Online</span>
					<h1><?php echo $namaweb;?></h1>
					<span style="font-size:18px;"><?php echo $subnamaweb;?></span>
					</a>			
				</div>
				</center>
			</div>
			<div id="menu">
				<center>
				<div class="menu">
				<nav style="float:right;display:table;width:100%;"> 
					<label for="drop" class="toggle"><img src="//<?php echo $domain."/image/menu3.png";?>" align="left" style="margin:10px 6px 0px 6px;" alt="MENU">MENU</label>
					<input type="checkbox" id="drop" />
					<ul class="menu3">
						<li><a href="//<?php echo $linksub;?>/" title="Beranda">Beranda</a></li><?php
						//$_SESSION['uname']="admin";
						//$_SESSION['nisn']="123456789";
						//$_SESSION['pword']="admin";			
						if (empty($_SESSION['uname']) and empty($_SESSION['pword'])) {	?>
							<li><a href="//<?php echo $linksub;?>/panduan/" title="Panduan">Panduan</a></li>
							<li><a href="//<?php echo $linksub;?>/kontak/" title="Kontak Kami">Kontak Kami</a></li>
							<li><a href="//<?php echo $linksub;?>/tentang/" title="Tentang Simpen">Tentang Simpen</a></li><?php
						}
						else {
							$uname=$_SESSION['uname'];?>
							<li><a href="//<?php echo $linksub;?>/lihat/" title="Lihat Hasil">Lihat Hasil</a></li>
							<li><a href="//<?php echo $linksubasli;?>/simpen_cetak.php" target="_blank" title="Cetak Hasil">Cetak Hasil</a></li>
							<li><a href="//<?php echo $linksub;?>/logout/" title="Keluar" onclick="return confirm ('Yakin Mau Keluar ?')">Keluar</a></li><?php			
						}?>
					</ul>
				</nav>			
				</div>
				</center>
			</div>
			<div id="main">
				<center>
				<div class="main" style="text-align:left;"><?php 
					if($link==""){ $tipemodule="simpen_home"; include("$tipemodule.php"); }
					elseif ($link=="home" or $link=="beranda") { $tipemodule="simpen_home"; include("$tipemodule.php"); }
					elseif ($link=="panduan" or $link=="tentang") { $tipemodule="simpen_halaman"; include("$folder/module/$tipemodule.php"); } 
					elseif ($link=="kontak") { $tipemodule="simpen_kontak"; include("$folder/module/$tipemodule.php"); } 
					elseif ($link=="lihat") { $tipemodule="simpen_lihat"; include("$tipemodule.php"); } 
					elseif ($link=="cetak") { $tipemodule="simpen_cetak"; include("$tipemodule.php"); } 
					else {	 $tipemodule="simpen_home"; include("$tipemodule.php"); }  ?>			
				</div>
				</center>
			</div>
			<div id="foot"><center><div class="foot"><?php echo $footer;?><br/>Designed by : <a href="//<?php echo $lisensi;?>" target="_blank" title="<?php echo $lisensi;?>"><?php echo $lisensi;?></a></div></center></div>
		</div>
		</center>					
	</body>
</html>
<?php mysqli_close($koneksi); ?>