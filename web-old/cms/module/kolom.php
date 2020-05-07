<?php  
function kolom_pakai ($subdomain,$linksub) { 
	$module=new admin();
	$module->get_variable (); 
	$module->setLinkSub($linksub); 
	$domain=$module->domain; 
	$mod=$module->mod; 
	$adm=$module->adm;  
	$linkmod=$linksub."/".$adm."/".$mod; ?>
	<h2>Kolom Tampilan</h2><?php
	$qset=mysqli_query($koneksi, "SELECT kolom FROM setting WHERE subdomain='$subdomain'");
	$dset=mysqli_fetch_array($qset);
	$kolompakai=$dset['kolom']; 
	if ($kolompakai=="") { $kolompakai=1; } 
	$qthemeid=mysqli_query($koneksi, "SELECT judul FROM kolom WHERE no='$kolompakai'");
	$dthemeid=mysqli_fetch_array($qthemeid);
	$judulthemeid=$dthemeid['judul'];
	$linkpicttempid=$domain."/image/kolom-".$kolompakai.".jpg"; ?>
	<div style="padding:10px 0px; border-bottom:1px solid #F0F0F0; text-align:center">
		<h3>TIPE KOLOM YANG SEDANG DIGUNAKAN</h3>
		<img src="<?php echo $module->getHttp();?>://<?php echo $linkpicttempid;?>" class="gambar_besar" alt="<?php echo $judulthemeid;?>"/>
		<h4><?php echo $judulthemeid;?></h4>
	</div>
	<br/>
	<h3>KOLOM YANG TERSEDIA</h3>
	<table width="100%" align="center"><?php
	$kolom=3;
	$nomor=1;
	$i=0;
	$query=mysqli_query($koneksi, "SELECT no,judul FROM kolom WHERE publish='1' ORDER BY no");
	$jumlah=mysqli_num_rows($query);
	while ($data=mysqli_fetch_array($query)) { 
		$nokolom=$data['no'];
		$judul=$data['judul'];
		if ($i%$nomor==0) { ?><tr><?php } ?>
			<td valign="top" align="center">
			<img src="<?php echo $module->getHttp();?>://<?php echo $domain."/image/kolom-".$nokolom.".jpg"?>" class="gambar_kecil" alt="<?php echo $judul;?>"/>
			<h4><?php echo $judul;?></h4>
			<h5><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/terapkan/<?php echo $nokolom;?>/" title="Terapkan" onclick="return confirm ('Yakin Akan Menggunakan Kolom <?php echo $judul;?>?')">Terapkan</a></h5>
			</td><?php
		if (($i%$kolom)==($kolom-1) or ($i+1)==$jumlah) { ?></tr><?php }
		$nomor++;
		$i++;
	} ?>
	</table><?php
}


function kolom_terapkan ($subdomain,$linksub) {
	$module=new admin ();
	$module->get_variable();
	$module->setLinkSub($linksub);
	$mod=$module->mod;  
	$adm=$module->adm;  
	$no=$module->no;
	$linkmod=$linksub."/".$adm."/".$mod;
	$linktataletak=$linksub."/".$adm."/tataletak";
	if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
	else {
		$no=$no/1;
		$query=mysqli_query($koneksi, "SELECT no FROM kolom WHERE no='$no'");
		$data=mysqli_fetch_array($query);
		$no=$data['no'];
		if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
		else {
			$kolom=$data['no'];
			mysqli_query($koneksi, "UPDATE setting SET kolom='$kolom' WHERE subdomain='$subdomain'"); ?>
			<h3>Kolom Tampilan Berhasil Diganti</h3>Selamat, Kolom Tampilan Berhasil Diganti<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linktataletak;?>/" title="Kembali">Kembali</a></div><?php
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
		$judulmodule="theme";
		if (empty($act)) {
			kolom_pakai($subdomain,$linksub);
		}
		elseif ($act=="terapkan") {			
			kolom_terapkan($subdomain,$linksub); 
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