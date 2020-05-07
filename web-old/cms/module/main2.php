<?php  
if ($tampil==1) { 
	if($link==""){ $tipemodule="home"; }
	elseif ($link=="home" or $link=="beranda") { $tipemodule="home"; }
	elseif ($link=="cari") { $tipemodule="cari"; }
	else {
		if ($haltipe=="tulis") { $tipemodule="halaman"; } 
		elseif ($haltipe=="artikel") { $tipemodule="halaman"; } 
		else { 
			$qhaltipe=mysqli_query($koneksi, "SELECT no FROM halamantipe WHERE tipe='$haltipe'");
			$jhaltipe=mysqli_num_rows($qhaltipe);
			if ($jhaltipe==1) { $tipemodule=$haltipe; } 
			else {  
				$qlinktipe=mysqli_query($koneksi, "SELECT tipe FROM halamantipe WHERE link='$link'");
				$jlinktipe=mysqli_num_rows($qlinktipe);
				$dlinktipe=mysqli_fetch_array($qlinktipe);
				if ($jlinktipe==1) { $tipemodule=$dlinktipe['tipe']; } else { $tipemodule="error"; } 
			}
		}
	} 
	include("$folder/module/$tipemodule.php");
}
else { 
	header("location:../"); 
}
?>