<?php
session_start ();
$tampil=1;
$akses="publik";
$negara="indonesia";
$bahasa="id";
$lisensi="www.mysch.id";
$folder="cms";

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
$link_kategori_psb_daftar=$link;
if (empty($_SESSION['nisn']) or empty($_SESSION['pword'])) { $akses=="publik";} else { $akses="member"; }
	
$subdomain="www.ypippijkt.localhost";
$linksub="www.ypippijkt.localhost";
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
include("$folder/module/psb_metatag.php");
$theme=$dsetting['theme'];  if ($theme=="") { $theme="evoblue"; }

//cek psb_setting
$tanggal_psb_tutup=false;
$query=$db->query(" SELECT tanggal_tutup,jam_tutup FROM psb_setting WHERE subdomain='".$subdomain."'");
if($query->num_rows){
    if($query->row['tanggal_tutup']!="0000-00-00" && $query->row['jam_tutup']!="00:00:00"){
        $tanggal_psb_tutup=$query->row['tanggal_tutup']." ".$query->row['jam_tutup'];
        
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<meta name="title" content="PSB <?php echo $judulweb;?>"/>
	<meta name="description" content="penerimaan siswa baru <?php echo $deskripsi;?>"/>
	<meta name="keywords" content="psb, ppdb, penerimaan siswa baru, penerimaan peserta didik baru, <?php  echo $kata_kunci;?>"/>
	<meta name="copyright" content="<?php echo $lisensi;?>"/>	
	<meta name="author" content="<?php echo $lisensi;?>"/>	
	<meta name="geo.placename" content="<?php echo $negara;?>"/>
	<meta name="geo.country" content="<?php echo $bahasa;?>"/>
	<meta name="content-language" content="<?php echo $bahasa;?>"/>
	<link rel="shortcut icon" href="//<?php echo $domain."/picture/".$favicon;?>"/>
	<link  rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/theme/<?php echo $theme;?>/style.css"/>
	<link  rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/font/font.css"/>
	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.min.js"></script>			
	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/ajax.js"></script>
	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/nicEdit.js"></script>
	<script type="text/javascript">bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('editor');});</script>
	<title>PSB <?php echo $judulweb;?></title>
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
			<header><div id="head" style="border-bottom:1px solid #DADADA;"><center><div class="head"><?php include ("$folder/module/psb_header.php");?></div></center></div></header><?php
			if ($link=="") { if (empty($_SESSION['uname']) and empty($_SESSION['pword'])) {	 include ("$folder/module/psb_banner.php"); } } ?>
			<div id="main"><center><div class="main"><?php include ("$folder/module/psb_main.php");?></div></center></div>
			<footer id="foot"><center><div class="foot"><?php echo $footer;?><br/>Designed by : <a href="//<?php echo $lisensi;?>" target="_blank" title="<?php echo $lisensi;?>"><?php echo $lisensi;?></a></div></center></footer>
		</div>
		</center>
		<?php 
		if($link_kategori_psb_daftar=='daftar'){
		    if($tanggal_psb_tutup){ 
    		    if(time() > strtotime($tanggal_psb_tutup)){ ?>
    		        <script>
    		            $(function(){
    		                var html='';
    		                html+='<div style="text-align:left">';			
    		                html+='<h2>Pendaftaran Telah Ditutup</h2>';
    			                html+='Maaf, Pendaftaran PPDB Online Telah ditutup sejak <b><?php echo $tanggal_psb_tutup;?> WIB</b>';	
    			            html+=' </div>';
    		                $(".main").html(html);
    		            });
    		        </script> <?php
    		    }
    		}
		}
		
		?>
	</body>
</html>
<?php mysqli_close($koneksi); ?>