<?php 
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){
	}
	elseif($akses=="admin" or $akses=="super"){  
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket']; $aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan profesional.<?php
		}
		else { if ($aktif==0){ ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
				}
				else{
			$judulmod="HTML";
			$tabel="html";
			$batas=30;
			$kolom="judul,id_module";
			$lebar="200,200";
			$kolomtgl=1;
			$kolomvisit=0;
			$kolomkomen=0;
			$tombolact="ubah,lihat,hapus";
			$jumdetail="single";
			$tipedetail="";
			$isidetail="kode_html";
			$tipedelete="";
			$jenisinput="";
			$onclick="cekhtml";
			$tipeinput="module";
			$forminput="judul,kode_html";
			$jenisinputrinci="";
			$onclickrinci="cekhtml";
			$tipeinputrinci="module";
			$forminputrinci="judul,publish,kode_html";
			$formeditrinci="judul,publish,tgl,kode_html";
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