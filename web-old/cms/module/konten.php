<?php    
if ($tampil==1) {  
	if($link==""){ $tipemodule="home"; }
	elseif ($link=="home" or $link=="beranda") { $tipemodule="home"; }
	elseif ($link=="cari") { $tipemodule="cari"; } 
	elseif ($link=="lupapassword") { $tipemodule="lupapassword"; }
	else {	
		if ($no=="")  {
			$qhalaman=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe FROM halaman WHERE link='$link' AND subdomain='$subdomain'"); 
			$dhalaman=mysqli_fetch_array($qhalaman);
			$halno=$dhalaman['no'];
			$haljudul=$dhalaman['judul'];
			$haltipe=$dhalaman['tipe'];		
			$halidtipe=$dhalaman['idtipe'];
			if ($haltipe=="tulis") { $tipemodule="halaman"; } 
			elseif ($haltipe=="berita") { $tipemodule="halaman"; } 
			else { 
				$qhaltipe=mysqli_query($koneksi, "SELECT no FROM halamantipe WHERE tipe='$haltipe'");
				$jhaltipe=mysqli_num_rows($qhaltipe);
				if ($jhaltipe==1) { $tipemodule=$haltipe; } 
				else {  
					$qlinktipe=mysqli_query($koneksi, "SELECT tipe FROM halamantipe WHERE link='$link'");
					$jlinktipe=mysqli_num_rows($qlinktipe);
					$dlinktipe=mysqli_fetch_array($qlinktipe);
					if ($jlinktipe>=1) { $tipemodule=$dlinktipe['tipe'];  } else { $tipemodule="error";   } 
				}
			}
		}
		else {		
			$qhalaman=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe FROM halaman WHERE link='$link' AND subdomain='$subdomain'"); 
			$dhalaman=mysqli_fetch_array($qhalaman);
			$halno=$dhalaman['no'];
			$haljudul=$dhalaman['judul'];
			$haltipe=$dhalaman['tipe'];		
			$halidtipe=$dhalaman['idtipe'];
			if ($haltipe=="tulis") { $tipemodule="halaman"; } 
			else {
				$qhaltipe=mysqli_query($koneksi, "SELECT no FROM halamantipe WHERE tipe='$haltipe'");
				$jhaltipe=mysqli_num_rows($qhaltipe);
				if ($jhaltipe==1) { $tipemodule=$haltipe; } 
				else {  					
					$qlinktipe=mysqli_query($koneksi, "SELECT tipe FROM halamantipe WHERE link='$link'");
					$jlinktipe=mysqli_num_rows($qlinktipe);
					$dlinktipe=mysqli_fetch_array($qlinktipe);
					if ($jlinktipe>=1) { $tipemodule=$dlinktipe['tipe']; } else { $tipemodule="error"; } 
				}
			}
		}
	} 
	include("$folder/module/$tipemodule.php");
}
else {
	header("location:index.php"); 
}
?>