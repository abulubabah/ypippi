<style type="text/css">
#container_main {float:left;width:100%;display:table;padding:0px; }
.left, .alignleft { float:left; display:inline; }
.right, .alignright { float:right; display:inline; }
#staff ul{ margin:0px; padding:0px; text-align:center; display:table; width:100%; }
#staff ul li{ background:#FFFFFF; list-style-type:none; height:230px; width:25%; padding:0% 0%; margin:0px 0px;  
float:left; overflow:hidden; cursor:pointer; }
#staff ul li:hover{ }
.gambar_staff { width:150px; height:200px;}

@media screen and (max-width:400px) {
#staff ul li{ height:180px; width:48%; }
.gambar_staff { width:115px;height:140px;}
}
</style>
<?php

if($subdomain=='man1banyuwangi.sch.id'){
   // error_reporting(E_ALL);
}
function detail($haljudul,$linksub,$subdomain){
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	global $resize;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$no=(int)$_GET['no'];
	$qcekdata=mysqli_query($koneksi, "select * from staff where subdomain='$subdomain' And no='$no'");
	$data=mysqli_fetch_array($qcekdata);
	$gambar=$data['gambar']; if ($gambar==""){ $gambar="guru.png"; } else { $gambar=$gambar;}
	$nama=$data['nama'];
	$nip=$data['nip'];
	$status=$data['status'];
	$pendidikan=$data['pendidikan'];
	$jabatan=$data['jabatan'];
	$jk=$data['kelamin_jenis'];
	if ($jk=="L"){ $jenis_kelamin=$jk; } else { $jenis_kelamin="Perempuan";} $jenis_kelamin=$jk;
	$agama=$data['agama'];
	$tempat_lahir=$data['tempat_lahir'];
	$tanggal_lahir=$data['tanggal_lahir'];
	$alamat=$data['alamat'];
	list($tahun,$bulan,$tanggal)=explode("-",$tanggal_lahir);
	$kota=$data['kota'];
	$kodepos=$data['kodepos'];
	?>
	<h2>Detail <?php echo $haljudul;?></h2>
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr valign="top">
		<td width="180"><img data-src="<?php echo $resize->ubah($gambar,180,180);?>" style="margin-top:10px;" width="100%" alt="gambar"/></td>
		<td></td>
		<td style="padding-left:10px;">
			<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
				<tr><td width="140">Nama</td><td width="15">:</td><td><?php echo $nama;?></td></tr>
				<?php
				if ($subdomain != 'sdmarsudiriniperawang.sch.id') {
				    ?>
				    <tr><td>Nip</td><td>:</td><td><?php echo $nip;?></td></tr>
				    <?php
				}
				?>
				<tr><td>status</td><td>:</td><td><?php echo $status;?></td></tr>
				<tr><td>pendidikan</td><td>:</td><td><?php echo $pendidikan;?></td></tr>
				<tr><td>Jabatan</td><td>:</td><td><?php echo $jabatan;?></td></tr>
				<tr><td>Jenis Kelamin</td><td>:</td><td><?php echo $jenis_kelamin;?></td></tr>
				<tr><td>agama</td><td>:</td><td><?php echo $agama;?></td></tr>
				<tr><td>tempat lahir </td><td>:</td><td><?php echo $tempat_lahir;?></td></tr>
				<tr><td>tanggal lahir </td><td>:</td><td><?php echo "$tanggal-$bulan-$tahun";?></td></tr>
				<tr><td>alamat</td><td>:</td><td><?php echo $alamat;?></td></tr>
				<tr><td>kota</td><td>:</td><td><?php echo $kota;?></td></tr>
				<tr><td>kodepos</td><td>:</td><td><?php echo $kodepos;?></td></tr>
				<tr><td colspan="3"><input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button"/></td></tr>
			</table>
		</td>
	</tr>
	</table>
	<?php
	
}
function tampil_staff($haljudul,$linksub,$subdomain) {
    global $resize;
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$batas=20;
	$kategori="";
	if (empty($_GET['page'])) { $page=1; } else { $page=$_GET['page']; }
	if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
	?>
	<h2><?php echo $haljudul;?></h2>
	<div id="container_main">
	<div align="right">
	<div id="staff" align="right">
	<ul><?php
		$query=mysqli_query($koneksi, "select no,nama,nip,link,gambar,status from staff where subdomain='$subdomain' ORDER BY nama ASC LIMIT $posisi,$batas");
		$jumlah=mysqli_num_rows(mysqli_query($koneksi, "select no from staff where subdomain='$subdomain'"));
		$nomor=0;
		$y=0;
		while ($data=mysqli_fetch_array($query)){			
			$no=$data['no'];
			$nama=$data['nama'];
			$nip=$data['nip'];
			$linkhal=$data['link'];
                        $gambar=$data['gambar'];  if ($gambar==""){ $gambar="guru.png"; } else { $gambar=$gambar;}
			$status=$data['status'];
			$nomor++;
			$y++;
			if ($y%2==0) { $latar="#F8F8F8"; } else { $latar="#FFFFFF"; }?>
			<li>
			<a href="//<?php echo $linkmodule."/".$no."/".$linkhal;?>/detail/" title="<?php echo $nama;?>">
			<img data-src="<?php echo $resize->ubah($gambar,180,180);?>" class="gambar_staff" alt="gambar" /><br/><?php echo $nama;?></a>
			</li><?php			
		} ?>
		</ul>
	</div>
	</div>
	</div>
	<?php
	$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
}

if ($tampil==1) {  
	if (empty($akses)) { 
		header("location://mysch.id"); 
	}
	else if ($akses=="publik" or $akses=="member"){
		$publik=new publik();
		$publik->get_variable(); 
		$domain=$publik->domain;
		$act=$publik->act;
		if (empty ($act)) {
				tampil_staff($haljudul,$linksub,$subdomain);
			}
			elseif ($act=="detail"){
				detail($haljudul,$linksub,$subdomain);
			}
			else {
				tampil_staff($haljudul,$linksub,$subdomain);
			}			
		
	
	}
	else if ($akses=="admin" or $akses=="super"){ 
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
		$judulmod="Staff";
		$tabel="staff";
		$batas=20;
		$kolom="nama,nip";
		$lebar="200,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		// Lihat
		$jumdetail="multi";
		$tipedetail="table-pict";
		$isidetail="nama,nip,status,pendidikan,jabatan,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon";
		// Delete
		$tipedelete="gambar";
		// Tambah
		$jenisinput="gambar";
		$onclick="cekNama";
		$tipeinput="gambar";
		$forminput="nama,nip,status,pendidikan,jabatan,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,gambar";
		// Tambah & Edit Rinci
		$jenisinputrinci="gambar";
		$onclickrinci="cekNama";
		$tipeinputrinci="gambar";
		$forminputrinci="nama,nip,status,pendidikan,jabatan,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,gambar";
		$formeditrinci="nama,nip,status,pendidikan,jabatan,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,gambar";
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
}
else {
	header("location://mysch.id");
}
?>