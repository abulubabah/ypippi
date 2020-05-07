<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){ ?>
		<h2><a href="//<?php echo $linksub."/".$link;?>/" title="Rangkaian Kegiatan">Rangkaian Kegiatan</a></h2>
		<table width="100%" cellspacing="0" cellpadding="0" id="tabellist">
			<tr>
				<th width="30">No</th>
				<th width="120">Tanggal</th>
				<th width="150">Tempat</th>
				<th>Deskripsi</th>
			</tr><?php
			$nomor=1;
			$qjad=mysqli_query($koneksi, "SELECT tanggal,tempat,deskripsi FROM psb_jadwal WHERE subdomain='$subdomain' AND publish='1' ORDER BY urutan ASC");
			while($djad=mysqli_fetch_array($qjad)) {
				$tanggal=$djad['tanggal'];
				$tempat=$djad['tempat'];
				$deskripsi=$djad['deskripsi']; ?>
				<tr >
					<td><?php echo $nomor;?></td>
					<td style="text-align:left;"><?php echo $tanggal;?></td>
					<td style="text-align:left;"><?php echo $tempat;?></td>
					<td style="text-align:left;"><?php echo $deskripsi;?></td>
				</tr><?php
				$nomor++;
			} ?>
		</table><?php
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
				$judulmod="Jadwal Kegiatan";
				$tabel="psb_jadwal";
				$batas=30;
				$kolom="nama,tanggal";
				$lebar="200,200";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				// Lihat
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="nama,tempat,tanggal,deskripsi,urutan";
				// Delete
				$tipedelete="";
				// Tambah
				$jenisinput="";
				$onclick="cekNama";
				$tipeinput="";
				$forminput="nama,tempat,tanggal,deskripsi,urutan";
				// Tambah & Edit Rinci
				$jenisinputrinci="";
				$onclickrinci="cekJudul";
				$tipeinputrinci="";
				$forminputrinci="nama,tempat,tanggal,deskripsi,urutan";
				$formeditrinci="nama,tempat,tanggal,deskripsi,urutan,publish,tgl";
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