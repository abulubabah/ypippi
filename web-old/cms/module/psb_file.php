<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){  ?>
		<h2><a href="//<?php echo $linksub."/".$link;?>/" title="Download Dokumen">Download Dokumen</a></h2>
		<ul><?php
		$qjad=mysqli_query($koneksi, "SELECT judul,file FROM psb_file WHERE subdomain='$subdomain' AND publish='1'");
		while($djad=mysqli_fetch_array($qjad)) {
			$judul=$djad['judul'];
			$file=$djad['file']; ?>				
			<div style="display:table;width:100%;">
				<a href="//<?php echo $domain."/file/".$file;?>" target="_blank" title="<?php echo $judul;?>">
				<img src="//<?php echo $domain;?>/image/brosur.png" align="left" style="margin:0px 10px 0px 0px;"><h3><?php echo $judul;?></h3>
				</a>
			</div ><?php
		} ?>
		<ul><?php
	
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket']; $aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan premium.<?php
		}
		else {
			if ($aktif==0) { ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php }
			else {
				$judulmod="File Dokumen";
				$tabel="psb_file";
				$batas=30;
				$kolom="judul";
				$lebar="200";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				// Lihat
				$jumdetail="multi";
				$tipedetail="";
				$isidetail="judul";
				// Delete
				$tipedelete="file";
				// Tambah
				$jenisinput="file";
				$onclick="cekJudul";
				$tipeinput="file";
				$forminput="judul,file";
				// Tambah & Edit Rinci
				$jenisinputrinci="file";
				$onclickrinci="cekJudul";
				$tipeinputrinci="file";
				$forminputrinci="judul,file";
				$formeditrinci="judul,file";
				$module=new admin();
				$module->get_variable();
				$module->setLinkSub($linksub);
			
				if (empty ($act)) {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				} 
				elseif($act=="semua"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="urut"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="cari"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif ($act=="lihat") {
					$module->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail);
				} 
				elseif ($act=="hapus") {
					$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="hapusmulti") {
					$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="tambah") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="tambahrinci") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
				} 
				elseif ($act=="ubah") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="ubahrinci") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
				} 
				else {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}			
			}
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