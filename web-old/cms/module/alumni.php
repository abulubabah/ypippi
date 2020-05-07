<?php
function detail($linksub,$subdomain){
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	global $resize;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$no=(int)$_GET['no'];
	$query=mysqli_query($koneksi, "SELECT * FROM alumni WHERE subdomain='$subdomain' AND no='$no'");
	$data=mysqli_fetch_array($query);
	$gambar=$data['gambar'];
	$nama=$data['nama'];
	$angkatan=$data['angkatan'];
	$tahun_lulus=$data['tahun_lulus'];
	$profil=$data['profil'];
	$sekolah_lanjutan=$data['sekolah_lanjutan'];
	$program_studi=$data['program_studi'];
	$jk=$data['kelamin_jenis'];
	if ($jk=="L"){ $jenis_kelamin="Laki-Laki"; } else { $jenis_kelamin="Perempuan";}
	$telepon=$data['telepon'];
	$tempat_lahir=$data['tempat_lahir'];
	$tanggal_lahir=$data['tanggal_lahir'];
	$alamat=$data['alamat'];
	list($tahun,$bulan,$tanggal)=explode("-",$tanggal_lahir);
	$kota=$data['kota'];
	$pekerjaan=$data['pekerjaan'];
	$bekerja_diperusahaan=$data['bekerja_diperusahaan'];
	?>
	<h2>Detail Alumni</h2>
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr valign="top">
		<td width="180"><img data-src="<?php echo $resize->ubah($gambar,180,180);?>" style="margin-top:10px;" width="100%" alt="gambar"/></td>
		<td></td>
		<td style="padding-left:10px;">
			<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
        		<tr><td width="160">Nama</td><td width="15">:</td><td><?php echo $nama;?></td></tr>
        		<tr><td>Jenis Kelamin</td><td width="15">:</td><td><?php echo $jenis_kelamin;?></td></tr>
        		<tr><td>TTL</td><td>:</td><td><?php echo $tempat_lahir.", $tanggal-$bulan-$tahun";?></td></tr>
        		<tr><td>Angkatan</td><td width="15">:</td><td><?php echo $angkatan;?></td></tr>
        		<tr><td>Melanjutkan Ke</td><td width="15">:</td><td><?php echo $melanjutkan;?></td></tr>
        		<tr><td>Alamat</td><td>:</td><td><?php echo $alamat;?></td></tr>
        		<tr><td>Kota / Kab</td><td>:</td><td><?php echo $kota;?></td></tr>
        		<tr><td>Telepon</td><td>:</td><td><?php echo $telepon;?></td></tr>
        		<tr><td>Angkatan</td><td>:</td><td><?php echo $angkatan;?></td></tr>
        		<tr><td>Tahun Lulus</td><td>:</td><td><?php echo $tahun_lulus;?></td></tr>
        		<tr><td>Melanjutkan Sekolah Di</td><td>:</td><td><?php echo $sekolah_lanjutan;?></td></tr>
        		<tr><td>Program Studi</td><td>:</td><td><?php echo $program_studi;?></td></tr>
        		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $pekerjaan;?></td></tr>
        		<tr><td>Bekerja di Perusahaan</td><td>:</td><td><?php echo $bekerja_diperusahaan;?></td></tr>
        		<tr><td width="180"><img data-src="<?php echo $resize->ubah($gambar,180,180);?>" style="margin-top:10px;" width="100%" alt="gambar"/></td></tr>
        	</table>
        	<br/>
        	<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button"/>
		</td>
	</tr>
	</table>
	<?php	
}

function tampil_alumni($linksub,$subdomain) {
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
	<div style="display:table;width:100%">
		<h2 style="float:left;">Data Alumni</h2>
		<div style="float:right;text-align:right;margin-top:10px;">
		<form action="" method="post">
		Cari Berdasarkan : 
		<select name="katcari" style="width:90px;">
			<option value="nama">Nama</option>
			<option value="kota">Kota</option>
			<option value="angkatan">Angkatan</option>
			<option value="tahun_lulus">Tahun Lulus</option>
			<option value="pekerjaan">Pekerjaan</option>
		</select>
		<input type="text" name="keycari" id="keycari" style="width:80px;" value="Kata Kunci" maxlength="50" onblur="if (this.value=='') this.value='Kata Kunci';" onfocus="if (this.value=='Kata Kunci') this.value='';"/>
		<input type="submit" name="cari" value="CARI" class="button"/>
		</form> 
	</div>
	</div>
	<?php
	if (empty($_POST['keycari'])) { $query=mysqli_query($koneksi, "SELECT no,nama,angkatan,link,tahun_lulus FROM alumni WHERE subdomain='$subdomain' LIMIT $posisi,$batas"); }
	else {
		$katcari=strip_tags($_POST['katcari']); $katcari=str_replace('"','',$katcari); $katcari=str_replace("'","",$katcari);
		$keycari=strip_tags($_POST['keycari']); $keycari=str_replace('"','',$keycari); $keycari=str_replace("'","",$keycari);
		$query=mysqli_query($koneksi, "SELECT no,nama,angkatan,link,tahun_lulus FROM alumni WHERE subdomain='$subdomain' AND $katcari LIKE '%$keycari%' LIMIT $posisi,$batas");
	}
	$jumlah=mysqli_num_rows($query);
	if ($jumlah==0) { 
		echo "Maaf, Data Yang Anda Cari Tidak Ditemukan";
	}
	else { ?>
		<table width="100%" cellpadding="0" cellspacing="0" id="tabellist" >
			<tr>
				<th width="20"  style="text-align:center">No</th>
				<th style="text-align:left">Nama</th>
				<th width="100" style="text-align:center">Thn Lulus</th>
				<th width="60" style="text-align:center">Detail</th>
			</tr><?php
		$nomor=1;
		$y=0;
		while ($data=mysqli_fetch_array($query)){
			$no=$data['no'];
			$nama=$data['nama'];
			$angkatan=$data['angkatan'];
			$linkhal=$data['link'];
			$tahun_lulus=$data['tahun_lulus'];		
			if ($y%2==0) { $latar="#F8F8F8"; } else { $latar="#FFFFFF"; }?>
			<tr bgcolor="<?php echo $latar;?>">
			<td><?php echo $nomor;?></td>
			<td style="text-align:left"><a href="//<?php echo $linkmodule."/".$no."/".$linkhal."/detail/";?>"><?php echo $nama;?></a></td>
			<td><?php echo $tahun_lulus;?></td>
			<td><a href="//<?php echo $linkmodule."/".$no."/".$linkhal."/detail/";?>">Detail</a></td>
			</tr><?php
			$nomor++;
			$y++;
		} ?>
		</table><?php	
		$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
	}
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
				tampil_alumni($linksub,$subdomain);
			}
			elseif ($act=="detail"){
				detail($linksub,$subdomain);
			}
			else {
				tampil_alumni($linksub,$subdomain);
			}			
		
	
	}
	else if ($akses=="admin" or $akses=="super"){
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free" or $paket=="basic") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket profesional.<?php
		}
		else {
			if ($aktif==0){?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan pembayaran.<?php
				
			}
			else {
			$judulmod="Alumni";
			$tabel="alumni";
			$batas=20;
			$kolom="nama,angkatan,sekolah_lanjutan,telepon";
			$lebar="200,100,250,100";
			$kolomtgl=1;
			$kolomvisit=0;
			$kolomkomen=0;
			$tombolact="ubah,lihat,hapus";
			// Lihat
			$jumdetail="multi";
			$tipedetail="table-pict";
			$isidetail="nama,tempat_lahir,tanggal_lahir,kelamin_jenis,alamat,kota,telepon,angkatan,tahun_lulus,sekolah_lanjutan,program_studi,pekerjaan,bekerja_diperusahaan,profil";
			// Delete
			$tipedelete="gambar";
			// Tambah
			$jenisinput="gambar";
			$onclick="cekNama";
			$tipeinput="gambar";
			$forminput="nama,kelamin_jenis,alamat,kota,telepon,angkatan,tahun_lulus,sekolah_lanjutan,program_studi,pekerjaan,bekerja_diperusahaan,gambar";
			// Tambah & Edit Rinci
			$jenisinputrinci="gambar";
			$onclickrinci="cekNama";
			$tipeinputrinci="gambar";
			$forminputrinci="nama,tempat_lahir,tanggal_lahir,kelamin_jenis,alamat,kota,telepon,angkatan,tahun_lulus,sekolah_lanjutan,program_studi,pekerjaan,bekerja_diperusahaan,gambar";
			$formeditrinci="nama,tempat_lahir,tanggal_lahir,kelamin_jenis,alamat,kota,telepon,angkatan,tahun_lulus,sekolah_lanjutan,program_studi,pekerjaan,bekerja_diperusahaan,gambar";
			$admin=new admin();
			$admin->get_variable();
			$admin->setLinkSub($linksub);
			if (empty ($act)) {
					$admin->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				} 
				elseif($act=="semua"){
					$admin->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="urut"){
					$admin->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="cari"){
					$admin->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif ($act=="lihat") {
					$admin->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail);
				} 
				elseif ($act=="hapus") {
					$admin->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="hapusmulti") {
					$admin->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="tambah") {
					$admin->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="tambahrinci") {
					$admin->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
				} 
				elseif ($act=="ubah") {
					$admin->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="ubahrinci") {
					$admin->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
				} 
				else {
					$admin->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				} 
			}
		}
	}
}
else {
	header("location://mysch.id");
}
?>