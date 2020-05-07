<style type="text/css">
#container_main {float:left;width:100%;display:table;padding:0px; }
.left, .alignleft { float:left; display:inline; }
.right, .alignright { float:right; display:inline; }
#guru ul{ margin:0px; padding:0px; text-align:center; display:table; width:100%; }
#guru ul li{ background:#FFFFFF; list-style-type:none; height:240px; width:24%; padding:1% 0%; margin:0px 1% 1% 0px;  
float:left; overflow:hidden; cursor:pointer; }
#guru ul li:hover{-moz-box-shadow: 0px 0px 5px #DADADA;-webkit-box-shadow: 0px 0px 5px #DADADA;box-shadow: 0px 0px 5px #DADADA;}
.gambar_guru { width:150px; height:200px;}

@media screen and (max-width:400px) {
#guru ul li{ height:180px; width:48%; }
.gambar_guru { width:115px;height:140px;}
}
</style>
<?php
function detail($haljudul,$linksub,$subdomain){
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	global $resize;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$no=(int)$_GET['no'];
	$qcekdata=mysqli_query($koneksi, "select * from guru where subdomain='$subdomain' And no='$no'");
	$data=mysqli_fetch_array($qcekdata);
	$gambar=$data['gambar']; if ($gambar==""){ $gambar="guru.png"; } else { $gambar=$gambar;} 
	$nama=$data['nama'];
	$nip=$data['nip']; $nuptk=$data['nuptk']; $nrg=$data['nrg']; $tahun_sertifikasi=$data['tahun_sertifikasi']; $nik=$data['nik'];
	$status=$data['status'];
	$pendidikan=$data['pendidikan'];
	$mapel=$data['mata_pelajaran'];
	$jk=$data['kelamin_jenis'];
	if ($jk=="L"){
	    $jenis_kelamin="Laki-Laki";
	 } else {
	    $jenis_kelamin="Perempuan";
	     
	 } 
	$agama=$data['agama'];
	$pangkat_golongan=$data['pangkat_golongan'];
	$tempat_lahir=$data['tempat_lahir'];
	$tanggal_lahir=$data['tanggal_lahir'];
	$alamat=$data['alamat'];
	list($tahun,$bulan,$tanggal)=explode("-",$tanggal_lahir);
	$kota=$data['kota'];
	$kodepos=$data['kodepos'];
	$jenis_ptk=$data['jenis_ptk'];
	$rt=$data['rt'];
	$rw=$data['rw'];
	$dusun=$data['dusun'];
	$desa=$data['desa'];
	$kecamatan=$data['kecamatan'];
	$telepon=$data['telepon'];
	$hp=$data['hp'];
	$email=$data['email'];
	?>
	<h2>Detail <?php echo $haljudul;?></h2>
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr valign="top">
		<td width="180"><img data-src="<?php echo $resize->ubah($gambar,180,180);?>" style="margin-top:10px;" width="100%" alt="gambar"/></td>
		<td></td>
		<td style="padding-left:10px;">
			<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
				<tr><td width="140">nama</td><td width="15">:</td><td><?php echo $nama;?></td></tr><?php
				
				if ($subdomain=="minutrateeputera.sch.id"){?>
					<tr><td>NIG</td><td>:</td><td><?php echo $nip;?></td></tr><?php
				} else if ($subdomain=='sdalmuttaqintasikmalaya.sch.id' or $subdomain=='sekolahypkairkenanga.sch.id'){?>
					<tr><td>NIY</td><td>:</td><td><?php echo $nip;?></td></tr><?php
				} elseif ($subdomain == 'sdmarsudiriniperawang.sch.id') {
				    
				} else { ?>
					<tr><td>NIP</td><td>:</td><td><?php echo $nip;?></td></tr><?php
				}?>
				
				
				<tr><td>NUPTK</td><td>:</td><td><?php echo $nuptk;?></td></tr><?php
				
				
				if ($subdomain=="smkmtumijajar.sch.id" or $subdomain=="mtsalhikmahdua.sch.id" ) { ?>
				    <tr><td>NRG</td><td>:</td><td><?php echo $nrg;?></td></tr><?php 
				} 
				
				
				if ($subdomain=="sman10kotatangerang.sch.id") { ?>
				    <tr><td>NIK</td><td>:</td><td><?php echo $nik;?></td></tr><?php 
				} 
				
				
				if ($subdomain!='minutrateeputera.sch.id' AND $subdomain != 'sdmarsudiriniperawang.sch.id'){ ?>
					<tr><td>Tahun Sertifikasi</td><td>:</td><td><?php echo $tahun_sertifikasi;?></td></tr><?php
				} ?>
				
				
				<tr><td>status</td><td>:</td><td><?php echo $status;?></td></tr><?php
				
				
				if ($subdomain=="sman10kotatangerang.sch.id") { ?>
				    <tr><td>Jenis PTK</td><td>:</td><td><?php echo $jenis_ptk;?></td></tr><?php 
				} ?>
				
				<tr><td>pendidikan</td><td>:</td><td><?php echo $pendidikan;?></td></tr>
				
				<?php
				if ($subdomain == 'sdmarsudiriniperawang.sch.id') {
				    
				} else {
				    ?>
				    <tr><td>pangkat golongan</td><td>:</td><td><?php echo $pangkat_golongan;?></td></tr>
				    <?php
				}
				?>
				
				<tr><td>mata pelajaran </td><td>:</td><td><?php echo $mapel;?></td></tr>
				<tr><td>Jenis Kelamin</td><td>:</td><td><?php echo $jenis_kelamin;?></td></tr><?php
				
				
				if ($subdomain!='minutrateeputera.sch.id'){?>
					<tr><td>agama</td><td>:</td><td><?php echo $agama;?></td></tr><?php
				}?>
				
				
				<tr><td>tempat lahir </td><td>:</td><td><?php echo $tempat_lahir;?></td></tr>
				<tr><td>tanggal lahir </td><td>:</td><td><?php echo "$tanggal-$bulan-$tahun";?></td></tr>
				<tr><td>alamat</td><td>:</td><td><?php echo $alamat;?></td></tr><?php
				if ($subdomain=="sman10kotatangerang.sch.id") { ?>
    				<tr><td>RT</td><td>:</td><td><?php echo $rt;?></td></tr>
    				<tr><td>RW</td><td>:</td><td><?php echo $rw;?></td></tr>
    				<tr><td>Dusun</td><td>:</td><td><?php echo $dusun;?></td></tr>
    				<tr><td>Desa</td><td>:</td><td><?php echo $desa;?></td></tr>
    				<tr><td>Kecamatan</td><td>:</td><td><?php echo $kecamatan;?></td></tr>
    				<tr><td>kota</td><td>:</td><td><?php echo $kota;?></td></tr><?php
				} 
				
				
				if ($subdomain!='minutrateeputera.sch.id'){?>
					<tr><td>kodepos</td><td>:</td><td><?php echo $kodepos;?></td></tr><?php
				} 
				
				
				if ($subdomain=="smpn1bantul.sch.id") { 
				    
				} elseif ($subdomain=='sekolahypkairkenanga.sch.id') {
                    ?>
                    <tr><td>Email</td><td>:</td><td><?php echo $email;?></td></tr>
                    <?php
                } else { 
                    ?>
                    <tr><td>Telepon</td><td>:</td><td><?php echo $telepon;?></td></tr>
                    <?php
				}
				
				
				if ($subdomain=="sman10kotatangerang.sch.id") { ?>
    				<tr><td>HP</td><td>:</td><td><?php echo $hp;?></td></tr>
    				<tr><td>Email</td><td>:</td><td><?php echo $email;?></td></tr><?php 
				} ?>
				
				<tr><td colspan="3"><input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button"/></td></tr>
			</table>
		</td>
	</tr>
	</table>
	<?php
	
}
function tampil_guru($haljudul,$linksub,$subdomain) {
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	global $resize;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$batas=20;
	$kategori="";
	if (empty($_GET['page'])) { $page=1; } else { $page=(int)$_GET['page']; }
	if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
	?>
	<h2><?php echo $haljudul;?></h2>
	<div id="container_main">
	<div align="right">
	<div id="guru" align="right">
	<ul><?php
		$query=mysqli_query($koneksi, "select no,nama,nip,link,gambar,pangkat_golongan,status from guru where subdomain='$subdomain' ORDER BY nama ASC LIMIT $posisi,$batas");
		$jumlah=mysqli_num_rows(mysqli_query($koneksi, "select no from guru where subdomain='$subdomain'"));
		$nomor=0;
		$y=0;
		while ($data=mysqli_fetch_array($query)){			
			$no=$data['no'];
			$nama=$data['nama'];
			$nip=$data['nip'];
			$linkhal=$data['link'];
			$gambar=$data['gambar'];  if ($gambar==""){ $gambar="guru.png"; } else { $gambar=$gambar;} 
			$status=$data['status'];
			$pangakt_golongan=$data['pangkat_golongan'];
			$nomor++;
			$y++;
			if ($y%2==0) { $latar="#F8F8F8"; } else { $latar="#FFFFFF"; }?>
			<li>
			<a href="//<?php echo $linkmodule."/".$no."/".$linkhal;?>/detail/" title="<?php echo $nama;?>">
			<img data-src="<?php echo $resize->ubah($gambar,180,180);?>" class="gambar_guru" alt="gambar" /><br/><?php echo $nama;?>
			<?php if($nip && $subdomain=='smpn1ubud.sch.id'){ ?>
			<br/>Nip : <?php echo $nip;?>
			<?php } ?>
			</a>
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
				tampil_guru($haljudul,$linksub,$subdomain);
			}
			elseif ($act=="detail"){
				detail($haljudul,$linksub,$subdomain);
			}
			else {
				tampil_guru($haljudul,$linksub,$subdomain);
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
		$judulmod="Guru";
		$tabel="guru";
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
		
		if ($subdomain == "smklenterabangsa2.sch.id") {
		    $isidetail="nama,pendidikan,tempat_lahir,tanggal_lahir,alamat,gambar";
		} elseif ($subdomain=='sekolahypkairkenanga.sch.id') {
		    $isidetail="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,email,pangkat_golongan";
		} else {
		    $isidetail="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,pangkat_golongan";
		}

		// Delete
		$tipedelete="gambar";
		
		// Tambah
		$jenisinput="gambar";
		$onclick="cekNama";
		$tipeinput="gambar";
		
		if ($subdomain == "smklenterabangsa2.sch.id") {
		    $forminput="nama,pendidikan,tempat_lahir,tanggal_lahir,alamat,gambar";
		} elseif ($subdomain=='sekolahypkairkenanga.sch.id') {
		    $forminput="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,email,pangkat_golongan,gambar";
		} else {
		    $forminput="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,pangkat_golongan,gambar";
		}

		// Tambah & Edit Rinci
		$jenisinputrinci="gambar";
		$onclickrinci="cekNama";
		$tipeinputrinci="gambar";
		
		if ($subdomain == "smklenterabangsa2.sch.id") {
		    $forminputrinci="nama,pendidikan,tempat_lahir,tanggal_lahir,alamat,gambar";
		    $formeditrinci="nama,pendidikan,tempat_lahir,tanggal_lahir,alamat,gambar";
		    
		} elseif ($subdomain=='sekolahypkairkenanga.sch.id') {
		    $forminputrinci="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,email,gambar,pangkat_golongan";
		    $formeditrinci="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,email,gambar,pangkat_golongan";    
		} else {
		    $forminputrinci="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,gambar,pangkat_golongan";
		    $formeditrinci="nama,nip,nuptk,nrg,tahun_sertifikasi,status,pendidikan,mata_pelajaran,kelamin_jenis,agama,tempat_lahir,tanggal_lahir,alamat,kota,kodepos,telepon,gambar,pangkat_golongan";    
		}

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