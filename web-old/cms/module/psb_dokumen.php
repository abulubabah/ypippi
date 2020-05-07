<?php

function uri($param){
		$url=$_SERVER['REQUEST_URI'];
		$url=explode('/',$url);
		if (empty($url[$param])){
		}
		else {
			$uri=$url[$param];
			return $uri;
		}
		
} 
	
function dokumen_tampil($linksub,$subdomain,$link,$nisn,$domain)  {
	$mod=$link;
	$linkcreate="$linksub/$mod/tambah/";
	$linkubah="$linksub/$mod/ubah";
	$linkhapus="$linksub/$mod/hapus";
	global $uploader;

	?> 
	<div style="display:table; width:100%">
		<div style="float:left"><h2>Upload Dokumen</h2></div>
		<div class="button" style="float:right; padding:1px 3px;"><a href="//<?php echo $linkcreate;?>" title="Upload Dokumen">Upload Dokumen</a></div>
	</div>
	<div class="bar"><?php
	$query=mysqli_query($koneksi, "SELECT * FROM psb_dokumen WHERE nisn='$nisn' AND subdomain='$subdomain'  ORDER BY tgl DESC");
	$jumlah=mysqli_num_rows($query); 
	if ($jumlah==0) { ?>Anda Tidak Memiliki Dokumen<br> <a href="//<?php echo $linkcreate;?>" title="Upload Dokumen">Upload Dokumen</a><?php }
	else { ?>
		<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
			<tr>
				<th width="4%">No</th>
				<th>Nama Dokumen</th>
				<th>File</th>
				<th width="16%">Aksi</th>
			</tr><?php
		$nomor=1;
		$y=1;
		while($data=mysqli_fetch_array($query)) { 
				$no=$data['no'];
				$judul=$data['judul'];
				$gambar=$data['gambar'];
				if ($y%2==0) { $latar="#F0F0F0"; } else { $latar="#FFFFFF"; }
				?>
				<tr bgcolor="<?php echo $latar; ?>">
					<td><?php echo $nomor;?></td>
					<td style="text-align:left"><?php echo $judul;?></td>
					<td style="text-align:left"><a href="//<?php echo $domain."/picture/".$gambar;?>" title="<?php echo $gambar;?>"><?php echo $gambar;?></a></td>
					<td><a href="//<?php echo $linkubah."/".$no;?>" title="Ubah">Ubah</a>&nbsp;&nbsp;<a href="//<?php echo $linkhapus."/".$no;?>" title="Hapus">Hapus</a></td>
				</tr><?php
				$nomor++; $y++;
		} ?>
		</table><?php
	} ?>
	</div><?php
}  


function tambah_dokumen($linksub,$subdomain,$link,$nisn,$folder){
    include_once($folder."/function/validasiupload.php");
    global $uploader;
    if($subdomain=='smkmaarifsalam.sch.id'){
       // error_reporting(E_ALL);
    }
	if (empty($_POST['proses'])){ ?>
		<form action="" method="post" id="form1" autocomplete="off" enctype="multipart/form-data">
			<div id="view"><div class="view_label">Nama File</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama" id="nama" style="width:94%; max-width:400px;" maxlength="50"></div></div>
			<div id="view"><div class="view_label">Gambar</div><div class="view_dot">:</div><div class="view_content"><input type="file" required="required" name="gambar" id="gambar" style="width:94%; max-width:400px;" maxlength="150"></div></div>
			<input type="hidden" name="proses" value="simpan">
			<div id="view"><div class="view_label">&nbsp;</div><div class="view_dot">&nbsp;</div><div class="view_content"><input type="submit" value="Tambah" id="submit"  class="button_add"></div></div>
		</form><?php 
		$kode=rand(9079878,834756348);
		$_SESSION['kode']=$kode;
		
	}
	else if ($_POST['proses']=="simpan"){
		if (empty($_SESSION['kode'])){
			echo "<script>document.location='//$linksub/$link';</script>";
		}
		else {
$qsis=mysqli_query($koneksi, "select * from psb_member where nisn='$_SESSION[uname]'");
$dsis=mysqli_fetch_array($qsis); $nosis=$dsis['no'];
			if (! empty($_FILES['gambar'] ['tmp_name'])){
				$nama=mysql_escape_string(strip_tags($_POST['nama']));
				$gambar=$_FILES['gambar']['tmp_name'];
				$gambar_name=$_FILES['gambar']['name'];
				$gambar_size=$_FILES['gambar']['size'];
				$gambar_type=$_FILES['gambar']['type'];
				$acak=rand(00000000,99999999);
				$judul_baru=$acak.$gambar_name;
				$judul_baru=str_replace(" ","",$judul_baru);
				$gambar_dimensi=getimagesize($gambar);
				if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ echo "Gambar Tidak Valid"; }
				elseif ($gambar_dimensi['0']>"2000" or $gambar_dimensi['1']>"2000") { echo "Dimensi Terlalu Besar,Maksimal 2000"; } 
				elseif ($gambar_size>"1000000") { echo "Ukuran File Terlalu Besar,Maksimal 10MB"; } 
				else {
					unset($_SESSION['kode']);
					$cekupload=new ValidasiUpload($gambar,$judul_baru);
					$cekupload->putGambarType($gambar_type);
					if (!$cekupload->validGambar()){?>
					<div class="success"><h3>File Tidak Valid.</h3></div>
					<a href="//<?php echo $linksub."/".$link;?>" title="Kembali">Kembali</a><?php
						exit;
					}
					if ($cekupload->validGambar()){
						mysqli_query($koneksi, "INSERT INTO psb_dokumen(subdomain,judul,link,nisn,gambar,tgl) VALUES('$subdomain','$nama','$nama','$nisn','$judul_baru',now())");			
						copy ($gambar, "$folder/picture/".$judul_baru);
						$uploader->uploadPicture($judul_baru);
					}
					
					
					?>
					<div class="success"><h3>Data Berhasil Disimpan.</h3></div>
					<a href="//<?php echo $linksub."/".$link;?>" title="Kembali">Kembali</a><?php
				}
			}
			
		}
		
	}
}

function ubah_dokumen($linksub,$subdomain,$link,$nisn,$id_dokumen,$folder){
    include_once($folder."/function/validasiupload.php");
	$query=mysqli_query($koneksi, "select * from psb_dokumen where subdomain='$subdomain' AND no='$id_dokumen' AND nisn='$nisn'");
	$data=mysqli_fetch_array($query);
	$jumlah=mysqli_num_rows($query);
	$no=$data['no'];
	$judul=$data['judul'];
	$gambarasal=$data['gambar'];
	global $uploader;
	if ($jumlah<1){?>
		<div class="success"><h3>Data Tersebut Tidak Ada.</h3></div><br/>
		<a href="//<?php echo $linksub."/".$link;?>" title="Kembali">Kembali</a><?php
	}
	else {
		if (empty($_POST['proses'])){ ?>
		<form action="" method="post" id="form1" autocomplete="off" enctype="multipart/form-data">
			<div id="view"><div class="view_label">Nama File</div><div class="view_dot">:</div><div class="view_content"><input type="text" value="<?php echo $judul;?>" name="nama" id="nama" style="width:94%; max-width:400px;" maxlength="50"></div></div>
			<div id="view"><div class="view_label">Gambar</div><div class="view_dot">:</div><div class="view_content"><input type="file" value="<?php echo $gambarasal;?>" name="gambar" id="gambar" style="width:94%; max-width:400px;" maxlength="150"></div></div>
			<input type="hidden" name="proses" value="simpan">
			<div id="view"><div class="view_label">&nbsp;</div><div class="view_dot">&nbsp;</div><div class="view_content"><input type="submit" value="Ubah" id="submit"  class="button_add"></div></div>
		</form><?php 
		$kode=rand(9079878,834756348);
		$_SESSION['kode']=$kode;
		
		}
		else if ($_POST['proses']=="simpan"){
			if (empty($_SESSION['kode'])){
				echo "<script>document.location='//$linksub/$link';</script>";
			}
			else {
				$nama=mysql_escape_string(strip_tags($_POST['nama']));
				if (! empty($_FILES['gambar'] ['tmp_name'])){
					$gambar=$_FILES['gambar']['tmp_name'];
					$gambar_name=$_FILES['gambar']['name'];
					$gambar_size=$_FILES['gambar']['size'];
					$gambar_type=$_FILES['gambar']['type'];
					$acak=rand(00000000,99999999);
					$judul_baru=$acak.$gambar_name;
					$judul_baru=str_replace(" ","",$judul_baru);
					$gambar_dimensi=getimagesize($gambar);
					if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ echo "Gambar Tidak Valid"; }
					elseif ($gambar_dimensi['0']>"2000" or $gambar_dimensi['1']>"2000") { echo "Dimensi Terlalu Besar,Maksimal 2000"; } 
					elseif ($gambar_size>"1000000") { echo "Ukuran File Terlalu Besar,Maksimal 10MB"; } 
					else {
						mysqli_query($koneksi, "UPDATE psb_dokumen set judul='$nama',gambar='$judul_baru' where no='$no' AND subdomain='$subdomain' AND nisn='$nisn'");
						unlink($folder."/picture/".$gambarasal);
						$uploader->deletePicture($gambarasal);
						$content=file_get_contents($judul_baru);
						if (!preg_match('/\<\?php/i', $content)) {
							copy ($gambar, "$folder/picture/".$judul_baru);
							$uploader->uploadPicture($judul_baru);
						}
						?>
						<div class="success"><h3>Data Berhasil Dirubah.</h3></div>
						<a href="//<?php echo $linksub."/".$link;?>" title="Kembali">Kembali</a><?php
						unset($_SESSION['kode']);
					}
				}
				else {
					mysqli_query($koneksi, "UPDATE psb_dokumen set judul='$nama' where no='$no' AND subdomain='$subdomain' AND nisn='$nisn'");?>
					<div class="success"><h3>Data Berhasil Dirubah.</h3></div>
					<a href="//<?php echo $linksub."/".$link;?>" title="Kembali">Kembali</a><?php
					unset($_SESSION['kode']);
				}
				
			}
			
		}
	}
	
}

function hapus_dokumen($linksub,$subdomain,$link,$nisn,$id_dokumen,$folder){
	$query=mysqli_query($koneksi, "select * from psb_dokumen where subdomain='$subdomain' AND no='$id_dokumen' AND nisn='$nisn'");
	$data=mysqli_fetch_array($query);
	$jumlah=mysqli_num_rows($query);
	$no=$data['no'];
	$judul=$data['judul'];
	$gambarasal=$data['gambar'];
	global $uploader;
	mysqli_query ("DELETE from psb_dokumen WHERE subdomain='$subdomain' AND no='$id_dokumen' AND nisn='$nisn'");
	if (is_file($folder."/picture/".$gambarasal)){
		//unlink($folder."/picture/".$gambarasal);
		//$uploader->deletePicture($gambarasal);
	} ?>
	<div class="success"><h3>Data Berhasil Di Hapus.</h3></div>
	<a href="//<?php echo $linksub."/".$link;?>" title="Kembali">Kembali</a><?php
}

if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	else if( $akses=="member"){
		$nisn=$_SESSION['nisn'];
		if (uri(2)=="dokumen" && !uri(3)){
			dokumen_tampil($linksub,$subdomain,$link,$nisn,$domain);
		}
		else if (uri(2)=="dokumen" && uri(3)=="tambah"){
			tambah_dokumen($linksub,$subdomain,$link,$nisn,$folder);
			
		}
		else if (uri(2)=="dokumen" && uri(3)=="ubah" && (int) uri(4)){
			$id_dokumen= (int) uri(4);
			ubah_dokumen($linksub,$subdomain,$link,$nisn,$id_dokumen,$folder);
		}
		else if (uri(2)=="dokumen" && uri(3)=="hapus" && (int) uri(4)){
			$id_dokumen= (int) uri(4);
			hapus_dokumen($linksub,$subdomain,$link,$nisn,$id_dokumen,$folder);
		}
		else {
			dokumen_tampil($linksub,$subdomain,$link,$nisn,$domain);
		}
		
		
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket']; $aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan profesional.<?php
		}
		else {
			if ($aktif==0) { ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php }
			else {
				$judulmod="Dokumen Pendukung";
				$tabel="psb_dokumen";
				$batas=30;
				$kolom="judul";
				$lebar="200";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				// Lihat
				$jumdetail="multi";
				$tipedetail="table-pict";
				$isidetail="judul";
				// Delete
				$tipedelete="gambar";
				// Tambah
				$jenisinput="gambar";
				$onclick="cekJudul";
				$tipeinput="gambar";
				$forminput="judul,gambar";
				// Tambah & Edit Rinci
				$jenisinputrinci="gambar";
				$onclickrinci="cekJudul";
				$tipeinputrinci="gambar";
				$forminputrinci="judul,gambar";
				$formeditrinci="judul,gambar";
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