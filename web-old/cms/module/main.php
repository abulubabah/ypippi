<?php  
if ($tampil==1) { 
    
	if($kolom==2){  
		$qside=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND (posisi='side' OR posisi='left' OR posisi='right') AND publish='1' ORDER BY urutan");
		$jumside=mysqli_num_rows($qside);
		if ($jumside==0) { $stylemainbar="mainbarfull"; $stylesidebar=""; } else { $stylemainbar="mainbar2"; $stylesidebar="sidebar2";} ?>
		<div class="<?php echo $stylemainbar;?>" ><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='main' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="home"; $stylejudul="home_judul"; $styleisi="home_isi";
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>							
		</div>
		<aside class="<?php echo $stylesidebar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul  FROM module WHERE subdomain='$subdomain' AND (posisi='side' OR posisi='left' OR posisi='right') AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside><?php
	}
	elseif ($kolom==3) {
		$qleft=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND (posisi='left' OR posisi='side') AND publish='1' ORDER BY urutan");
		$jleft=mysqli_num_rows($qleft);
		$qright=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND posisi='right' AND publish='1' ORDER BY urutan");
		$jright=mysqli_num_rows($qright);
		if ($jleft==0 and $jright==0)  { $stylemainbar="mainbarfull"; $styleleftbar=""; $stylerightbar=""; }
		elseif ($jleft==0 and $jright!=0) { $stylemainbar="mainbar"; $styleleftbar=""; $stylerightbar="sidebar"; }
		elseif ($jleft!=0 and $jright==0) { $stylemainbar="mainbar2"; $styleleftbar="sidebar2"; $stylerightbar=""; }
		else { $stylemainbar="halfbar"; $styleleftbar="leftbar"; $stylerightbar="rightbar"; } ?>
		<div class="<?php echo $stylemainbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul  FROM module WHERE subdomain='$subdomain' AND posisi='main' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="home"; $stylejudul="home_judul"; $styleisi="home_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</div>
		<aside class="<?php echo $styleleftbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND (posisi='left' OR posisi='side') AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside>								
		<aside class="<?php echo $stylerightbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='right' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside><?php	
	}
	elseif ($kolom==4) {
		$qleft=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND (posisi='left' OR posisi='side') AND publish='1' ORDER BY urutan");
		$jleft=mysqli_num_rows($qleft);
		$qright=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND posisi='right' AND publish='1' ORDER BY urutan");
		$jright=mysqli_num_rows($qright);
		if ($jleft==0 and $jright==0)  { $stylemainbar="mainbarfull"; $styleleftbar=""; $stylerightbar=""; }
		elseif ($jleft==0 and $jright!=0) { $stylemainbar="mainbar"; $styleleftbar=""; $stylerightbar="sidebar"; }
		elseif ($jleft!=0 and $jright==0) { $stylemainbar="mainbar2"; $styleleftbar="sidebar2"; $stylerightbar=""; }
		else { $stylemainbar="halfbar2"; $styleleftbar="leftbar2"; $stylerightbar="rightbar2"; } ?>
		<div class="<?php echo $stylemainbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='main' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="home"; $stylejudul="home_judul"; $styleisi="home_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</div>
		<aside class="<?php echo $styleleftbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND (posisi='left' OR posisi='side') AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside>								
		<aside class="<?php echo $stylerightbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='right' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside><?php	
	}
	elseif ($kolom==5) { 
		$qleft=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND (posisi='left' OR posisi='side') AND publish='1' ORDER BY urutan");
		$jleft=mysqli_num_rows($qleft);
		$qright=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND posisi='right' AND publish='1' ORDER BY urutan");
		$jright=mysqli_num_rows($qright);
		if ($jleft==0 and $jright==0)  { $stylemainbar="mainbarfull"; $styleleftbar=""; $stylerightbar=""; }
		elseif ($jleft==0 and $jright!=0) { $stylemainbar="mainbar"; $styleleftbar=""; $stylerightbar="sidebar"; }
		elseif ($jleft!=0 and $jright==0) { $stylemainbar="mainbar2"; $styleleftbar="sidebar2"; $stylerightbar=""; }
		else { $stylemainbar="halfbar3"; $styleleftbar="leftbar3"; $stylerightbar="rightbar3"; } ?>
		<div class="<?php echo $stylemainbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='main' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="home"; $stylejudul="home_judul"; $styleisi="home_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</div>
		<aside class="<?php echo $styleleftbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND (posisi='left' OR posisi='side') AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside>								
		<aside class="<?php echo $stylerightbar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='right' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside><?php	
	}
	else {
		$qside=mysqli_query($koneksi, "SELECT no FROM module WHERE subdomain='$subdomain' AND (posisi='side' OR posisi='left' OR posisi='right') AND publish='1' ORDER BY urutan");
		$jumside=mysqli_num_rows($qside);
		if ($jumside==0) { $stylemainbar="mainbarfull"; $stylesidebar=""; } else { $stylemainbar="mainbar"; $stylesidebar="sidebar";} ?>
		<div class="<?php echo $stylemainbar;?>" ><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='main' AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="home"; $stylejudul="home_judul"; $styleisi="home_isi";
				// echo "pratamad " . $layouttipe . " " . $domain . "; ";
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>							
		</div>
		<aside class="<?php echo $stylesidebar;?>"><?php 
			$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND (posisi='side' OR posisi='left' OR posisi='right') AND publish='1' ORDER BY urutan");
			while($dlayout=mysqli_fetch_array($qlayout)){
				$layoutno=$dlayout['no'];
				$layoutjudul=$dlayout['judul'];
				$layouttipe=$dlayout['tipe'];
				$layoutidtipe=$dlayout['idtipe'];
				$layouttampilan=$dlayout['tampilan_tipe'];
				$layouthal=$dlayout['hal'];
				$layoutposisi=$dlayout['posisi'];
				$layouttampiljudul=$dlayout['tampilkan_judul'];
				$stylepanel="panel"; $stylejudul="panel_judul"; $styleisi="panel_isi";									
				if($layouthal=="home") {
					if (empty($link)) { include("$folder/module/$layouttipe.php"); }
					elseif ($link=="home" or $link=="beranda") { include("$folder/module/$layouttipe.php"); }
				}
				else {
					include("$folder/module/$layouttipe.php");
				}
			} ?>
		</aside><?php
	} 
}
else { 
	header("location:../"); 
}
?>