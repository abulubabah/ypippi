<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){ 
	    $module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free" or $paket=="basic") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket Profesional.<?php
		}
		else {
			if ($aktif==0){
				?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
			}
			else {
				$query=mysqli_query($koneksi, "SELECT * FROM psb_setting WHERE subdomain='$subdomain'");
				$jumlah=mysqli_num_rows($query);
				$data=mysqli_fetch_array($query);
				$head1=$data['head1']; $tanggal_tutup=$data['tanggal_tutup']; $jam_tutup=$data['jam_tutup']; 
				$head2=$data['head2']; 
				$head3=$data['head3']; 
				$alamat=$data['alamat']; 
				$logo=$data['logo'];
				$logo2=$data['logo2'];
				$linkhalaman=$linksub."/".$adm."/".$mod;
				if ($jumlah>0) { $ada="1"; } 
				else { $ada=0; 
					$head1=""; $head2=""; $head3=""; $alamat=""; $tahun_ajaran=""; $tanggal_buka=""; $jam_buka="";  $logo=""; $logo2="";
					$tempat_keputusan=""; $tanggal_keputusan=""; $nama_kepsek=""; $nip_kepsek=""; $ttd_kepsek=""; $stempel="";
				}
				if (empty($_POST['proses'])) { ?>
					<h2>Kop Surat PPDB</h2>
					<form action="" method="post" enctype="multipart/form-data">
						<input name="proses" type="hidden" value="edit"/>
						<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
							<tr><td width="160">Header 1</td><td><input type="text" name="head1" id="head1" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $head1;?>" required/></td></tr>
							<tr><td>Header 2</td><td><input type="text" name="head2" id="head2" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $head2;?>" required/></td></tr>
							<tr><td>Header 3</td><td><input type="text" name="head3" id="head3" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $head3;?>" required/></td></tr>
							<tr><td>Alamat Kop</td><td><input type="text" name="alamat" id="alamat" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $alamat;?>" required/></td></tr>
							<tr><td>Logo Kiri</td><td><input type="file" name="logo" id="logo" style="width:95%;max-width:500px;" maxlength="200" /></td></tr>
							<tr><td>Logo Kanan</td><td><input type="file" name="logo2" id="logo2" style="width:95%;max-width:500px;" maxlength="200" /></td></tr>
<tr><td>Tanggal Tutup</td><td><input type="text" name="tanggal_tutup" id="tanggal_tutup" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $tanggal_tutup;?>" required/></td></tr>
<tr><td>Jam Tutup</td><td><input type="text" name="jam_tutup" id="jam_tutup" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $jam_tutup;?>" required/></td></tr>
							<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></tr> 
						</table>
					</form><?php
					$randkode=rand(111111,999999); 
					$_SESSION['kode']=$randkode;
				}
				elseif ($_POST['proses']=="edit") {
					if (empty($_SESSION['kode'])) {?>
						<h3>Pengaturan Kop Surat Berhasil Disimpan</h3>Selamat, Pengaturan Kop Surat Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
					}
					else {
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						$head1=strip_tags($_POST['head1']); $head1=str_replace('"','',$head1); $head1=str_replace("'","",$head1);
						$head2=strip_tags($_POST['head2']); $head2=str_replace('"','',$head2); $head2=str_replace("'","",$head2);
						$head3=strip_tags($_POST['head3']); $head3=str_replace('"','',$head3); $head3=str_replace("'","",$head3);
						$tanggal_tutup=strip_tags($_POST['tanggal_tutup']); $tanggal_tutup=str_replace('"','',$tanggal_tutup); $tanggal_tutup=str_replace("'","",$tanggal_tutup);
						$jam_tutup=strip_tags($_POST['jam_tutup']); $jam_tutup=str_replace('"','',$jam_tutup); $jam_tutup=str_replace("'","",$jam_tutup);
						$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
						include($folder.'/function/validasiupload.php');
						if ($jumlah==1) { 
							mysqli_query($koneksi, "UPDATE psb_setting SET head1='$head1', head2='$head2', head3='$head3', alamat='$alamat', tanggal_tutup='$tanggal_tutup', jam_tutup='$jam_tutup' WHERE subdomain='$subdomain'"); 
						}
						else { 
							mysqli_query($koneksi, "INSERT INTO psb_setting (subdomain, head1, head2, head3, alamat, tanggal_tutup, jam_tutup,  tgl) VALUES ('$subdomain', '$head1', '$head2', '$head3', '$alamat', '$tanggal_tutup', '$jam_tutup', sysdate())"); 
						} 									
						if ($_FILES['logo']['tmp_name']=="") { } 
						else {
							$logo=$_FILES['logo']['tmp_name']; $logo_name=$_FILES['logo']['name']; $logo_size=$_FILES['logo']['size']; $logo_type=$_FILES['logo']['type'];
							$acak=rand(00000000,99999999);
							$logo_baru=$acak.$logo_name; $logo_baru=str_replace(" ","",$logo_baru);
							
							$image=new ValidasiUpload($logo,$logo_baru);
							$image->putGambarType($logo_type);
							if (!$image->validGambar()){
								echo "Gambar Tidak Valid";
								exit;
							}
							copy ($logo, "$folder/picture/".$logo_baru);	
							mysqli_query($koneksi, "UPDATE psb_setting SET logo='$logo_baru' WHERE subdomain='$subdomain'");
							$uploader->uploadPicture($logo_baru);

						} 
						if ($_FILES['logo2']['tmp_name']=="") { } 
						else {
							$logo2=$_FILES['logo2']['tmp_name']; $logo2_name=$_FILES['logo2']['name']; $logo2_size=$_FILES['logo2']['size']; $logo2_type=$_FILES['logo2']['type'];
							$acak=rand(00000000,99999999);
							$logo2_baru=$acak.$logo2_name; $logo2_baru=str_replace(" ","",$logo2_baru);
							$image=new ValidasiUpload($logo2,$logo2_baru);
							$image->putGambarType($logo2_type);
							if (!$image->validGambar()){
								echo "Gambar Tidak Valid";
								exit;
							}
							copy ($logo2, "$folder/picture/".$logo2_baru);	
							
							mysqli_query($koneksi, "UPDATE psb_setting SET logo2='$logo2_baru' WHERE subdomain='$subdomain'");
							$uploader->uploadPicture($logo2_baru);
						} 
						?>
						<h3>Setting Kop Surat Berhasil Disimpan</h3>Selamat, Setting Kop Surat Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
					}
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