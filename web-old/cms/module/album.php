<?php 
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){ 
		$tabel="galeri"; 
		$module=new publik();
		
		if ($link=="") { 
			$kategori=""; 
			$nokategori=""; ?>
			<div class="<?php echo $stylepanel;?>"><?php
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
			<div class="<?php echo $styleisi;?>"><?php
				$module->galeri_list($subdomain,$linksub,$bahasa,$kategori,$nokategori);   ?>
				</div>
			</div><?php
		}
		else {  
			$kategori=$link;
			$nokategori=isset($_GET['no']) ? (int)$_GET['no'] : ''; ?>
			<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2><?php 
			$module->galeri_list($subdomain,$linksub,$bahasa,$kategori,$nokategori); 
		} ?>
		<script type="text/javascript" charset="utf-8" src="//storage.googleapis.com/s.mysch.id/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/js/prettyPhoto.css"/>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',slideshow:10000, hideflash: true});		
			});
		</script><?php		
	}
	elseif($akses=="admin" or $akses=="super"){
		$judulmod="Foto";
		$tabel="galeri";
		$batas=30;
		$kolom="judul,id_galeri_kategori";
		$lebar="200,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="single";
		$tipedetail="pict";
		$isidetail="gambar";
		$tipedelete="gambar"; 
		$jenisinput="gambar";
		$onclick="cekJudul";
		$tipeinput="";
		$forminput="judul,gambar";
		$jenisinputrinci="gambar";
		$onclickrinci="cekJudul";
		$tipeinputrinci="";
		$forminputrinci="id_galeri_kategori,judul,gambar,publish";
		$formeditrinci="id_galeri_kategori,judul,gambar,publish,tgl";
		$tabelkat="galeri_kategori";
		$kolomkat="judul";
		$lebarkat="100";
		$tombolkat="ubah,hapus";
		
		
		$qcekpaket=mysqli_query($koneksi, "select paket from setting where subdomain='$subdomain'");
		$dpaket=mysqli_fetch_array($qcekpaket);
		$paket=$dpaket['paket'];
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
					elseif($act=="kategori" or $act=="kattambah" or $act=="katubah" or $act=="katurut" or $act=="katcari"){
						$module->kategori($subdomain,$linksub,$judulmod,$tabelkat,$batas,$act,$kolomkat,$lebarkat,$tombolkat);
					}
					elseif($act=="kathapus"){
						$module->hapus($subdomain,$linksub,$tabelkat,"",$folder);
						$module->kategori($subdomain,$linksub,$judulmod,$tabelkat,$batas,$act,$kolomkat,$lebarkat,$tombolkat);
					}
					elseif($act=="kathapusmulti"){
						$module->hapusmulti($subdomain,$linksub,$tabelkat,$tipedelete,$folder);
						$module->kategori($subdomain,$linksub,$judulmod,$tabelkat,$batas,$act,$kolomkat,$lebarkat,$tombolkat);
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
						$qcekjumgaleri=mysqli_query($koneksi, "select no from galeri where subdomain='$subdomain'");
						$jumgaleri=mysqli_num_rows($qcekjumgaleri);
						if ($paket=="free"){
							if ($jumgaleri>=15){?>
									<h3>Tambah Galeri Ditolak</h3>
									Maaf, Anda Tidak dapat menambah Galeri karena sudah melebihi batas paket Free.<br/>
									Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
									Klik <a href="//<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
									<?php
							}
							elseif($jumgaleri>=12){?>
									<div style="background:#FFFFAA; padding:1%; margin-bottom:10px;">
									<h3>Peringatan : Kapasitas Galeri Hampir Penuh</h3>
									Jumlah Galeri  Anda hampir melebihi batas maksimal Paket Free.<br/>
									Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
									Klik <a href="//<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
									</div><?php
									$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
							}
							else{
								$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
							}
						}
						else{
							$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
						}
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
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>