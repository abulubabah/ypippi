<?php 
function theme ($subdomain,$linksub) {
	$module=new admin(); 
	$module->get_variable ();
	$module->setLinkSub($linksub); 
	$domain=$module->domain; 
	$mod=$module->mod;  
	$adm=$module->adm;  
	$linkmod=$linksub."/".$adm."/".$mod; ?>
	<h2>Tema Desain</h2><?php
	$qset=mysqli_query($koneksi, "SELECT theme FROM setting WHERE subdomain='$subdomain'");
	$dset=mysqli_fetch_array($qset);
	$themepakai=$dset['theme']; 
	$qthemeid=mysqli_query($koneksi, "SELECT judul FROM theme WHERE theme='$themepakai'");
	$dthemeid=mysqli_fetch_array($qthemeid);
	$judulthemeid=$dthemeid['judul'];
	$linkpicttempid=$domain."/theme/".$themepakai."/image.jpg"; ?>
	<div style="padding:10px 0px; border-bottom:1px solid #F0F0F0; text-align:center">
		<h3>TEMA DESAIN YANG SEDANG DIGUNAKAN</h3>
		<img src="//<?php echo $linkpicttempid;?>" class="gambar_besar" alt="<?php echo $judulthemeid;?>"/>
		<h4><?php echo $judulthemeid;?></h4>
	</div>
	<br/>
	<h3>TEMA DESAIN YANG TERSEDIA</h3>
	<table width="100%" align="center"><?php
	$kolom=3;
	$nomor=1;
	$i=0;
	$query=mysqli_query($koneksi, "SELECT no,judul,theme FROM theme WHERE publish='1' ORDER BY judul");
	$jumlah=mysqli_num_rows($query);
	while ($data=mysqli_fetch_array($query)) { 
		$no=$data['no'];
		$judul=$data['judul'];
		$theme=$data['theme']; 
		if ($i%$kolom==0) { ?><tr><?php } ?>
			<td valign="top" align="center">
			<img src="<?php echo $module->getHttp();?>://<?php echo $domain;?>/theme/<?php echo $theme;?>/image-small.jpg" class="gambar_kecil" alt="<?php echo $judul;?>"/>
			<h4><?php echo $judul;?></h4>
			<h5><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/terapkan/<?php echo $no;?>/" title="Terapkan" onclick="return confirm ('Yakin Akan Menggunakan theme <?php echo $judul;?>?')">Terapkan</a></h5>
			</td><?php
		if (($i%$kolom)==($kolom-1) or ($i+1)==$jumlah) { ?></tr><?php }
		$nomor++;
		$i++;
	} ?>
	</table><?php
}


function theme_terapkan ($subdomain,$linksub) {
	$module=new admin ();
	$module->get_variable();
	$module->setLinkSub($linksub);
	$mod=$module->mod;  
	$adm=$module->adm;  
	$no=$module->no;
	if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
	else {
		$no=$no/1;
		$query=mysqli_query($koneksi, "SELECT no,theme FROM theme WHERE no='$no'");
		$data=mysqli_fetch_array($query);
		$no=$data['no'];
		if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
		else {
			$theme=$data['theme'];
			mysqli_query($koneksi, "UPDATE setting SET theme='$theme' WHERE subdomain='$subdomain'"); ?>
			<h3>Tema Desain Berhasil Diganti</h3>Selamat Tema Desain Berhasil Diganti<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/".$mod;?>" title="Kembali">Kembali</a></div><?php
		}
	}
}


if ($tampil==1) {
	if (empty($akses)) {
		header("location:index.php"); 
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$module=new admin ();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$judulmodule="theme";
		if (empty($act)) {
			theme($subdomain,$linksub);
		}
		elseif ($act=="terapkan") {			
			theme_terapkan($subdomain,$linksub); 
		}
	}
	else {
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>