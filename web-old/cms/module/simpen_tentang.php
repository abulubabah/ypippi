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
				$query=mysqli_query($koneksi, "SELECT judul,isi,gambar FROM simpen_halaman WHERE subdomain='$subdomain' AND link='tentang'");
				$jumlah=mysqli_num_rows($query);
				$data=mysqli_fetch_array($query);
				$judul=$data['judul']; 
				$isi=$data['isi']; 
				$gambar=$data['gambar']; 
				$linkhalaman=$linksub."/".$adm."/".$mod;
				if ($jumlah>0) { $ada="1"; } 
				else { $judul=""; $isi=""; $gambar=""; $ada=0; }
				if (empty($_POST['proses'])) { ?>
					<h2>Tentang Simpen</h2>
					<form action="" method="post" enctype="multipart/form-data">
						<input name="proses" type="hidden" value="edit"/>
						<input type="hidden" name="gambarlama" id="gambarlama" value="<?php echo $gambar;?>"/>
						<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
							<tr><td width="140">Judul</td><td><input type="text" name="judul" id="judul" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $judul;?>" required/></td></tr>
							<tr><td>Isi</td><td><textarea name="isi" id="editor" style="width:95%;max-width:505px;" rows="12"><?php echo $isi;?></textarea></td></tr><?php
							if ($gambar=="") { } else { ?><tr><td></td><td><img src="<?php echo $module->getHttp();?>://<?php echo $domain."/picture/".$gambar;?>" alt="gambar" width="100"/></td></tr><?php } ?>
							<tr><td>Gambar</td><td><input type="file" name="gambar" id="gambar" style="width:95%; max-width:500px; padding:0px; padding-right:5px;"></td></tr>
							<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></tr> 
						</table>
					</form><?php
					$randkode=rand(111111,999999); 
					$_SESSION['kode']=$randkode;
				}
				elseif ($_POST['proses']=="edit") {
					if (empty($_SESSION['kode'])) {?>
						<h3>Tentang Simpen Berhasil Disimpan</h3>Selamat, Tentang Simpen Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
					}
					else {
						if ($_FILES['gambar']['tmp_name']=="") {
							if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
							$judul=strip_tags($_POST['judul']); $judul=str_replace('"','',$judul); $judul=str_replace("'","",$judul);
							$isi=str_replace("'","",$_POST['isi']); $isi=str_replace('"','',$isi);
							if ($jumlah==1) { mysqli_query($koneksi, "UPDATE simpen_halaman SET judul='$judul', isi='$isi' WHERE subdomain='$subdomain' AND link='tentang'"); }
							else { mysqli_query($koneksi, "INSERT INTO simpen_halaman (subdomain, judul, link, isi, tgl) VALUES ('$subdomain', '$judul', 'tentang', '$isi', sysdate())"); } ?>
							<h3>Tentang Simpen Berhasil Disimpan</h3>Selamat, Tentang Simpen Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
						} 
						else {
							$gambar=$_FILES['gambar']['tmp_name'];
							$header_name=$_FILES['gambar']['name'];
							$header_size=$_FILES['gambar']['size'];
							$header_type=$_FILES['gambar']['type'];
							$acak=rand(00000000,99999999);
							$judul_baru=$acak.$header_name;
							$judul_baru=str_replace(" ","",$judul_baru);
							$header_dimensi=getimagesize($gambar);
							if ($header_type!="image/jpg" and $header_type!="image/png" and $header_type!="image/gif" and $header_type!="image/jpeg"){ ?>
								<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
							} 
							elseif ($header_dimensi['0']>"1000" or $header_dimensi['1']>"1000") { ?>
								<h3>Resolusi File Terlalu Besar</h3>Maaf, Resolusi Gambar Maksimal 1000X1000 pixels<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
							} 
							else {
								if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
								include($folder.'/function/validasiupload.php');
								$image=new ValidasiUpload($gambar,$judul_baru);
								$image->putGambarType($header_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								$judul=strip_tags($_POST['judul']); $judul=str_replace('"','',$judul); $judul=str_replace("'","",$judul);
								$isi=str_replace("'","",$_POST['isi']); $isi=str_replace('"','',$isi);
								if ($jumlah==1) { mysqli_query($koneksi, "UPDATE simpen_halaman SET judul='$judul', isi='$isi', gambar='$judul_baru' WHERE subdomain='$subdomain' AND link='tentang'"); }
								else { mysqli_query($koneksi, "INSERT INTO simpen_halaman (subdomain, judul, link, isi, gambar, tgl) VALUES ('$subdomain', '$judul', 'tentang', '$isi', '$judul_baru', sysdate())"); }
								copy ($gambar, "$folder/picture/".$judul_baru);
								$uploader->uploadPicture($judul_baru);
								if($_POST['gambarlama']==""){ } else { /*unlink("$folder/picture/".$_POST['gambarlama']);*/ } ?>
								<h3>Tentang Simpen Berhasil Disimpan</h3>Selamat, Tentang Simpen Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
							}
						}
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