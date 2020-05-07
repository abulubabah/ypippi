<?php
session_start ();
$tampil=1;
$akses="publik";
$negara="indonesia";
$bahasa="id";
$lisensi="www.mysch.id";
$folder="cms";
$linkcdn='storage.googleapis.com/s.mysch.id';
if (empty($_GET['link'])) { $link=""; } else { $link=strtok($_GET['link'],"'"); }
if (empty($_GET['kategori'])) { $kategori=""; } else { $kategori=strtok($_GET['kategori'],"'"); }
if (empty($_GET['no'])) { $no=""; } else { $no=strtok($_GET['no'],"'"); }
if (empty($_GET['linkhal'])) { $linkhal=""; } else { $linkhal=strtok($_GET['linkhal'],"'"); }
if (empty($_GET['act'])) { $act=""; } else { $act=strtok($_GET['act'],"'"); }
if (empty($_GET['page'])) { $page=""; } else { $page=strtok($_GET['page'],"'"); }
		
$subdomain="www.ypippijkt.sch.id";
$linksub="www.ypippijkt.sch.id";
$domain="cms";

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
include("$folder/module/metatag.php");
if (!$og_gambar){
	$og_gambar=$header;
}
$og_url='';
if ($link){
	$og_url.='/'.$link;
}

if ($kategori){
	$og_url.='/'.$kategori;
}

if ($no){
	$og_url.='/'.$no;
}

if ($linkhal){
	$og_url.='/'.$linkhal;
}

if ($act){
	$og_url.='/'.$act;
}

if ($page){
	$og_url.='/'.$page;
}

if (!$og_isi){
	$og_isi=$deskripsi;
}
$theme=$dsetting['theme'];  if ($theme=="") { $theme="evoblue"; }


//get kode tambahan
$codes=array();
if(!is_dir(DIR_CACHE.$subdomain)){
	mkdir(DIR_CACHE.$subdomain,0755);
}

if (file_exists(DIR_CACHE.$subdomain.'/cache.kode_tambahan')){
	$dfile=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.kode_tambahan'),true);
}

if (empty($codes)){
	$query=$db->query("SELECT kode_html FROM kode_tambahan WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC");
	$codes=$query->rows;
	$filemanager->set(DIR_CACHE.$subdomain.'/cache.kode_tambahan',json_encode($codes));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<meta name="title" content="<?php echo $judulweb;?>"/>
	<meta name="description" content="<?php echo $deskripsi;?>"/>
	<meta name="keywords" content="<?php  echo $kata_kunci;?>"/>
	<meta name="copyright" content="<?php echo $lisensi;?>"/>	
	<meta name="author" content="<?php echo $lisensi;?>"/>	
	<meta name="geo.placename" content="<?php echo $negara;?>"/>
	<meta name="geo.country" content="<?php echo $bahasa;?>"/>
	<meta name="content-language" content="<?php echo $bahasa;?>"/>
	<meta property="fb:app_id" content="145000412781544" /> 
	<meta property="og:title" content="<?php echo $judulweb;?>" />
	<meta property="og:description" content="<?php echo $og_isi;?>" />
	<meta property="og:image" content="https://<?php echo $domain."/picture/".$og_gambar;?>"/>
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="600" />
	<meta property="og:image:alt" content="<?php echo $judulweb;?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="https://<?php echo $linksub.$og_url;?>" />
	<link rel="shortcut icon" href="//<?php echo $domain."/picture/".$favicon;?>"/>
	<link  rel="stylesheet" type="text/css" href="//<?php echo $linkcdn."/theme/".$theme;?>/style.css"/>
	<link  rel="stylesheet" type="text/css" href="//<?php echo $linkcdn;?>/font/font.css"/>
	<script type="text/javascript" src="//<?php echo $linkcdn;?>/js/jquery.min.js"></script>			
	<script type="text/javascript" src="//<?php echo $linkcdn;?>/js/ajax.js"></script>
	<?php foreach ($codes as $code_tambahan) { ?>
	<?php echo html_entity_decode($code_tambahan['kode_html'],ENT_QUOTES,'UTF-8'); ?>
	<?php } ?>
	<title><?php echo $judulweb;?></title>
</head><?php 
	if ($link=="logout") { 
		unset($_SESSION['nama']);
		unset($_SESSION['uname']);
		unset($_SESSION['pword']);
		unset($_SESSION['kat']); ?>
		<meta http-equiv="refresh" content="0; url=//<?php echo $linksub;?>"/><?php
	} 
	include ("$folder/function/function.publik.php"); ?>
	<body>
		<center>
		<div id="container">
			<header><div id="head"><center><div class="head"><?php include ("$folder/module/header.php");?></div></center></div></header>
			<nav id="menu"><center><div class="menu"><?php include ("$folder/module/menu.php"); ?></div></center></nav><?php	
			if ($link=="") { ?><div id="top"><center><div class="top"><?php include ("$folder/module/slideshow.php");?></div></center></div><?php } ?>
			<div id="main"><center><div class="main"><?php include ("$folder/module/main.php");?></div></center></div>
			<aside id="bottom"><center><div class="bottom"><?php include ("$folder/module/bottom.php");?></div></center></aside>
			<footer id="foot"><center><div class="foot"><?php echo $footer;?><br/>Designed by : <a href="//<?php echo $lisensi;?>" target="_blank" title="<?php echo $lisensi;?>"><?php echo $lisensi;?></a></div></center></footer>
		</div>
		</center>					
	</body>
</html>
<?php mysqli_close($koneksi); ?>