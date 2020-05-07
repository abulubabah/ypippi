<?php 
session_start(); 
$tampil=1;
$akses="admin";
$folder="cms";
include ("$folder/conn.php");
$subdomain="www.ypippijkt.localhost";
$linksub="www.ypippijkt.localhost";
$domain="www.ypippijkt.localhost/cms";
$favicon="favicon.png"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Halaman Admin</title>
    	<link href="//<?php echo $domain;?>/styleadm.css" rel="stylesheet" type="text/css" />
    	<link href="//<?php echo $domain;?>/default.css" rel="stylesheet" type="text/css" />
    	<link  rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/font/font.css"/>
	<link href="//<?php echo $domain."/image/".$favicon;?>" rel="shortcut icon"/>
 	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/ajaxadmin.js"></script>
        <script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.min.js"></script> 
	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/nicEdit.js"></script>
	<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/zebra_datepicker.src.js"></script>
	<script type="text/javascript">bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('editor');});</script>
</head><?php
	function adminlogin ($domain,$subdomain,$linksub,$folder) { 
		include("$folder/function/function.admin.php");
		$module=new admin();
		$module->get_variable();		
		$adm=$module->adm;?>
		<body style="background:#88CCFF">
		<center>
		<div id="formlogin">
			<img src="//<?php echo $domain."/image/logo3.png";?>" alt="Logo"/>
			<h2 style="text-align:center; margin:10px 0px;"><b>LOGIN ADMIN</b></h2>
			<form action="//<?php echo $linksub."/".$adm."/";?>" method="post">
			<input name="proses" type="hidden" value="login">
			<table cellpadding="5" cellspacing="0" width="100%">
				<tr><td width="80">Username</td><td><input type="text" name="username" id="username" style="width:94%; max-width:200px;" maxlength="50"></td></tr>
				<tr><td>Password</td><td><input type="password" name="password" id="password" style="width:94%; max-width:200px;" maxlength="50"></td></tr>
				<tr><td></td><td><input name="submit" type="submit" value="LOGIN" onclick="return cekLogin();" class="button"></td></tr>
			</table>
			</form>
		</div><?php
		$randkode=rand(111111,999999); 
		$_SESSION['kode']=$randkode;
		if (empty($_POST['proses'])) { }
		elseif ($_POST['proses']=="login") {
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
			if (empty($_POST['username']) or empty($_POST['password'])) { header ("location://".$linksub."/".$adm."/");  } 
			else {
				$uname=strip_tags($_POST['username']); $uname=str_replace('"','',$uname); $uname=str_replace("'","",$uname);
				$pword=strip_tags($_POST['password']); $pword=str_replace('"','',$pword); $pword=str_replace("'","",$pword);
				$pass=md5($pword);
                $login="SELECT no,nama,username,password,kategori FROM user WHERE username='".mysqli_real_escape_string($uname)."' AND password='". mysqli_real_escape_string($pass)."' AND subdomain='$subdomain' AND publish='1'";				$query=mysqli_query($koneksi, $login);
				$jumlah=mysqli_num_rows($query);
				$data=mysqli_fetch_array($query);
				$no=$data['no'];
				$nama=$data['nama'];
				$username=$data['username'];
				$password=$data['password'];
				$kategori=$data['kategori'];
				if ($jumlah==1) {
					if($kategori=="admin") {
						$_SESSION['nama']=$nama;
						$_SESSION['uname']=$username;
						$_SESSION['pword']=$password;
						$_SESSION['kat']=$kategori;
						$ipaddress=$_SERVER['REMOTE_ADDR']; 
						mysqli_query($koneksi, "UPDATE user SET last_login=sysdate(), last_ipaddress='$ipaddress' WHERE no='$no'"); ?>
						<meta http-equiv="refresh" content="0; url=//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"><?php
					}
					else { ?><script type="text/javascript"> alert('Username dan Password Salah!');</script><?php }
				} 
				else { ?><script type="text/javascript"> alert('Username dan Password Salah !');</script><?php }
			}
		} ?>
		</center>
		</body><?php
	}


	function adminpage ($domain,$subdomain,$linksub,$folder) { 

		$akses="admin";
		$tampil=1;		
		include("$folder/function/function.admin.php");
		$module=new admin();
		$module->get_variable();		
		$adm=$module->adm; 
		$mod=$module->mod; 
		$act=$module->act;?>
		<body>
		<center>
		<div id="top">
			<center>
			<div class="top">
				<div class="logo"><a href="//<?php echo $linksub."/".$adm;?>/" title="Halaman Admin"><img src="//<?php echo $domain."/image/logo2.png";?>" style="margin:2px 0px;" alt="CMS"/></a></div>
				<div class="logout"><a href="//<?php echo $linksub."/logout/";?>" title="Logout" onclick="return confirm ('Yakin Akan Logout?')"><img src="//<?php echo $domain."/image/out.png";?>" alt="Out" align="right" style="margin:3px 0px 0px 5px;"/>Logout</a></div> 
			</div>
			</center>
		</div>		
		<div id="topmain" style="margin-top:54px;"><center><div class="topmain"><?php include ("$folder/module/adminmenu.php"); ?></div></center></div>
		<div id="main"><center><div class="main"><?php if (empty($mod)) { include ("$folder/module/home.php"); } elseif($mod=="psb_member") { include ("psb_member.php"); }  elseif($mod=="simpen_siswa") { include ("simpen_siswa.php"); } else { include ("$folder/module/$mod.php"); }?></div></center></div>
		</center>
		</body><?php
	}
	
	if (empty ($_SESSION['uname']) or empty ($_SESSION['pword']) or empty ($_SESSION['kat'])) { adminlogin($domain,$subdomain,$linksub,$folder);  }
	else { 
		if ($_SESSION['kat']=="admin" or $_SESSION['kat']=="super") { adminpage($domain,$subdomain,$linksub,$folder); } 
		else { adminlogin($domain,$subdomain,$linksub,$folder);  }
	} mysqli_close($koneksi); 
	?>
</html>