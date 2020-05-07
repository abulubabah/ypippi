<?php 
function detail_materi($linksub,$subdomain){
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$no=(int)$_GET['no'];
	$qcekmateri=mysqli_query($koneksi, "select mata_pelajaran from materi where no='$no'");
	$dmateri=mysqli_fetch_array($qcekmateri);
	$materi=$dmateri['mata_pelajaran'];
	$batas=20;
	$kategori="";
	if (empty($_GET['page'])) { $page=1; } else { $page=(int)$_GET['page']; }
		if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
		$query=mysqli_query($koneksi, "select * from materi where mata_pelajaran='$materi' AND subdomain='$subdomain' LIMIT $posisi,$batas");
		$jumlah=mysqli_num_rows($query);
		$nomor=0;
		$y=0;
		while ($data=mysqli_fetch_array($query)){
			$no=$data['no'];
			$mapel=$data['mata_pelajaran'];
			$no_kelas=$data['no_kelas'];
			$tahun_ajaran=$data['tahun_ajaran'];
			$alamat=$data['alamat'];
			$download=$data['download'];
			$semester=$data['semester'];
			$qcekkelas=mysqli_query($koneksi, "select nama from kelas where no='$no_kelas'");
			$dkelas=mysqli_fetch_array($qcekkelas);
			$kelas=$dkelas['nama'];
			$file=$data['file'];
			?>
			Pelajaran <?php echo strtoupper($mapel);?>,Kelas <?php echo strtoupper($kelas);?><br>
			Didownload <?php echo $download;?> Kali,[<a href="//<?php echo $domain;?>/file/<?php echo $file;?>">Download</a>]<br>
			Materi Kelas <?php echo strtoupper($kelas);?> Semester <?php echo $semester;?> Tahun Ajaran <?php echo $tahun_ajaran;?><br>
			<?php
			
		}
		?>
	
	<?php
	$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
}


function tampil_materi($linksub,$subdomain) {
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
	<h2>Materi</h2>
	<table width="100%" cellspacing="0" cellpadding="0" id="tabellist">
<tr>
<th width="30">No</th>
<th  style="text-align:left;">Mata Pelajaran</th>
<th width="200" style="text-align:left;">Materi Pelajaran</th>
<th width="80">Kelas</th>
<th width="80">Semester</th>
<th width="60">Detail</th>
</tr>
<?php
		$query=mysqli_query($koneksi, "select * from materi where subdomain='$subdomain' ORDER BY kelas ASC LIMIT $posisi,$batas");
		$jumlah=mysqli_num_rows($query);
		$nomor=1;
		$y=1;
		while ($data=mysqli_fetch_array($query)){
			$no=$data['no'];
			$judulsilabus=$data['judul'];
			$kelas=$data['kelas'];
			$no_matapelajaran=$data['no_matapelajaran'];
			$qmapel=mysqli_query($koneksi, "select nama from matapelajaran where subdomain='$subdomain' AND no='$no_matapelajaran'");
			$dmapel=mysqli_fetch_array($qmapel);
			$namamapel=$dmapel['nama'];
			$alamat=$data['alamat'];
			$semester=$data['semester'];		
$file=$data['file'];	
			if ($y%2==0) { $latar="#F8F8F8"; } else { $latar="#FFFFFF"; }?>
<tr bgcolor="<?php echo $latar;?>">
<td><?php echo $nomor;?></td>
<td style="text-align:left;"><?php echo $judulsilabus;?></td>
<td style="text-align:left;"><?php echo $namamapel;?></td>
<td><?php echo $kelas;?></td>
<td><?php echo $semester;?></td>
<td><a href="//<?php echo $domain;?>/file/<?php echo $file;?>" title="Download" target="_blank" class="button">Download</a></td>
</tr><?php
			$nomor++; $y++;
		}
		?>
</table>
	
	<?php
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
				tampil_materi($linksub,$subdomain);
			}
			else if ($act=="detail"){
				tampil_materi($linksub,$subdomain);
				detail_materi($linksub,$subdomain);
			}
			else {
				tampil_materi($linksub,$subdomain);
			}	
	}
	elseif($akses=="admin" or $akses=="super"){  
		$qset=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free" or $paket=="basic") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket  Profesional.<?php
			
		}
		else {
			if ($aktif==0){?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
				
			}
			else {
				$judulmod="Materi";
				$tabel="materi";
				$batas=30;
				$kolom="judul,no_matapelajaran,kelas,semester";
				$lebar="200,200,100,100";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="judul,no_matapelajaran,tahun_ajaran,kelas,semester,file";
				$tipedelete="file";
				$jenisinput="file";
				$onclick="cekJudul";
				$tipeinput="file";
				$forminput="judul,no_matapelajaran,tahun_ajaran,kelas,semester,file";
				$jenisinputrinci="file";
				$onclickrinci="cekJudul";
				$tipeinputrinci="file";
				$forminputrinci="judul,no_matapelajaran,tahun_ajaran,kelas,semester,file,publish";
				$formeditrinci="judul,no_matapelajaran,tahun_ajaran,kelas,semester,file,publish,tgl";
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