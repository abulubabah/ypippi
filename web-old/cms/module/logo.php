<?php
if ($tampil==1) {   
	if(empty($akses)){ 
		header("location:index.php"); 
	} 
	elseif($akses=="admin" or $akses=="super"){ 
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);	
		$query=mysqli_query($koneksi, "SELECT logo FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$logo=$data['logo'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		$linktataletak=$linksub."/".$adm."/tataletak";
		if (empty($_POST['proses'])) { ?>
			<h2>Logo</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<input name="proses" type="hidden" value="edit"/>
				<input type="hidden" name="logolama" id="logolama" value="<?php echo $logo;?>"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0"><?php
					if ($logo=="") { } else { ?><tr><td></td><td><img src="<?php echo $module->getHttp();?>://<?php echo $domain."/picture/".$logo;?>" alt="logo" style="width:95%; max-width:200px;"/></td></tr><?php } ?>					
					<tr><td width="140">Pilih Gambar</td><td><input type="file" name="logo" id="logo" style="width:95%; max-width:300px; padding:0px;"/></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return ceklogo();" class="button"/></td></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?> 
				<h3>Logo Berhasil Disimpan</h3>Selamat, Logo Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if ($_FILES['logo']['tmp_name']=="") {  ?>
					<h3>Gambar Masih Kosong</h3>Maaf, Gambar Harus Diisi<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
				} 
				else {
					$logo=$_FILES['logo']['tmp_name'];
					$logo_name=$_FILES['logo']['name'];
					$logo_size=$_FILES['logo']['size'];
					$logo_type=$_FILES['logo']['type'];
					$acak=rand(00000000,99999999);
					$judul_baru=$acak.$logo_name;
					$judul_baru=str_replace(" ","",$judul_baru);
					$logo_dimensi=getimagesize($logo);
					if ($logo_type!="image/jpg" and $logo_type!="image/png" and $logo_type!="image/gif" and $logo_type!="image/jpeg"){ ?>
						<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
					} 
					elseif ($logo_dimensi['0']>"1000" or $logo_dimensi['1']>"1000") { ?>
						<h3>Resolusi File Terlalu Besar</h3>Maaf, Resolusi Gambar Maksimal 1000X1000 pixels<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
					} 
					else {
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						include ($folder.'/function/validasiupload.php');
						$image=new ValidasiUpload($logo,$judul_baru);
						$image->putGambarType($logo_type);
						if (!$image->validGambar()){?>
							<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
							exit;
						}
						mysqli_query($koneksi, "UPDATE setting SET logo='$judul_baru' WHERE subdomain='$subdomain'");
						copy ($logo, "$folder/picture/".$judul_baru);
						$uploader->uploadPicture($judul_baru);
						if($_POST['logolama']==""){ } else { /*unlink("$folder/picture/".$_POST['logolama']); $uploader->deletePicture($judul_baru);*/ }  ?>
						<h3>Logo Berhasil Disimpan</h3>Selamat, Logo Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
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