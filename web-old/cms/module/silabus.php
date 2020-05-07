<?php 
function tampil_silabus($linksub,$subdomain) {
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$batas=20;
	$kategori="";
	if (empty($_GET['page'])) { $page=1; } else { $page=(int)$_GET['page']; }
	if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
	?>
	<h2>Silabus</h2>
	<table width="100%" cellspacing="0" cellpadding="0" id="tabellist">
	<tr>
	<th width="30">No</th>
	<th  style="text-align:left;">Mata Pelajaran</th>
	<th width="120">Thn Ajaran</th>
	<th width="80">Kelas</th>
	<th width="80">Semester</th>
	<th width="60">Download</th>
	</tr>
	<?php
		$query=mysqli_query($koneksi, "select * from silabus where subdomain='$subdomain' LIMIT $posisi,$batas");
		$jumlah=mysqli_num_rows($query);
		$nomor=1;
		$y=1;
		while ($data=mysqli_fetch_array($query)){
			$no=$data['no'];
			$judulsilabus=$data['judul'];
			$kelas=$data['kelas'];
			$tahun_ajaran=$data['tahun_ajaran'];
			$alamat=$data['alamat'];
			$semester=$data['semester'];		
			$file=$data['file'];	
			if ($y%2==0) { $latar="#F8F8F8"; } else { $latar="#FFFFFF"; }?>
		<tr bgcolor="<?php echo $latar;?>">
		<td><?php echo $nomor;?></td>
		<td style="text-align:left;"><?php echo $judulsilabus;?></td>
		<td><?php echo $tahun_ajaran;?></td>
		<td><?php echo $kelas;?></td>
		<td><?php echo $semester;?></td>
		<td><a href="//<?php echo $domain;?>/file/<?php echo $file;?>" title="Download" target="_blank" class="button">Download</a></td>
		</tr><?php
			$nomor++; $y++;
		} ?>
	</table>	 <?php
	$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
}
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php"); 
	} 
	elseif($akses=="publik" or $akses=="member"){
		$publik=new publik();
		$publik->get_variable(); 
		$domain=$publik->domain;
		$act=$publik->act;
		if (empty ($act)) {
				tampil_silabus($linksub,$subdomain);
			}
			else {
				tampil_silabus($linksub,$subdomain);
			}	
	}
	elseif($akses=="admin" or $akses=="super"){  
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan Profesional.<?php
		}
		else{
			if ($aktif==0){?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
			}
			else {
				$judulmod="Silabus";
				$tabel="silabus";
				$batas=30;
				$kolom="judul,kelas,semester";
				$lebar="200,100,100";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="judul,tahun_ajaran,kelas,semester,file";
				$tipedelete="file";
				$jenisinput="file";
				$onclick="cekJudul";
				$tipeinput="file";
				$forminput="judul,tahun_ajaran,kelas,semester,file";
				$jenisinputrinci="file";
				$onclickrinci="cekJudul";
				$tipeinputrinci="file";
				$forminputrinci="judul,tahun_ajaran,kelas,semester,file,publish";
				$formeditrinci="judul,tahun_ajaran,kelas,semester,file,publish,tgl";
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